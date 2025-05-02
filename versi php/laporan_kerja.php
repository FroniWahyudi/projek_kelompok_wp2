<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'naga_hytam'; // Sesuaikan dengan nama database Anda

$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Ambil role user
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resultRole = $stmt->get_result();
$userData = $resultRole->fetch_assoc();
$role = $userData['role'] ?? '';
$stmt->close();


// Ambil data laporan kerja
$sql = "SELECT * FROM laporan_kerja";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Kerja - Naga Hytam</title>
  <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
  <div class="container py-4">
    <a href="dashboard.php" class="btn btn-outline-dark mb-3">
      <i class="bi bi-house-door"></i> Home
    </a>

    <h3 class="mb-4">Laporan Kerja</h3>
    <a href="tambah_laporan.php" class="btn btn-primary mb-3">
      <i class="bi bi-plus"></i> Tambah Laporan
    </a>

    <table class="table table-bordered table-striped">
      <thead class="table-light">
        <tr>
          <th>No</th>
          <th>Tanggal</th>
          <th>Nama</th>
          <th>Divisi</th>
          <th>Deskripsi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): 
          $no = 1;
          while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['tanggal']) ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['divisi']) ?></td>
            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
            <td>
              <a href="detail_laporan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>

              <?php if ($role !== 'Manajer Umum' && $role !== 'Manajer HR'): ?>
                <a href="edit_laporan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <a href="hapus_laporan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus laporan ini?')"><i class="bi bi-trash"></i></a>
              <?php endif; ?>
            </td>

          </tr>
        <?php endwhile; else: ?>
          <tr><td colspan="6" class="text-center">Tidak ada data laporan kerja.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <script src="bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
