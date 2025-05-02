<?php
$conn = new mysqli("localhost", "root", "", "naga_hytam");
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM laporan_kerja WHERE id = $id");
$data = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Laporan Kerja</title>
  <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
  <div class="container py-4">
    <a href="laporan_kerja.php" class="btn btn-outline-dark mb-3">
      <i class="bi bi-arrow-left"></i> Kembali ke Laporan
    </a>

    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Detail Laporan Kerja</h4>
      </div>
      <div class="card-body">
        <p><strong>Tanggal:</strong> <?= htmlspecialchars($data['tanggal']) ?></p>
        <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama']) ?></p>
        <p><strong>Divisi:</strong> <?= htmlspecialchars($data['divisi']) ?></p>
        <p><strong>Deskripsi:</strong><br><?= nl2br(htmlspecialchars($data['deskripsi'])) ?></p>
      </div>
    </div>
  </div>

  <script src="bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
