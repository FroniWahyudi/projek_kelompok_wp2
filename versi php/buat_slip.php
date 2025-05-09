<?php
// buat_slip.php - halaman khusus untuk insert slip gaji
declare(strict_types=1);
session_start();

// cek hak akses HR
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'HR') {
    header('Location: dashboard.php');
    exit();
}

// koneksi database
$mysqli = new mysqli('localhost', 'root', '', 'naga_hytam');
if ($mysqli->connect_error) {
    die('Koneksi gagal: ' . $mysqli->connect_error);
}

// ambil daftar karyawan role Karyawan untuk dropdown
$empStmt = $mysqli->prepare('SELECT id, name FROM users WHERE role = ?');
$role = 'Karyawan';
$empStmt->bind_param('s', $role);
$empStmt->execute();
$employees = $empStmt->get_result();

// tentukan periode (dari query atau default bulan ini)
$periode = $_GET['periode'] ?? date('Y-m');

// proses form submit: hanya insert
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId    = (int)$_POST['user_id'];
    $gajiPokok = (float)str_replace(',', '.', $_POST['gaji_pokok']);
    $tunjangan = (float)str_replace(',', '.', $_POST['tunjangan']);
    $potongan  = (float)str_replace(',', '.', $_POST['potongan']);

    $stmt = $mysqli->prepare(
        'INSERT INTO payrolls (user_id, periode, gaji_pokok, tunjangan, potongan)
         VALUES (?, ?, ?, ?, ?)'
    );
    $stmt->bind_param('isddd', $userId, $periode, $gajiPokok, $tunjangan, $potongan);
    $stmt->execute();

    // redirect ke halaman tampilan slip
    header("Location: slip_gaji.php?user_id={$userId}&periode={$periode}");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buat Slip Gaji - Periode <?= htmlspecialchars($periode) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <a href="slip_gaji.php?periode=<?= htmlspecialchars($periode) ?>" class="btn btn-secondary mb-4">
      <i class="fas fa-arrow-left"></i> Kembali ke Slip Gaji
    </a>

    <div class="card mx-auto" style="max-width: 500px;">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Buat Slip Gaji - Periode <?= htmlspecialchars($periode) ?></h5>
      </div>
      <div class="card-body">
        <form method="post">
          <div class="mb-3">
            <label for="user_id" class="form-label">Nama Karyawan</label>
            <select name="user_id" id="user_id" class="form-select" required>
              <option value="">-- Pilih Karyawan --</option>
              <?php while ($emp = $employees->fetch_assoc()): ?>
                <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['name']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="gaji_pokok" class="form-label">Gaji Pokok (Rp)</label>
            <input type="text" name="gaji_pokok" id="gaji_pokok" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="tunjangan" class="form-label">Tunjangan (Rp)</label>
            <input type="text" name="tunjangan" id="tunjangan" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="potongan" class="form-label">Potongan (Rp)</label>
            <input type="text" name="potongan" id="potongan" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-success w-100">
            <i class="fas fa-save"></i> Simpan Slip
          </button>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
