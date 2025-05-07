<?php
// shift_karyawan.php
session_start(); // Mulai session untuk cek role user

// Cek apakah user sudah login dan role tersedia
if (!isset($_SESSION['role'])) {
    // Jika belum login, redirect ke login page
    header('Location: login.php');
    exit;
}

// Koneksi ke database (ganti credentials sesuai)
$host = 'localhost';
$db   = 'naga_hytam';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Tangani form add/edit/delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action'])) {
    // Hanya selain Karyawan yang boleh CRUD
    if ($_SESSION['role'] !== 'Karyawan') {
        if ($_POST['action'] === 'save') {
            $id      = !empty($_POST['shift_id']) ? (int)$_POST['shift_id'] : null;
            $user_id = (int)$_POST['modalNama'];
            $tanggal = $_POST['modalTanggal'];
            $shift   = $_POST['modalShift'];
            if ($id) {
                $stmt = $pdo->prepare('UPDATE shift_karyawan SET user_id=?, tanggal=?, shift=? WHERE id=?');
                $stmt->execute([$user_id, $tanggal, $shift, $id]);
            } else {
                $stmt = $pdo->prepare('INSERT INTO shift_karyawan (user_id, tanggal, shift) VALUES (?, ?, ?)');
                $stmt->execute([$user_id, $tanggal, $shift]);
            }
        }
        if ($_POST['action'] === 'delete' && !empty($_POST['del_id'])) {
            $stmt = $pdo->prepare('DELETE FROM shift_karyawan WHERE id=?');
            $stmt->execute([(int)$_POST['del_id']]);
        }
    }
    header('Location: shift_karyawan.php');
    exit;
}

// Ambil data users untuk dropdown (hanya untuk non-Karyawan)
$users = [];
if ($_SESSION['role'] !== 'Karyawan') {
    $stmt = $pdo->query('SELECT id, name, role, photo_url FROM users ORDER BY name');
    $users = $stmt->fetchAll();
}

// Ambil data shift_karyawan dengan join ke users
$sql = "SELECT sk.id, sk.tanggal, sk.shift,
               u.id AS user_id, u.name, u.role, u.photo_url
        FROM shift_karyawan sk
        JOIN users u ON sk.user_id = u.id
        ORDER BY sk.tanggal DESC, FIELD(sk.shift,'Pagi','Sore')";
$stmt = $pdo->query($sql);
$shifts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shift & Jadwal Karyawan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .badge-shift { min-width: 60px; }
  </style>
</head>
<body>
<div class="container py-4">
  <a href="dashboard.php" class="btn btn-outline-dark mb-3"><i class="bi bi-house-door"></i> Home</a>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Shift & Jadwal Karyawan</h2>
    <?php if ($_SESSION['role'] !== 'Karyawan'): ?>
    <button class="btn btn-success" onclick="openAddModal()"><i class="bi bi-plus-circle"></i> Jadwal Baru</button>
    <?php endif; ?>
  </div>

  <div class="filter-group mb-3">
    <button class="btn btn-outline-primary" onclick="filterShift('All')">Semua</button>
    <button class="btn btn-outline-info" onclick="filterShift('Pagi')">Pagi</button>
    <button class="btn btn-outline-warning" onclick="filterShift('Sore')">Sore</button>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table class="table table-striped align-middle" id="shiftTable">
        <thead class="table-dark">
          <tr>
            <th>#</th><th>Foto</th><th>Nama</th><th>Departemen</th><th>Tanggal</th><th>Shift</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($shifts as $i => $s): ?>
          <tr data-id="<?= $s['id'] ?>" data-user="<?= $s['user_id'] ?>" data-shift="<?= $s['shift'] ?>">
            <td><?= $i+1 ?></td>
            <td><img src="<?= htmlspecialchars($s['photo_url']) ?>" width="40" height="40" class="rounded-circle"></td>
            <td><?= htmlspecialchars($s['name']) ?></td>
            <td><?= htmlspecialchars($s['role']) ?></td>
            <td><?= htmlspecialchars($s['tanggal']) ?></td>
            <td><span class="badge bg-<?= $s['shift']=='Pagi'?'info':'warning' ?> text-dark badge-shift"><?= htmlspecialchars($s['shift']) ?></span></td>
            <td>
              <?php if ($_SESSION['role'] !== 'Karyawan'): ?>
              <button class="btn btn-sm btn-outline-warning" onclick="openEditModal(this)"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-sm btn-outline-danger" onclick="deleteShift(<?= $s['id'] ?>)"><i class="bi bi-trash"></i></button>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Form -->
  <?php if ($_SESSION['role'] !== 'Karyawan'): ?>
  <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="post" action="shift_karyawan.php">
          <div class="modal-header">
            <h5 class="modal-title">Jadwal Shift</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="action" id="formAction" value="save">
            <input type="hidden" name="shift_id" id="shiftId">

            <div class="mb-3">
              <label class="form-label">Nama Karyawan</label>
              <select name="modalNama" id="modalNama" class="form-select" required>
                <option value="" disabled selected>Pilih karyawan...</option>
                <?php foreach ($users as $u): ?>
                <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input type="date" name="modalTanggal" id="modalTanggal" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Shift</label>
              <select name="modalShift" id="modalShift" class="form-select" required>
                <option value="" disabled selected>Pilih shift...</option>
                <option>Pagi</option>
                <option>Sore</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php endif; ?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function filterShift(type) {
  document.querySelectorAll('#shiftTable tbody tr').forEach(r => r.style.display = (type==='All' || r.dataset.shift===type)? '' :'none');
}
function openAddModal() {
  document.getElementById('formAction').value = 'save';
  document.getElementById('shiftId').value = '';
  document.getElementById('modalNama').value = '';
  document.getElementById('modalTanggal').value = '';
  document.getElementById('modalShift').value = '';
  new bootstrap.Modal(document.getElementById('editModal')).show();
}
function openEditModal(btn) {
  const tr = btn.closest('tr');
  document.getElementById('formAction').value = 'save';
  document.getElementById('shiftId').value = tr.dataset.id;
  document.getElementById('modalNama').value = tr.dataset.user;
  document.getElementById('modalTanggal').value = tr.children[4].textContent;
  document.getElementById('modalShift').value = tr.dataset.shift;
  new bootstrap.Modal(document.getElementById('editModal')).show();
}
function deleteShift(id) {
  if (confirm('Hapus jadwal shift ini?')) {
    const f = document.createElement('form'); f.method='post'; f.action='shift_karyawan.php';
    f.innerHTML = `<input type="hidden" name="action" value="delete"><input type="hidden" name="del_id" value="${id}">`;
    document.body.append(f); f.submit();
  }
}
</script>
</body>
</html>
