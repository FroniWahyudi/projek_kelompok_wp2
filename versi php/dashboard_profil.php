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

// Ambil data user
$query = "SELECT * FROM users WHERE id = ?";
$stmt  = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="package/font/bootstrap-icons.css">
  <style>
    body { opacity: 0; transition: opacity 0.5s ease; }
    body.fade-in { opacity: 1; }
    :root { --sidebar-width: 260px; --primary-color: #0d6efd; --hover-bg: #f8f9fa; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f3f5; margin: 0; padding: 0; }
    .wrapper { display: flex; min-height: 100vh; }
    .sidebar { width: var(--sidebar-width); background-color: #fff; box-shadow: 2px 0 10px rgba(0,0,0,0.05); padding: 2rem 1rem; }
    .sidebar h2 { font-size: 1.5rem; color: var(--primary-color); margin-bottom: 1.5rem; }
    .sidebar .nav-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.375rem; color: #495057; text-decoration: none; }
    .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: var(--hover-bg); color: var(--primary-color); }
    .content { flex: 1; padding: 2rem; }
    .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .content-header h1 { font-size: 1.75rem; margin: 0; }
  </style>
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2>Profil</h2>
      <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"> <i class="fas fa-home"></i> Home</a>
        <a class="nav-link active" href="dashboard_profil.php"><i class="fas fa-user"></i>Profil Saya</a>
        <a class="nav-link" href="ganti_password.php"><i class="fas fa-key"></i>Ganti Password</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="content">
      <div class="content-header">
        <h1>Profil Saya</h1>
      </div>
      <section>
  <div class="bg-white p-4 rounded shadow-sm text-center">
    <img src="<?= htmlspecialchars($user['photo_url']) ?>" alt="Foto Profil" style="width:120px; height:120px; object-fit:cover; border-radius:50%; margin-bottom:1rem;">
    <h3><?= htmlspecialchars($user['name']) ?></h3>
    <hr>
    <div class="text-start">
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
      <p><strong>Telepon:</strong> <?= htmlspecialchars($user['phone']) ?></p>
      <p><strong>Jabatan:</strong> <?= htmlspecialchars($user['role']) ?></p>
      <p><strong>Bio:</strong> <?= htmlspecialchars($user['bio']) ?></p>
    </div>
    <div class="text-end mt-3">
      <a href="edit_profil.php?id=<?= $user_id ?>" class="btn btn-primary">
        <i class="fas fa-pen"></i> Edit Profil
      </a>
    </div>
  </div>
</section>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => document.body.classList.add('fade-in'), 50);
    });
  </script>
</body>
</html>
