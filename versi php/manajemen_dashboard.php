<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "naga_hytam");
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data manajemen
$sql = "SELECT * FROM users WHERE role = 'Manajer Umum' OR role = 'Manajer HR'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Dashboard - Naga Hytam Sejahtera Abadi</title>
  <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .manager-card {
      border: 1px solid #dee2e6;
      border-radius: 0.5rem;
      background-color: #ffffff;
      padding: 1rem;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      transition: transform 0.2s;
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .manager-card:hover {
      transform: translateY(-5px);
    }
    .profile-photo {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
    }
    @media (max-width: 765px) {
      .manager-card .d-flex {
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

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
  <div class="container-fluid">
    <a href="dashboard.php" class="btn btn-primary me-3">
      <i class="bi bi-house-door-fill me-1"></i> Home
    </a>
    <a class="navbar-brand" href="#">Manajemen Dashboard</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="karyawan_dashboard.php">Karyawan</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Manajemen</a></li>
        <li class="nav-item"><a class="nav-link" href="hr_dashboard.php">HR</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-4">
  <h3 class="mb-4">Divisi Manajemen</h3>
  <div class="row row-cols-1 row-cols-md-2 g-4">
    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="col">
          <div class="manager-card d-flex flex-column h-100">
            <div class="d-flex mb-3">
              <img src="<?= htmlspecialchars($row['photo_url']) ?>" alt="Foto <?= htmlspecialchars($row['name']) ?>" class="profile-photo me-3">
              <div>
                <h5 class="mb-1"><?= htmlspecialchars($row['name']) ?></h5>
                <p class="mb-1"><strong>Jabatan:</strong> <?= htmlspecialchars($row['role']) ?></p>
                <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                <p class="mb-1"><strong>Telepon:</strong> <?= htmlspecialchars($row['phone']) ?></p>
              </div>
            </div>
            <p class="mt-auto mb-0"><?= htmlspecialchars($row['bio']) ?></p>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col">
        <p class="text-muted">Tidak ada data manajemen tersedia.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<script src="bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
