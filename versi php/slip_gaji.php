<?php
declare(strict_types=1);
session_start();

// autentikasi user
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// koneksi database
$mysqli = new mysqli('localhost', 'root', '', 'naga_hytam');
if ($mysqli->connect_error) {
    die('Koneksi gagal: ' . $mysqli->connect_error);
}

$userId = $_SESSION['user_id'];
$role   = $_SESSION['role'] ?? '';

// FILTER BULAN (input month saja)
$periode = $_GET['periode_month'] ?? date('Y-m');

// HANDLE DELETE
if ($role === 'HR' && isset($_GET['delete_id'])) {
    $deleteId = (int) $_GET['delete_id'];
    $delStmt = $mysqli->prepare('DELETE FROM payrolls WHERE id = ?');
    $delStmt->bind_param('i', $deleteId);
    $delStmt->execute();
    $delStmt->close();
    header('Location: slip_gaji.php?periode_month=' . urlencode($periode));
    exit();
}

// ambil slip gaji sesuai filter bulan
if ($role === 'HR') {
    $sql = '
      SELECT p.id, p.user_id, u.name, p.periode, p.gaji_pokok, p.tunjangan,
             p.potongan, p.total_gaji, p.created_at
      FROM payrolls p
      JOIN users u ON p.user_id = u.id
      WHERE p.periode = ?
      ORDER BY u.name
    ';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $periode);
} else {
    $sql = '
      SELECT p.id, p.user_id, u.name, p.periode, p.gaji_pokok, p.tunjangan,
             p.potongan, p.total_gaji, p.created_at
      FROM payrolls p
      JOIN users u ON p.user_id = u.id
      WHERE p.user_id = ? AND p.periode = ?
      ORDER BY u.name
    ';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('is', $userId, $periode);
}
$stmt->execute();
$slips = $stmt->get_result();

// hitung total gaji untuk ringkasan
$totalSummary = 0;
while ($row = $slips->fetch_assoc()) {
    $totalSummary += (float)$row['total_gaji'];
}
$slips->data_seek(0);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Slip Gaji - Periode <?= htmlspecialchars($periode) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #F5F7FA; }
    .card-payroll { border-radius: .5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .fab {
      position: fixed; bottom: 2rem; right: 2rem;
      width: 56px; height: 56px; background: #003366; color: #fff;
      border-radius: 50%; display: flex; align-items: center;
      justify-content: center; font-size: 1.5rem; box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    .fab:hover { background: #002244; }
  </style>
</head>
<body>
  <div class="container py-5">

    <!-- Tombol Home -->
    <div class="mb-3">
      <a href="dashboard.php" class="btn btn-outline-secondary">
        <i class="fas fa-home me-1"></i> Home
      </a>
    </div>

    <!-- FILTER BULAN -->
    <form class="mb-4" method="get">
      <label class="form-label">Pilih Bulan:</label>
      <input type="month"
             name="periode_month"
             class="form-control w-auto d-inline-block"
             value="<?= htmlspecialchars($periode) ?>"
             onchange="this.form.submit()">
    </form>

    <!-- RINGKASAN TOTAL -->
    <div class="card mb-4">
      <div class="card-body bg-white text-center">
        <h5 class="mb-0">Total Gaji Bulan <?= htmlspecialchars($periode) ?></h5>
        <h2 class="fw-bold">Rp <?= number_format($totalSummary, 2, ',', '.') ?></h2>
      </div>
    </div>

    <!-- KARTU SLIP GAJI -->
    <div class="row g-4">
      <?php if ($slips->num_rows === 0): ?>
        <div class="alert alert-warning">
          Belum ada slip gaji untuk periode <strong><?= htmlspecialchars($periode) ?></strong>.
        </div>
      <?php else: ?>
        <?php while ($row = $slips->fetch_assoc()): ?>
          <div class="col-md-6 col-lg-4">
            <div class="card card-payroll p-3 bg-white">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                  <i class="fas fa-user-circle fa-2x text-secondary me-2"></i>
                  <h6 class="mb-0"><?= htmlspecialchars($row['name']) ?></h6>
                </div>
                <?php if ($role === 'HR'): ?>
                  <div>
                    <a href="buat_slip.php?periode_month=<?= urlencode($periode) ?>&user_id=<?= $row['user_id'] ?>&id=<?= $row['id'] ?>"
                       class="text-warning me-2"><i class="fas fa-edit"></i></a>
                    <a href="slip_gaji.php?periode_month=<?= urlencode($periode) ?>&delete_id=<?= $row['id'] ?>"
                       class="text-danger"
                       onclick="return confirm('Hapus slip ID <?= $row['id'] ?>?')">
                      <i class="fas fa-trash"></i>
                    </a>
                  </div>
                <?php endif; ?>
              </div>
              <div class="row">
                <div class="col-6">
                  <p class="mb-1"><i class="fas fa-receipt text-primary me-1"></i> Gaji Pokok</p>
                  <p class="mb-1"><i class="fas fa-plus-circle text-primary me-1"></i> Tunjangan</p>
                  <p class="mb-1"><i class="fas fa-minus-circle text-primary me-1"></i> Potongan</p>
                  <p class="mb-1"><i class="fas fa-chart-line text-primary me-1"></i> Total</p>
                  <p class="mb-0"><i class="fas fa-clock text-primary me-1"></i> Dibuat</p>
                </div>
                <div class="col-6 text-end">
                  <p class="mb-1">Rp <?= number_format((float)$row['gaji_pokok'], 2, ',', '.') ?></p>
                  <p class="mb-1">Rp <?= number_format((float)$row['tunjangan'], 2, ',', '.') ?></p>
                  <p class="mb-1">Rp <?= number_format((float)$row['potongan'], 2, ',', '.') ?></p>
                  <p class="mb-1">Rp <?= number_format((float)$row['total_gaji'], 2, ',', '.') ?></p>
                  <p class="mb-0"><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></p>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>

    <!-- FLOATING ACTION BUTTON -->
    <?php if ($role === 'HR'): ?>
      <a href="buat_slip.php?periode_month=<?= urlencode($periode) ?>" class="fab">
        <i class="fas fa-plus"></i>
      </a>
    <?php endif; ?>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
