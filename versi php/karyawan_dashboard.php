<?php
session_start();

// Koneksi
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'naga_hytam';
$conn = new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Koneksi gagal: ".$conn->connect_error);

// Cek login & ambil role
if(!isset($_SESSION['user_id'])) {
  header('Location: login.php'); exit;
}
$user_id = $_SESSION['user_id'];
$q = $conn->query("SELECT role FROM users WHERE id = $user_id");
$role = $q->fetch_assoc()['role'];

// Tahun berjalan
$tahun = date('Y');

// Proses update sisa cuti (hanya HR)
if($role === 'HR' && $_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['sisa_cuti'])) {
  foreach($_POST['sisa_cuti'] as $uid => $sisa) {
    $uid  = intval($uid);
    $sisa = intval($sisa);
    // jika belum ada record, INSERT, else UPDATE
    $conn->query("
      INSERT INTO sisa_cuti (user_id, tahun, total_cuti, cuti_terpakai)
      VALUES ($uid, $tahun, $sisa, 0)
      ON DUPLICATE KEY UPDATE total_cuti = $sisa
    ");
  }
  $msg = "Sisa cuti berhasil disimpan.";
}

// Ambil data karyawan + sisa_cuti tahun ini
$sql = "
  SELECT u.id, u.name, u.email, u.phone, u.photo_url, sc.total_cuti
  FROM users u
  LEFT JOIN sisa_cuti sc 
    ON sc.user_id = u.id AND sc.tahun = $tahun
  WHERE u.role = 'Karyawan'
  ORDER BY u.name
";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Karyawan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <a href="dashboard.php" class="btn btn-light me-3">Home</a>
    <span class="navbar-brand">Dashboard Karyawan</span>
  </div>
</nav>

<main class="container mb-5">
  <?php if(!empty($msg)): ?>
    <div class="alert alert-success"><?= $msg ?></div>
  <?php endif; ?>

  <h3>Data Karyawan</h3>
  <div class="row mb-3">
    <div class="col-md-6">
      <input type="text" id="searchInput" class="form-control" placeholder="Cari nama karyawan..." onkeyup="filterTable()">
    </div>
  </div>

  <form method="POST">
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="karyawanTable">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No. Telepon</th>
            <th>Bio</th>
            <th>Tanggal Dibuat</th>
            <?php if($role==='HR'): ?>
              <th>Sisa Cuti (<?= $tahun ?>)</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody id="karyawanBody">
          <?php $no=1; while($row=$res->fetch_assoc()): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><img src="<?= htmlspecialchars($row['photo_url']) ?>" width="40" height="40" class="rounded-circle"></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['phone']) ?></td>
              <td><?= htmlspecialchars($row['bio'] ?? '') ?></td>
              <td><?= htmlspecialchars($row['created_at'] ?? '') ?></td>
              <?php if($role==='HR'): ?>
                <td>
                  <input type="number" name="sisa_cuti[<?= $row['id'] ?>]" 
                         value="<?= intval($row['total_cuti'] ?? 12) ?>" 
                         class="form-control form-control-sm" min="0">
                </td>
              <?php endif; ?>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <?php if($role==='HR'): ?>
      <button type="submit" class="btn btn-success">
        <i class="bi bi-save me-1"></i> Simpan Sisa Cuti
      </button>
    <?php endif; ?>
  </form>
</main>

<script>
function filterTable() {
  const input = document.getElementById("searchInput").value.toLowerCase();
  document.querySelectorAll("#karyawanBody tr").forEach(row => {
    const nama = row.cells[2].innerText.toLowerCase();
    row.style.display = nama.includes(input) ? "" : "none";
  });
}
</script>
</body>
</html>
<?php $conn->close(); ?>
