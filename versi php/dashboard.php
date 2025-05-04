<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'naga_hytam');
if ($mysqli->connect_error) {
    die('Database connection error: ' . $mysqli->connect_error);
}

if (!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Ambil data user
$user_id = $_SESSION['user_id'];
$stmt = $mysqli->prepare('SELECT name, role, photo_url FROM users WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo 'User tidak ditemukan.';
    exit;
}

// Ambil berita terbaru
$newsItems = [];
$result = $mysqli->query('SELECT * FROM news ORDER BY date DESC LIMIT 6');
while ($row = $result->fetch_assoc()) {
    $newsItems[] = $row;
}
$result->free();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Naga Hytam Sejahtera Abadi</title>
  <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
  /* === GAYA NAVBAR UTAMA === */
  .navbar-custom {
    background-color: #ffffff;
    height: 80px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1030;
    display: flex;
    align-items: center;
    padding: 0 1rem;
  }

  .navbar-custom .nav-item {
    margin-right: 1rem;
  }

  .navbar-custom .logo-brand {
    flex: 1;
    text-align: center;
  }

  .navbar-custom .logo-brand img {
    height: 86px;
    object-fit: contain;
  }

  /* === GAYA SIDEBAR === */
  .sidebar {
    position: fixed;
    top: 80px;
    bottom: 0;
    left: 0;
    width: 250px;
    background-color: #fff;
    border-right: 1px solid #ddd;
    padding: 1rem;
    overflow-y: auto;
    z-index: 1020;
  }

  /* === GAYA UTAMA HALAMAN === */
  main {
    margin-top: 100px;
    margin-left: 270px;
    padding: 1rem;
  }

  /* === GAYA KARTU BERITA === */
  .card-news img {
    height: 160px;
    object-fit: cover;
  }

  .card-news {
    display: flex;
    flex-direction: column;
  }

  .card-news .card-body {
    flex-grow: 1;
  }

  /* === RESPONSIVE: LAYAR ≤ 900px === */
  @media (max-width: 900px) {
    /* Posisi ulang tombol profil */
    #profileDropdownToggle {
      position: absolute;
      top: 20px;
      right: 1rem;
    }
  }

  /* === RESPONSIVE: LAYAR ≤ 700px === */
  @media (max-width: 700px) {
    .sidebar {
      display: none;
    }

    main {
      margin-left: 0;
    }

    /* Logo di tengah */
    .logo-brand {
      position: absolute;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
    }

    .navbar-custom .logo-brand img {
      height: 70px;
      object-fit: contain;
    }

    /* Tombol profil di kanan atas */
    #profileDropdownToggle {
      position: absolute;
      top: 20px;
      right: 1rem;
    }
  }

  /* === RESPONSIVE: LAYAR ≤ 500px === */
  @media (max-width: 500px) {
    .sidebar {
      display: none;
    }

    main {
      margin-left: 0;
    }

    /* Logo lebih kecil dan sedikit bergeser */
    .logo-brand {
      position: absolute;
      top: 6px;
      left: 50%;
      transform: translateX(-47%);
    }

    .navbar-custom .logo-brand img {
      height: 70px;
      object-fit: contain;
    }

    /* Tombol profil disesuaikan */
    #profileDropdownToggle {
      position: absolute;
      top: 20px;
      right: 0.1rem;
    }

    /* Ukuran dan padding menu mobile */
    #mobileMenu {
      font-size: 12px;
      padding: 8px 8px;
      width: 100%;
    }
  }

  /* === RESPONSIVE: LAYAR 785-790px === */
  @media (min-width: 785px) and (max-width: 790px) {
    .sidebar {
      display: none;
    }

    main {
      margin-left: 0;
    }

    /* Logo dan profil disesuaikan */
    .logo-brand {
      position: absolute;
      top: 6px;
      left: 50%;
      transform: translateX(-47%);
    }

    .navbar-custom .logo-brand img {
      height: 70px;
      object-fit: contain;
    }

    #profileDropdownToggle {
      position: absolute;
      top: 20px;
      left: 2rem;
    }

    #mobileMenu {
      font-size: 12px;
      padding: 8px 8px;
      width: 100%;
    }
  }

  /* === RESPONSIVE: LAYAR 340-390px === */
  @media (min-width: 340px) and (max-width: 390px) {
    .sidebar {
      display: none;
    }

    main {
      margin-left: 0;
    }

    /* Penyesuaian posisi dan ukuran logo */
    .logo-brand {
      position: absolute;
      top: 6px;
      left: 50%;
      transform: translateX(-47%);
    }

    .navbar-custom .logo-brand img {
      height: 55px;
      object-fit: contain;
    }

    /* Penyesuaian tombol profil */
    #profileDropdownToggle {
      position: absolute;
      top: 17px;
      right: -0.5rem;
    }

    #mobileMenu {
      font-size: 12px;
      padding: 8px 8px;
      width: 100%;
    }
  }
</style>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <!-- Navbar -->
<nav class="navbar-custom">
  <!-- Mobile Menu -->
  <div class="dropdown d-md-none nav-item">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="mobileMenu" data-bs-toggle="dropdown">
      <i class="bi bi-list"></i> Menu
    </button>
    <ul class="dropdown-menu" aria-labelledby="mobileMenu">
      <li><h6 class="dropdown-header">Divisi Karyawan</h6></li>
      <li>
        <a class="dropdown-item" href="hr_dashboard.php">
          <i class="bi bi-person-circle me-1"></i>
          HR
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="manajemen_dashboard.php">
          <i class="bi bi-people-fill me-1"></i>
          Manajemen
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="karyawan_dashboard.php">
          <i class="bi bi-people-fill me-1"></i>
          Karyawan
        </a>
      </li>
      <li><hr class="dropdown-divider"></li>
      <li><h6 class="dropdown-header">Menu Lainnya</h6></li>
      <?php if($user['role']==='Manajer Umum' || $user['role']==='Manajer HR'): ?>
      <li>
        <a class="dropdown-item" href="laporan_kerja.php">
          <i class="bi bi-journal-text me-1"></i>
          Laporan Kerja
        </a>
      </li>
      <?php elseif($user['role']==='HR'): ?>
      <li>
        <a class="dropdown-item" href="laporan_kerja.php">
          <i class="bi bi-journal-text me-1"></i>
          Kirim Laporan Kerja
        </a>
      </li>
      <?php endif; ?>
      <li>
        <a class="dropdown-item" href="feedback_pegawai.php">
          <i class="bi bi-chat-dots me-1"></i>
          Feedback Pegawai
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="shift_karyawan.php">
          <i class="bi bi-clock-history me-1"></i>
          Shift & Jadwal Karyawan
        </a>
      </li>
    </ul>
  </div>


<!-- Profile -->
<div id="profileDropdownToggle" class="d-flex align-items-center nav-item" style="cursor:pointer;">
  <img src="<?= htmlspecialchars($user['photo_url'] ?: 'img/default_profile.png') ?>"
       class="rounded-circle me-2" width="50" height="50" alt="Foto Profil">
  <div class="d-none d-md-block">
    <strong><?= htmlspecialchars($user['name']) ?></strong><br>
    <small class="text-muted"><?= htmlspecialchars($user['role']) ?></small>
  </div>
</div>

<!-- Dropdown Menu -->
<div id="profileDropdown" class="position-absolute bg-white border shadow-sm rounded p-2" style="top: 80px; right: 1rem; width: 220px; display: none; z-index: 999;">
  <strong class="d-block mb-2">Profil</strong>
  <a href="ubah_data.php" class="d-block mb-1 text-decoration-none text-dark">
    <i class="bi bi-pencil-square me-2"></i>Ubah Data Diri
  </a>
  <a href="ganti_password.php" class="d-block mb-1 text-decoration-none text-dark">
    <i class="bi bi-key me-2"></i>Ganti Password
  </a>
  <a href="jabatan_divisi.php" class="d-block mb-1 text-decoration-none text-dark">
    <i class="bi bi-diagram-3 me-2"></i>Jabatan & Divisi
  </a>
  <a href="sisa_cuti.php" class="d-block mb-1 text-decoration-none text-dark">
    <i class="bi bi-calendar-check me-2"></i>Sisa Cuti
  </a>
  <a href="tanggal_bergabung.php" class="d-block mb-1 text-decoration-none text-dark">
    <i class="bi bi-calendar-event me-2"></i>Tanggal Bergabung
  </a>
  <a href="riwayat_cuti.php" class="d-block mb-1 text-decoration-none text-dark">
    <i class="bi bi-clock-history me-2"></i>Riwayat Cuti
  </a>
  <hr>
  <a href="logout.php" class="d-block text-decoration-none text-danger">
    <i class="bi bi-box-arrow-right me-2"></i>Logout
  </a>
</div>








  <!-- Logo Center -->
  <div class="logo-brand">
    <img src="img/logo_brand.png" alt="Logo Brand">
  </div>

  <!-- Logout -->
  <div class="ms-auto nav-item d-none d-md-block">
    <a href="login.php" class="btn btn-outline-dark">
      <i class="bi bi-box-arrow-right me-1"></i>
      Logout
    </a>
  </div>
</nav>


  <!-- Sidebar -->
  <nav class="sidebar">
  <h6 class="fw-bold text-uppercase">Divisi Karyawan</h6>

  <a href="hr_dashboard.php" class="btn btn-outline-primary w-100 mb-2">
    <i class="bi bi-person-circle me-1"></i>
    HR
  </a>
  <a href="manajemen_dashboard.php" class="btn btn-outline-primary w-100 mb-2">
    <i class="bi bi-people-fill me-1"></i>
    Manajemen
  </a>
  <a href="karyawan_dashboard.php" class="btn btn-outline-primary w-100 mb-2">
    <i class="bi bi-people-fill me-1"></i>
    Karyawan
  </a>

  <hr>

  <h6 class="fw-bold">Menu Lainnya</h6>
  <?php if ($user['role'] === 'Manajer Umum' || $user['role'] === 'Manajer HR'): ?>
    <a href="laporan_kerja.php" class="btn btn-outline-dark w-100 mb-2">
      <i class="bi bi-journal-text me-1"></i>
      Laporan Kerja
    </a>
  <?php elseif ($user['role'] === 'HR'): ?>
    <a href="laporan_kerja.php" class="btn btn-outline-dark w-100 mb-2">
      <i class="bi bi-journal-text me-1"></i>
      Kirim Laporan Kerja
    </a>
  <?php elseif ($user['role'] === 'Karyawan'): ?>
    <a href="pengajuan_cuti.php" class="btn btn-outline-dark w-100 mb-2">
      <i class="bi bi-file-earmark-text me-1"></i>
      Pengajuan Cuti
    </a>
    <a href="slip_gaji.php" class="btn btn-outline-dark w-100 mb-2">
      <i class="bi bi-receipt me-1"></i>
      Slip Gaji
    </a>
  <?php endif; ?>

  <a href="feedback_pegawai.php" class="btn btn-outline-dark w-100 mb-2">
    <i class="bi bi-chat-dots me-1"></i>
    Feedback Pegawai
  </a>
  <a href="shift_karyawan.php" class="btn btn-outline-dark w-100">
    <i class="bi bi-clock-history me-1"></i>
    Shift & Jadwal
  </a>
</nav>


  <!-- Main Content -->
  <main>
    <h3 class="mb-4">What's New</h3>
    <div class="row g-3">
      <?php foreach($newsItems as $idx => $item):
        $total = count($newsItems);
        $col = ($idx >= $total-2)? 'col-md-6':'col-md-3';
      ?>
      <div class="col-12 col-sm-6 <?= $col ?>">
        <div class="card card-news shadow-sm h-100">
          <img src="<?= htmlspecialchars($item['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>">
          <div class="card-body">
            <h6 class="fw-bold"><?= htmlspecialchars($item['title']) ?></h6>
            <small class="text-muted"><?= htmlspecialchars($item['date']) ?></small>
            <p class="small"><?= htmlspecialchars($item['description']) ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </main>

<!-- jQuery Script -->
<script>
  $(document).ready(function() {
    // Saat tombol profil diklik
    $('#profileDropdownToggle').click(function(e) {
      e.stopPropagation(); // Hindari event bubble

      var w = $(window).width();

      // Jika ukuran mobile (300 - 765 px), tampilkan dropdown
      if (w >= 300 && w <= 765) {
        $('#profileDropdown').slideToggle(150);
      } 
      // Jika desktop, redirect ke halaman profil
      else if (w > 765) {
        window.location.href = 'dashboard_profil.php';
      }
    });

    // Jika klik di luar dropdown, sembunyikan dropdown
    $(document).click(function(e) {
      if (!$(e.target).closest('#profileDropdown, #profileDropdownToggle').length) {
        $('#profileDropdown').slideUp(150);
      }
    });

    // Saat resize ke desktop atau mobile extreme, sembunyikan dropdown
    $(window).resize(function() {
      var w = $(window).width();
      if (w < 400 || w > 765) {
        $('#profileDropdown').hide();
      }
    });
  });
</script>

  <script src="bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
