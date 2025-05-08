<?php
// slip_gaji.php
// Pastikan Anda telah membuat tabel "payrolls" dengan struktur berikut:
/*
CREATE TABLE payrolls (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  periode VARCHAR(7) NOT NULL,  -- format: YYYY-MM
  gaji_pokok DECIMAL(15,2) NOT NULL DEFAULT 0,
  tunjangan DECIMAL(15,2) NOT NULL DEFAULT 0,
  potongan DECIMAL(15,2) NOT NULL DEFAULT 0,
  total_gaji DECIMAL(15,2) AS (gaji_pokok + tunjangan - potongan) STORED,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;
*/

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Koneksi database
$mysqli = new mysqli('localhost', 'root', '', 'naga_hytam');
if ($mysqli->connect_error) {
    die('Koneksi gagal: ' . $mysqli->connect_error);
}

$user_id = $_SESSION['user_id'];
// Ambil periode dari query string, default bulan ini
$periode = isset($_GET['periode']) ? $_GET['periode'] : date('Y-m');

// Ambil data slip gaji (termasuk id untuk CRUD)
$stmt = $mysqli->prepare(
    'SELECT p.id, p.periode, u.name, p.gaji_pokok, p.tunjangan, p.potongan, p.total_gaji
     FROM payrolls p
     JOIN users u ON p.user_id = u.id
     WHERE p.user_id = ? AND p.periode = ?'
);
$stmt->bind_param('is', $user_id, $periode);
$stmt->execute();
$result = $stmt->get_result();
$slip   = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Slip Gaji - <?= htmlspecialchars($periode) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <!-- Tombol Kembali dan CRUD -->
    <div class="mb-4">
      <a href="dashboard.php" class="btn btn-secondary me-2"><i class="fas fa-arrow-left"></i> Kembali</a>
      <?php if (!$slip): ?>
        <a href="buat_slip.php?user_id=<?= $user_id ?>&periode=<?= htmlspecialchars($periode) ?>" class="btn btn-primary">
          <i class="fas fa-plus"></i> Buat Slip
        </a>
      <?php else: ?>
        <a href="edit_slip.php?id=<?= $slip['id'] ?>" class="btn btn-warning me-2">
          <i class="fas fa-edit"></i> Edit Slip
        </a>
        <a href="delete_slip.php?id=<?= $slip['id'] ?>" class="btn btn-danger" onclick="return confirm('Hapus slip gaji?');">
          <i class="fas fa-trash"></i> Hapus Slip
        </a>
      <?php endif; ?>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <?php if (!$slip): ?>
          <div class="alert alert-warning text-center">
            Slip gaji untuk periode <strong><?= htmlspecialchars($periode) ?></strong> belum tersedia.
          </div>
        <?php else: ?>
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">Slip Gaji - Periode <?= htmlspecialchars($slip['periode']) ?></h5>
            </div>
            <div class="card-body">
              <p><strong>Nama:</strong> <?= htmlspecialchars($slip['name']) ?></p>
              <table class="table table-borderless">
                <tr>
                  <th>Gaji Pokok</th>
                  <td>: Rp <?= number_format($slip['gaji_pokok'], 2, ',', '.') ?></td>
                </tr>
                <tr>
                  <th>Tunjangan</th>
                  <td>: Rp <?= number_format($slip['tunjangan'], 2, ',', '.') ?></td>
                </tr>
                <tr>
                  <th>Potongan</th>
                  <td>: Rp <?= number_format($slip['potongan'], 2, ',', '.') ?></td>
                </tr>
                <tr class="fw-bold">
                  <th>Total Gaji</th>
                  <td>: Rp <?= number_format($slip['total_gaji'], 2, ',', '.') ?></td>
                </tr>
              </table>
              <a href="javascript:window.print()" class="btn btn-success">
                <i class="fas fa-print"></i> Cetak Slip
              </a>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>