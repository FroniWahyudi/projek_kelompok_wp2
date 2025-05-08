<?php
// slip_gaji.php - menampilkan data slip gaji karyawan
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

$userId  = $_SESSION['user_id'];
$role    = $_SESSION['role'] ?? '';
// dapatkan periode dari query, default bulan ini (YYYY-MM)
$periode = $_GET['periode'] ?? date('Y-m');

// ambil slip gaji
if ($role === 'HR') {
    $sql = 'SELECT p.id, p.user_id, u.name, p.periode, p.gaji_pokok, p.tunjangan, p.potongan, p.total_gaji, p.created_at
            FROM payrolls p
            JOIN users u ON p.user_id = u.id
            WHERE p.periode = ?';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $periode);
} else {
    $sql = 'SELECT p.id, p.user_id, u.name, p.periode, p.gaji_pokok, p.tunjangan, p.potongan, p.total_gaji, p.created_at
            FROM payrolls p
            JOIN users u ON p.user_id = u.id
            WHERE p.user_id = ? AND p.periode = ?';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('is', $userId, $periode);
}
$stmt->execute();
$slips = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Slip Gaji - Periode <?= htmlspecialchars($periode) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="d-flex justify-content-between mb-4">
      <h4>Slip Gaji - Periode <?= htmlspecialchars($periode) ?></h4>
      <div>
        <?php if ($role === 'HR'): ?>
          <a href="buat_slip.php?periode=<?= urlencode($periode) ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Slip
          </a>
        <?php endif; ?>
        <a href="dashboard.php" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Dashboard
        </a>
      </div>
    </div>

    <?php if ($slips->num_rows === 0): ?>
      <div class="alert alert-warning">Belum ada slip gaji untuk periode <strong><?= htmlspecialchars($periode) ?></strong>.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Gaji Pokok</th>
              <th>Tunjangan</th>
              <th>Potongan</th>
              <th>Total</th>
              <th>Waktu Dibuat</th>
              <?php if ($role === 'HR'): ?>
                <th>Aksi</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $slips->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars((string)$row['id']) ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td>Rp <?= number_format((float)$row['gaji_pokok'], 2, ',', '.') ?></td>
              <td>Rp <?= number_format((float)$row['tunjangan'], 2, ',', '.') ?></td>
              <td>Rp <?= number_format((float)$row['potongan'], 2, ',', '.') ?></td>
              <td>Rp <?= number_format((float)$row['total_gaji'], 2, ',', '.') ?></td>
              <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($row['created_at']))) ?></td>
              <?php if ($role === 'HR'): ?>
              <td>
                <a href="buat_slip.php?periode=<?= urlencode($row['periode']) ?>&user_id=<?= urlencode((string)$row['user_id']) ?>&id=<?= urlencode((string)$row['id']) ?>" class="btn btn-sm btn-warning">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="buat_slip.php?periode=<?= urlencode($row['periode']) ?>&delete_id=<?= urlencode((string)$row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus slip ID <?= htmlspecialchars((string)$row['id']) ?>?');">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
              <?php endif; ?>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>