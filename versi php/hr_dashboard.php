<?php
// Koneksi ke database
$mysqli = new mysqli("localhost", "root", "", "naga_hytam");
if ($mysqli->connect_errno) {
    die("Gagal koneksi ke database: " . $mysqli->connect_error);
}

// Ambil data semua user dengan role HR
$result = $mysqli->query("SELECT name, role, email, phone, photo_url, bio FROM users WHERE role LIKE 'HR%'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Dashboard - Naga Hytam Sejahtera Abadi</title>
  <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .hr-card {
      border: 1px solid #dee2e6;
      border-radius: 0.5rem;
      background-color: #ffffff;
      padding: 1rem;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      transition: transform 0.2s;
      height: 100%;
    }
    .hr-card:hover {
      transform: translateY(-5px);
    }
    .profile-photo {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
    }
    @media (max-width: 765px) {
      .hr-card .d-flex {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }
      .profile-photo {
        margin-bottom: 1rem;
        margin-right: 0 !important;
      }
    }
  </style>
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
  <div class="container-fluid">
    <a href="dashboard.php" class="btn btn-primary me-3">
      <i class="bi bi-house-door-fill me-1"></i> Home
    </a>
    <a class="navbar-brand" href="#">HR Dashboard</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#">HR</a></li>
        <li class="nav-item"><a class="nav-link" href="manajemen_dashboard.html">Manajemen</a></li>
        <li class="nav-item"><a class="nav-link" href="karyawan_dashboard.html">Karyawan</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container py-4">
  <h3 class="mb-4">Divisi HR</h3>
  <div class="row g-3">

    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="hr-card d-flex flex-column h-100">
          <div class="d-flex mb-3">
            <img src="<?= htmlspecialchars($row['photo_url']) ?>" alt="Foto <?= htmlspecialchars($row['name']) ?>" class="profile-photo me-3">
            <div>
              <h5 class="mb-1"><?= htmlspecialchars($row['name']) ?></h5>
              <p class="mb-1"><strong>Jabatan:</strong> <?= htmlspecialchars($row['role']) ?></p>
              <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
              <p class="mb-1"><strong>Telepon:</strong> <?= htmlspecialchars($row['phone']) ?></p>
            </div>
          </div>
          <p class="mb-0"><?= htmlspecialchars($row['bio']) ?></p>
        </div>
      </div>
    <?php endwhile; ?>

  </div>
</div>

<script src="bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
