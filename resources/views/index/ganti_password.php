<?php
session_start();

// Redirect jika belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'naga_hytam';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$pesan = "";

// Ganti password jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Ambil password lama
    $query = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

 
  // Cek kecocokan password lama (tanpa hash)
$db_password = $user['password'];

if ($old_password !== $db_password) {
    $pesan = "Password lama tidak cocok!";
} elseif ($new_password !== $confirm_password) {
    $pesan = "Konfirmasi password tidak cocok!";
} else {
    // Simpan password baru (tanpa hash)
    $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update->bind_param("si", $new_password, $user_id);

    if ($update->execute()) {
        $pesan = "Password berhasil diperbarui!";
    } else {
        $pesan = "Gagal memperbarui password.";
    }
}


}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ganti Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    :root { --sidebar-width: 260px; --primary-color: #0d6efd; --hover-bg: #f8f9fa; }
    body { font-family: 'Segoe UI', sans-serif; background-color: #f1f3f5; }
    .wrapper { display: flex; min-height: 100vh; }
    .sidebar { width: var(--sidebar-width); background: #fff; box-shadow: 2px 0 10px rgba(0,0,0,0.05); padding: 2rem 1rem; }
    .sidebar h2 { color: var(--primary-color); font-size: 1.5rem; margin-bottom: 1.5rem; }
    .nav-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.375rem; color: #495057; text-decoration: none; }
    .nav-link:hover, .nav-link.active { background-color: var(--hover-bg); color: var(--primary-color); }
    .content { flex: 1; padding: 2rem; }
    .content-header { margin-bottom: 2rem; }
  </style>
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2>Profil</h2>
      <nav class="nav flex-column">
        <a class="nav-link" href="dashboard_profil.php"><i class="fas fa-user"></i>Profil Saya</a>
        <a class="nav-link active" href="ganti_password.php"><i class="fas fa-key"></i>Ganti Password</a>
        <a class="nav-link" href="dashboard.php"><i class="fas fa-right-from-bracket"></i>Keluar</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="content">
      <div class="content-header">
        <h1>Ganti Password</h1>
      </div>
      <section>
        <div class="bg-white p-4 rounded shadow-sm">
          <?php if (!empty($pesan)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($pesan) ?></div>
          <?php endif; ?>
          <form method="post">
            <div class="mb-3">
              <label class="form-label">Password Lama</label>
              <input type="password" name="old_password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password Baru</label>
              <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Konfirmasi Password Baru</label>
              <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <div class="text-end">
              <button type="submit" class="btn btn-primary"><i class="fas fa-key"></i> Simpan</button>
              <a href="dashboard_profil.php" class="btn btn-secondary ms-2"><i class="fas fa-arrow-left"></i> Batal</a>
            </div>
          </form>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
