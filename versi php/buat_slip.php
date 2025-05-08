<?php
declare(strict_types=1);
// buat_slip.php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'HR') {
    header('Location: dashboard.php');
    exit();
}

// Koneksi database
$mysqli = new mysqli('localhost', 'root', '', 'naga_hytam');
if ($mysqli->connect_error) {
    die('Koneksi gagal: ' . $mysqli->connect_error);
}

// Ambil daftar karyawan
$empStmt = $mysqli->prepare('SELECT id, name FROM users WHERE role = ?');
$roleFilter = 'Karyawan';
$empStmt->bind_param('s', $roleFilter);
$empStmt->execute();
$employees = $empStmt->get_result();

// Ambil parameter
$selected_user = isset($_GET['user_id']) ? (int)$_GET['user_id'] : null;
$periode       = isset($_GET['periode']) ? $_GET['periode'] : date('Y-m');
$edit_id       = isset($_GET['id']) ? (int)$_GET['id'] : null;
$delete_id     = isset($_GET['delete_id']) ? (int)$_GET['delete_id'] : null;

// Hapus data
if ($delete_id) {
    $delStmt = $mysqli->prepare('DELETE FROM payrolls WHERE id = ?');
    $delStmt->bind_param('i', $delete_id);
    $delStmt->execute();
    header("Location: buat_slip.php?periode={$periode}");
    exit();
}

// Jika edit mode, ambil data current
if ($edit_id) {
    $stmt = $mysqli->prepare('SELECT * FROM payrolls WHERE id = ?');
    $stmt->bind_param('i', $edit_id);
    $stmt->execute();
    $current = $stmt->get_result()->fetch_assoc();
    $selected_user = (int)$current['user_id'];
}

// Proses form submit untuk create atau update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_user = (int)$_POST['user_id'];
    $gaji_pokok    = (float)str_replace(',', '.', $_POST['gaji_pokok']);
    $tunjangan     = (float)str_replace(',', '.', $_POST['tunjangan']);
    $potongan      = (float)str_replace(',', '.', $_POST['potongan']);

    if ($edit_id) {
        // Update slip
        $upd = $mysqli->prepare(
            'UPDATE payrolls SET user_id = ?, periode = ?, gaji_pokok = ?, tunjangan = ?, potongan = ? WHERE id = ?'
        );
        $upd->bind_param('isdddi', $selected_user, $periode, $gaji_pokok, $tunjangan, $potongan, $edit_id);
        $upd->execute();
    } else {
        // Insert slip
        $ins = $mysqli->prepare(
            'INSERT INTO payrolls (user_id, periode, gaji_pokok, tunjangan, potongan)
             VALUES (?, ?, ?, ?, ?)'
        );
        $ins->bind_param('isddd', $selected_user, $periode, $gaji_pokok, $tunjangan, $potongan);
        $ins->execute();
    }
    header("Location: buat_slip.php?periode={$periode}");
    exit();
}

// Daftar semua slip untuk periode tertentu
$listStmt = $mysqli->prepare(
    'SELECT p.id, u.name, p.gaji_pokok, p.tunjangan, p.potongan, p.total_gaji, p.periode
     FROM payrolls p
     JOIN users u ON p.user_id = u.id
     WHERE p.periode = ?'
);
$listStmt->bind_param('s', $periode);
$listStmt->execute();
$slips = $listStmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Slip Gaji - <?= htmlspecialchars($periode) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="mb-4">
      <a href="slip_gaji.php?periode=<?= htmlspecialchars($periode) ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
      </a>
    </div>

    <h4>Daftar Slip Gaji (Periode <?= htmlspecialchars($periode) ?>)</h4>
    <table class="table table-striped mt-3">
      <thead>
        <tr>
          <th>#</th>
          <th>Karyawan</th>
          <th>Gaji Pokok</th>
          <th>Tunjangan</th>
          <th>Potongan</th>
          <th>Total</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $slips->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td>Rp <?= number_format($row['gaji_pokok'], 2, ',', '.') ?></td>
          <td>Rp <?= number_format($row['tunjangan'], 2, ',', '.') ?></td>
          <td>Rp <?= number_format($row['potongan'], 2, ',', '.') ?></td>
          <td>Rp <?= number_format($row['total_gaji'], 2, ',', '.') ?></td>
          <td>
            <a href="buat_slip.php?periode=<?= $periode ?>&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
              <i class="fas fa-edit"></i>
            </a>
            <a href="buat_slip.php?periode=<?= $periode ?>&delete_id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus slip ID <?= $row['id'] ?>?');">
              <i class="fas fa-trash"></i>
            </a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <h5 class="mt-5"><?= $edit_id ? 'Edit' : 'Buat' ?> Slip Gaji</h5>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><?= $edit_id ? 'Edit' : 'Buat' ?> Slip Gaji</h5>
          </div>
          <div class="card-body">
            <form method="post">
              <div class="mb-3">
                <label for="user_id" class="form-label">Nama Karyawan</label>
                <select name="user_id" id="user_id" class="form-select" required>
                  <option value="">-- Pilih Karyawan --</option>
                  <?php foreach ($employees as $emp): ?>
                    <option value="<?= $emp['id'] ?>" <?= $emp['id'] === $selected_user ? 'selected' : '' ?>>
                      <?= htmlspecialchars($emp['name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="gaji_pokok" class="form-label">Gaji Pokok (Rp)</label>
                <input type="text" id="gaji_pokok" name="gaji_pokok" value="<?= $current['gaji_pokok'] ?? '' ?>" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="tunjangan" class="form-label">Tunjangan (Rp)</label>
                <input type="text" id="tunjangan" name="tunjangan" value="<?= $current['tunjangan'] ?? '' ?>" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="potongan" class="form-label">Potongan (Rp)</label>
                <input type="text" id="potongan" name="potongan" value="<?= $current['potongan'] ?? '' ?>" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-success w-100">
                <i class="fas fa-save"></i> <?= $edit_id ? 'Update' : 'Simpan' ?>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
