<?php
$conn = new mysqli("localhost", "root", "", "naga_hytam");
$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = $_POST['tanggal'];
    $nama = $_POST['nama'];
    $divisi = $_POST['divisi'];
    $deskripsi = $_POST['deskripsi'];

    $stmt = $conn->prepare("UPDATE laporan_kerja SET tanggal=?, nama=?, divisi=?, deskripsi=? WHERE id=?");
    $stmt->bind_param("ssssi", $tanggal, $nama, $divisi, $deskripsi, $id);
    $stmt->execute();

    header("Location: laporan_kerja.php");
    exit;
}

$result = $conn->query("SELECT * FROM laporan_kerja WHERE id=$id");
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Laporan Kerja</title>
  <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
  <div class="container py-4">
    <a href="laporan_kerja.php" class="btn btn-outline-secondary mb-3">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <div class="card shadow-sm">
      <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">Edit Laporan Kerja</h4>
      </div>
      <div class="card-body">
        <form method="post">
          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= htmlspecialchars($data['tanggal']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="divisi" class="form-label">Divisi</label>
            <input type="text" class="form-control" id="divisi" name="divisi" value="<?= htmlspecialchars($data['divisi']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
          </div>

          <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Update
          </button>
        </form>
      </div>
    </div>
  </div>

  <script src="bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
