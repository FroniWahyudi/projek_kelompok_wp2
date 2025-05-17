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

// ====== 2. AMBIL PARAMETER SEARCH ======
$search = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : '';

// ====== 3. AMBIL DATA ROLE KARYAWAN DENGAN FILTER ======
$sql = "
  SELECT 
    id, name, role, level, email, phone, photo_url, bio, alamat,
    DATE_FORMAT(joined_at,'%d %M %Y') AS joined_at,
    education, department,
    job_descriptions, skills, achievements
  FROM users
  WHERE role = 'Karyawan'
";
if ($search !== '') {
    $sql .= " AND name LIKE '%{$search}%'";
}
$sql .= " ORDER BY id";

$result = $mysqli->query($sql);
if (!$result) {
    die("Query error: " . $mysqli->error);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profil Karyawan</title>
  <!-- Bootstrap & Poppins & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    body {
      padding-top: 70px;
      font-family: 'Poppins', sans-serif;
      font-size: .9rem;
      color: #6c757d;
      background: #f8f9fa;
    }
    .navbar-custom {
      background-color: #fff;
      border-bottom: 1px solid #dee2e6;
      padding: .5rem 1rem;
    }
    .navbar-custom.fixed-top { top:0; left:0; right:0; }
    .navbar-brand {
      display:flex; align-items:center; gap:.5rem;
      font-weight:600; color:#495057; text-decoration:none;
    }
    .navbar-brand .dot {
      width:10px; height:10px; background:#00c8c8;
      border-radius:50%; display:inline-block;
    }
    .navbar-nav .nav-link {
      color:#6c757d; font-weight:500;
      margin-left:1.5rem; font-size:.9rem;
    }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active { color:#000; }
    .modal { padding-top:75px; }
    .profile-card {
      background:#fff; border-radius:.5rem;
      box-shadow:0 .25rem .5rem rgba(0,0,0,.1);
      padding:1.5rem; display:flex;
      flex-direction:column; justify-content:space-between;
    }
    .avatar {
      width:80px; height:80px; border-radius:50%;
      object-fit:cover; border:2px solid #dee2e6;
    }
    .profile-header {
      display:flex; align-items:center; margin-bottom:1rem;
    }
    .profile-header h5 {
      margin:0; font-weight:600; color:#495057;
    }
    .profile-header .role {
      font-size:.85rem; color:#00c8c8; font-weight:500;
    }
    .badge-role {
      background:#e0f7f7; color:#0d6efd;
      font-size:.65rem; padding:.25em .5em; margin-left:.5em;
    }
    .btn-detail {
      font-size:.85rem; padding:.25rem .5rem;
      width:100px;
    }
    footer#my-footer {
      border-top:1px solid #dee2e6;
      padding:1rem 2rem; font-size:.8rem;
      color:#868e96; text-align:center;
    }
    /* Persempit search bar */
    .search-container {
      max-width: 300px;
      /* margin: 1rem auto 0; */
      margin-left: 10%;
      height: 5%;
    }

      .navbar-expand-lg .navbar-nav {
        flex-direction: row;
        margin-right: -15px;
    }

    /* Atur tinggi input */
.custom-search-input {
  height: 30px;      
  width: 500px;      /* misal 40px */
  padding-top: 0.375rem;   /* agar teks vertikal center */
  padding-bottom: 0.375rem;
}

/* Atur tinggi tombol & posisi icon */
.custom-search-btn {
  height: 30px;            /* harus sama dengan input */
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Perbesar sedikit icon agar proporsional */
.custom-search-btn .bi-search {
  font-size: 1rem;
}


  </style>
</head>
<body>

  <!-- Navbar (TIDAK DIUBAH) -->
  <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid px-lg-5">
      <a class="navbar-brand" href="#">
        <span class="dot"></span>
        <span>Divisi Karyawan</span>
      </a>
<div class="search-container">
  <form method="get" class="d-flex">
    <input
      class="form-control me-2 custom-search-input"
      type="search"
      name="search"
      placeholder="Cari nama karyawan..."
      aria-label="Cari"
      value="<?= htmlspecialchars($search) ?>"
    >
    <button class="btn btn-outline-secondary custom-search-btn" type="submit">
      <i class="bi bi-search"></i>
    </button>
  </form>
</div>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#mainNav" aria-controls="mainNav"
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="mainNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="manajemen_dashboard.php">Manajer</a></li>
          <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin</a></li>
          <li class="nav-item"><a class="nav-link" href="leader_dashboard.php">Leader</a></li>
     
          <li class="nav-item"><a class="nav-link" href="operator_dashboard.php">Operator</a></li>
        </ul>
      </div>
    </div>
  </nav>

  

  <!-- Konten Karyawan -->
  <div class="container py-5">
    <div class="row gx-4">
      <?php while($karyawan = $result->fetch_assoc()): ?>
        <div class="col-md-6 d-flex mb-4">
          <div class="profile-card w-100">
            <div class="profile-header">
              <img src="<?= htmlspecialchars($karyawan['photo_url']) ?>"
                   class="avatar me-3"
                   alt="<?= htmlspecialchars($karyawan['name']) ?>">
              <div>
                <h5><?= htmlspecialchars($karyawan['name']) ?></h5>
                <div class="role">
                  <?= htmlspecialchars($karyawan['role']) ?>
                  <span class="badge-role"><?= htmlspecialchars($karyawan['level']) ?></span>
                </div>
              </div>
            </div>
            <p><?= nl2br(htmlspecialchars($karyawan['bio'])) ?></p>
            <p class="mb-3"><i class="bi bi-envelope me-1"></i> <?= htmlspecialchars($karyawan['email']) ?></p>
            <button class="btn btn-primary btn-sm btn-detail"
                    data-bs-toggle="modal"
                    data-bs-target="#detailModal<?= $karyawan['id'] ?>">
              Lihat Detail
            </button>
          </div>
        </div>

        <!-- Modal untuk setiap Karyawan -->
        <div class="modal fade" id="detailModal<?= $karyawan['id'] ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><?= htmlspecialchars($karyawan['name']) ?> — Detail Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="d-flex align-items-center mb-4">
                  <img src="<?= htmlspecialchars($karyawan['photo_url']) ?>" class="avatar me-3" alt="">
                  <div>
                    <h6 class="mb-0"><?= htmlspecialchars($karyawan['name']) ?></h6>
                    <small class="text-primary"><?= htmlspecialchars($karyawan['role']) ?></small>
                    <span class="badge bg-info text-dark ms-2"><?= htmlspecialchars($karyawan['level']) ?></span><br>
                    <small class="text-muted"><i class="bi bi-envelope me-1"></i> <?= htmlspecialchars($karyawan['email']) ?></small>
                    <small class="text-muted ms-3"><i class="bi bi-telephone me-1"></i> <?= htmlspecialchars($karyawan['phone']) ?></small>
                  </div>
                </div>

                <h6>Informasi Pribadi</h6>
                <div class="row mb-3">
                  <div class="col-sm-6"><strong>Joined:</strong><br><?= htmlspecialchars($karyawan['joined_at']) ?></div>
                  <div class="col-sm-6"><strong>Pendidikan:</strong><br><?= htmlspecialchars($karyawan['education']) ?></div>
                </div>
                <div class="row mb-4">
                  <div class="col-sm-6"><strong>Alamat:</strong><br><?= htmlspecialchars($karyawan['alamat']) ?></div>
                  <div class="col-sm-6"><strong>Departemen:</strong><br><?= htmlspecialchars($karyawan['department']) ?></div>
                </div>

                <h6>Deskripsi Pekerjaan</h6>
                <ul>
                  <?php
                    if (!empty($karyawan['job_descriptions'])) {
                      foreach (explode(', ', $karyawan['job_descriptions']) as $jd) {
                        echo '<li>' . htmlspecialchars($jd) . '</li>';
                      }
                    }
                  ?>
                </ul>

                <h6>Keahlian</h6>
                <div class="mb-3">
                  <?php
                    if (!empty($karyawan['skills'])) {
                      foreach (explode(', ', $karyawan['skills']) as $s) {
                        echo '<span class="badge bg-secondary me-1">' . htmlspecialchars($s) . '</span>';
                      }
                    }
                  ?>
                </div>

                <h6>Pencapaian</h6>
                <ul>
                  <?php
                    if (!empty($karyawan['achievements'])) {
                      foreach (explode(', ', $karyawan['achievements']) as $a) {
                        echo '<li>' . htmlspecialchars($a) . '</li>';
                      }
                    }
                  ?>
                </ul>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-sm">Cetak Profil</button>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- Footer -->
  <footer id="my-footer">
    © <?= date('Y') ?> Divisi Karyawan. Hak Cipta Dilindungi.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
