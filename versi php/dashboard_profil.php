<?php
session_start();
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
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body { opacity: 0; transition: opacity 0.5s ease; background-color: #f1f3f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body.fade-in { opacity: 1; }
    :root { --sidebar-width: 260px; --primary-color: #0d6efd; }
    .wrapper { display: flex; min-height: 100vh; }
    .sidebar { width: var(--sidebar-width); background: #fff; box-shadow: 2px 0 10px rgba(0,0,0,0.05); padding: 2rem 1rem; }
    .sidebar h2 { color: var(--primary-color); font-size: 1.5rem; margin-bottom: 1.5rem; }
    .sidebar .nav-link { display: flex; align-items: center; gap: .75rem; padding: .75rem 1rem; border-radius: .375rem; color: #495057; }
    .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #f8f9fa; color: var(--primary-color); }
    .content { flex: 1; padding: 2rem; }
    /* Profile card full width */
    .profile-card { width: 100%; background: #fff; border-radius: .5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 2rem; }
    .profile-card img { width: 120px; height: 120px; object-fit: cover; border-radius: 50%; margin-bottom: 1rem; }
    .profile-info { margin-top: 1.5rem; }
    .profile-info .info-block { display: flex; align-items: center; margin-bottom: 1rem; }
    .profile-info .info-block i { font-size: 1.2rem; width: 30px; text-align: center; color: var(--primary-color); }
    .profile-info .info-block span { margin-left: .75rem; }
  </style>
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2>Profil</h2>
      <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> Home</a>
        <a class="nav-link active" href="dashboard_profil.php"><i class="fas fa-user"></i> Profil Saya</a>
        <a class="nav-link" href="ganti_password.php"><i class="fas fa-key"></i> Ganti Password</a>
      </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="content">
      <div class="text-center mb-4">
        <h1>Profil Saya</h1>
      </div>
      
      <!-- Profile Card -->
      <div class="profile-card text-center">
        <img src="<?= htmlspecialchars($user['photo_url']) ?>" alt="Foto Profil">
        <h3><?= htmlspecialchars($user['name']) ?></h3>
        <hr>
        <div class="profile-info text-start">
          <div class="info-block">
            <i class="fas fa-envelope"></i>
            <span><?= htmlspecialchars($user['email']) ?></span>
          </div>
          <div class="info-block">
            <i class="fas fa-phone"></i>
            <span><?= htmlspecialchars($user['phone']) ?></span>
          </div>

          <div class="info-block">
            <i class="fas fa-map-marker-alt"></i>
            <span><?= htmlspecialchars($user['alamat']) ?></span>
          </div>

          <div class="info-block">
            <i class="fas fa-briefcase"></i>
            <span><?= htmlspecialchars($user['role']) ?></span>
          </div>
          <div class="info-block">
            <i class="fas fa-info-circle"></i>
            <span><?= htmlspecialchars($user['bio']) ?></span>
          </div>
        </div>
        <div class="mt-3 text-end">
          <a href="edit_profil.php?id=<?= $user_id ?>" class="btn btn-primary">
            <i class="fas fa-pen"></i> Edit Profil
          </a>
        </div>
      </div>
      
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
