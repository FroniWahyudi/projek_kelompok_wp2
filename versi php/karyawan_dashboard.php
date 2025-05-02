<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'naga_hytam'; // Ganti dengan nama database Anda

$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data karyawan
$sql = "SELECT * FROM users WHERE role = 'Karyawan'";
$result = $conn->query($sql);
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
    <a class="navbar-brand" href="#">Dashboard Karyawan</a>
  </div>
</nav>



  <main class="container mb-5">
    <h3>Data Karyawan</h3>

    <!-- Pencarian -->
    <div class="row mb-3">
      <div class="col-md-6">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari nama karyawan..." onkeyup="filterTable()">
      </div>
    </div>

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
          </tr>
        </thead>
        <tbody id="karyawanBody">
          <?php if ($result->num_rows > 0): 
              $no = 1;
              while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><img src="<?= htmlspecialchars($row['photo_url']) ?>" alt="Foto <?= htmlspecialchars($row['name']) ?>" width="50" height="50" class="rounded-circle"></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['phone']) ?></td>
              <td><?= htmlspecialchars($row['bio']) ?></td>
              <td><?= htmlspecialchars($row['created_at']) ?></td>
            </tr>
          <?php endwhile; else: ?>
            <tr><td colspan="7" class="text-center">Tidak ada data karyawan.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>

  <script>
    function filterTable() {
      const input = document.getElementById("searchInput").value.toLowerCase();
      const rows = document.querySelectorAll("#karyawanBody tr");

      rows.forEach(row => {
        const nama = row.cells[2].innerText.toLowerCase();
        row.style.display = nama.includes(input) ? "" : "none";
      });
    }
  </script>
</body>
</html>
<?php $conn->close(); ?>
