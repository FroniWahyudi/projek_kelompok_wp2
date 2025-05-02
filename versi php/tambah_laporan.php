<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'naga_hytam';

$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses form jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = $_POST['tanggal'];
    $nama = $_POST['nama'];
    $divisi = $_POST['divisi'];
    $deskripsi = $_POST['deskripsi'];

    $stmt = $conn->prepare("INSERT INTO laporan_kerja (tanggal, nama, divisi, deskripsi) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $tanggal, $nama, $divisi, $deskripsi);

    if ($stmt->execute()) {
        echo "<script>alert('Laporan berhasil ditambahkan!'); window.location.href='laporan_kerja.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Laporan Kerja</title>
    <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h3 class="mb-4">Tambah Laporan Kerja</h3>
    <form method="post" action="">
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="divisi" class="form-label">Divisi</label>
            <input type="text" name="divisi" id="divisi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="laporan_kerja.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>
