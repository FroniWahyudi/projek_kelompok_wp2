<?php
// ====== 1. KONEKSI DATABASE ======
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '';
$dbName = 'naga_hytam';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
    die("Gagal koneksi MySQL: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");

// ====== 2. AMBIL DATA MANAGER ======
$sql = "
  SELECT 
    id, name, role, email, phone, photo_url, bio, alamat,
    DATE_FORMAT(joined_at,'%d %M %Y') AS joined_at,
    job_descriptions, skills, achievements
  FROM users
  WHERE role = 'Manajer'
  LIMIT 1
";
$result = $mysqli->query($sql);
if (!$result || $result->num_rows === 0) {
    die("Data Manajer tidak ditemukan.");
}
$mgr = $result->fetch_assoc();

$jobs   = explode(', ', $mgr['job_descriptions'] ?: '');
$skills = explode(', ', $mgr['skills'] ?: '');
$achs   = explode(', ', $mgr['achievements'] ?: '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profil <?= htmlspecialchars($mgr['name']) ?></title>
  <!-- Bootstrap & Poppins -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="bootstrap-5.3.5-dist\css\bootstrap.min.css">
  <style>
    body {
      font-size: .85rem;
      font-family: 'Poppins', sans-serif;
      color: #6c757d;
      background-color: #f8f9fa;
    }
   .profile-img {
    width: 322px;
    height: 322px;
    object-fit: cover;
}
    .dot {
      width: 10px;
      height: 10px;
      background-color: #00c8c8;
      border-radius: 50%;
      display: inline-block;
    }

    /* Navbar Custom */
    .navbar-custom {
      background-color: #fff;
      border-bottom: 1px solid #dee2e6;
      padding: .5rem 1rem;
    }
    .navbar-brand {
      display: flex;
      align-items: center;
      gap: .5rem;
      font-weight: 600;
      color: #495057;
    }
    .navbar-brand .dot {
      width: 10px;
      height: 10px;
      background-color: #00c8c8;
      border-radius: 50%;
    }
    .nav-link {
      color: #6c757d;
      font-weight: 500;
      margin-left: 1.5rem;
      font-size: .9rem;
    }
    .nav-link:hover,
    .nav-link.active {
       color: #0d6efd !important;
    }

    .footer .info-list {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 6.7rem;
      font-size: .8rem;
      color: #495057;
    }
    #my-footer {
      border-top: 2px solid #dee2e6;
      padding-top: 1rem;
    }
    .nama h1 {
      font-size: 2.5rem;
      font-weight: 600;
      color: #495057;
      margin-bottom: .5rem;
    }
    .nama h5 {
      font-size: .95rem;
      font-weight: bold;
      color: #495057 !important;
      margin-bottom: 1rem;
    }
    .nama p {
      font-size: .85rem;
      line-height: 1.6;
      color: #6c757d;
    }
    .custom-padding-bottom {
      padding-bottom: 60px;
      margin-bottom: 40px;
    }
  </style>
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid px-lg-5">
      <a class="navbar-brand" href="#">
        <span class="dot"></span>
        <span>Manajer</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#mainNav" aria-controls="mainNav"
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="mainNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="#"><?= htmlspecialchars($mgr['role']) ?></a></li>
          <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin</a></li>
          <li class="nav-item"><a class="nav-link" href="leader_dashboard.php">Leader</a></li>
          <li class="nav-item"><a class="nav-link" href="operator_dashboard.php">Operator</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Profile Section -->
  <div class="container mt-5 px-lg-5 pb-5 custom-padding-bottom">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-4 col-md-6 text-center mb-4 mb-md-0">
        <img src="<?= htmlspecialchars($mgr['photo_url']) ?>"
             class="rounded-circle profile-img"
             alt="<?= htmlspecialchars($mgr['name']) ?>">
      </div>
      <div class="col-lg-4 col-md-6 nama">
        <h1 class="fw-bold"><?= htmlspecialchars($mgr['name']) ?></h1>
        <h5 class="text-muted">Tentang Saya</h5>
        <p class="text-start"><?= nl2br(htmlspecialchars($mgr['bio'])) ?></p>
        <?php if ($jobs[0] !== ''): ?>
          <h6>Deskripsi Pekerjaan:</h6>
          <ul class="text-start">
            <?php foreach ($jobs as $j): ?>
              <li><?= htmlspecialchars($j) ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer mt-5 pt-4" id="my-footer">
    <div class="container">
      <div class="info-list mb-2">
        <div><strong>Nama<br></strong><?= htmlspecialchars($mgr['name']) ?></div>
        <div><strong>Jabatan<br></strong><?= htmlspecialchars($mgr['role']) ?></div>
        <div><strong>Email<br></strong><?= htmlspecialchars($mgr['email']) ?></div>
        <div><strong>Telepon<br></strong><?= htmlspecialchars($mgr['phone']) ?></div>
        <div><strong>Alamat<br></strong><?= htmlspecialchars($mgr['alamat']) ?></div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
