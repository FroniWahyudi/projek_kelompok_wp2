<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'naga_hytam');
if ($mysqli->connect_error) {
    die('Database connection error: ' . $mysqli->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user = null;
$user_id = $_SESSION['user_id'];
$stmt = $mysqli->prepare('SELECT name, role, photo_url FROM users WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Naga Hytam Sejahtera Abadi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="versi php\bootstrap-5.3.5-dist">
  <style>
  header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 70px;
    background-color: white;
    z-index: 1030;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }

  .sidebar {
    position: fixed;
    top: 70px;
    bottom: 0;
    left: 0;
    width: 250px;
    background-color: white;
    overflow-y: auto;
    border-right: 1px solid #ddd;
    padding: 20px;
    z-index: 1020;
  }

  main {
    margin-top: 80px;
    margin-left: 270px;
  }

  @media (max-width: 780px) {
    header,
    .sidebar {
      display: none !important;
    }

    main {
      margin: 0 !important;
    }
  }
  @media (max-width: 700px) {
  header {
    padding: 10px;
    border-bottom: 1px solid #ccc;
    overflow: hidden;
    text-align: center;
  }

  .logo-brand {
    display: block;
    margin: 0 auto 10px auto;
  }

  .logo-brand img {
    width: 100px;
    height: auto;
    margin-right: 100px;
  }

  .dropdown.d-md-none {
    display: block;
    text-align: left;
    margin-bottom: 10px;
  }

  #profileDropdownToggle {
    display: inline-block;
    text-align: center;
    margin-top: 10px;
  }

  #profileDropdownToggle img {
    width: 40px;
    height: 40px;
  }

  .d-none.d-md-block.ms-auto.order-4 {
    display: inline-block;
    margin-top: 10px;
  }
}


  /* Styling kartu berita */
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

  /* Tambahan styling opsional jika ingin membedakan dua kartu terakhir */
  .card-news.wide-card {
    background-color: #f8f9fa;
  }

  .logo-brand img {
  width: 350px;
  height: 170px;
  margin: 0 auto;
  padding: 0;
  }


</style>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <!-- Header -->
  <header class="d-flex align-items-center px-3 py-2 border-bottom">
    <!-- Dropdown mobile & Profil tetap -->
    <div class="dropdown d-md-none order-1">
      <button class="btn btn-outline-secondary dropdown-toggle menu-drop" type="button" id="dropdownMobileMenu" data-bs-toggle="dropdown">
        <i class="bi bi-list"></i> Menu
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMobileMenu">
        <li><h6 class="dropdown-header">Divisi Karyawan</h6></li>
        <li><a class="dropdown-item" href="hr_dashboard.php"><i class="bi bi-person-circle me-1"></i> HR</a></li>
        <li><a class="dropdown-item" href="manajemen_dashboard.php"><i class="bi bi-people-fill me-1"></i> Manajemen</a></li>
        <li><a class="dropdown-item" href="karyawan_dashboard.php"><i class="bi bi-people-fill me-1"></i> Karyawan</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><h6 class="dropdown-header">Menu Lainnya</h6></li>
        <?php if ($user['role'] === 'Manajer Umum' || $user['role'] === 'Manajer HR'): ?>
        <li><a class="dropdown-item" href="laporan_kerja.php"><i class="bi bi-journal-text me-1"></i> Laporan Kerja</a></li>
        <?php elseif ($user['role'] === 'HR'): ?>
        <li><a class="dropdown-item" href="laporan_kerja.php"><i class="bi bi-journal-text me-1"></i> Kirim Laporan Kerja</a></li>
        <?php endif; ?>
        <li><a class="dropdown-item" href="feedback_pegawai.php"><i class="bi bi-chat-left-text me-1"></i> Feedback Pegawai</a></li>
        <li><a class="dropdown-item" href="shift_karyawan.php"><i class="bi bi-clock-history me-1"></i> Shift & Jadwal Karyawan</a></li>
      </ul>
    </div>
    <div id="profileDropdownToggle" class="d-flex align-items-center ms-3 order-3 order-md-1" style="cursor:pointer;">
      <img src="<?= htmlspecialchars($user['photo_url']) ?>" class="rounded-circle me-2" alt="Foto Profil" width="50" height="50">
      <div class="d-none d-md-block">
        <strong><?= htmlspecialchars($user['name']) ?></strong><br>
        <small class="text-muted"><?= htmlspecialchars($user['role']) ?></small>
      </div>
    </div>
    <div id="profileDropdown" class="position-absolute bg-white border shadow-sm rounded p-2" style="top:70px; right:20px; width:220px; display:none; z-index:999;">
      <strong class="d-block mb-2">Profil</strong>
      <a href="ubah_data.php" class="d-block mb-1 text-decoration-none text-dark"><i class="bi bi-pencil-square me-2"></i>Ubah Data Diri</a>
      <a href="ganti_password.php" class="d-block mb-1 text-decoration-none text-dark"><i class="bi bi-key me-2"></i>Ganti Password</a>
      <a href="jabatan_divisi.php" class="d-block mb-1 text-decoration-none text-dark"><i class="bi bi-diagram-3 me-2"></i>Jabatan & Divisi</a>
      <a href="sisa_cuti.php" class="d-block mb-1 text-decoration-none text-dark"><i class="bi bi-calendar-check me-2"></i>Sisa Cuti</a>
      <a href="tanggal_bergabung.php" class="d-block mb-1 text-decoration-none text-dark"><i class="bi bi-calendar-event me-2"></i>Tanggal Bergabung</a>
      <a href="riwayat_cuti.php" class="d-block mb-1 text-decoration-none text-dark"><i class="bi bi-clock-history me-2"></i>Riwayat Cuti</a>
      <hr>
      <a href="login.php" class="d-block text-decoration-none text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </div>
    <div class="mx-auto text-center order-2 logo-brand">
      <img src="img/logo_brand.png" alt="Logo">
    </div>
    <div class="d-none d-md-block ms-auto order-4">
      <a href="login.php" class="btn btn-outline-dark"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </header>

  <!-- Sidebar -->
  <nav class="sidebar">
    <h6 class="text-uppercase fw-bold mb-3">Divisi Karyawan</h6>
    <a href="hr_dashboard.php" class="btn btn-outline-primary nav-button"><i class="bi bi-person-circle me-1"></i>HR</a>
    <a href="manajemen_dashboard.php" class="btn btn-outline-primary nav-button"><i class="bi bi-people-fill me-1"></i> Manajemen</a>
    <a href="karyawan_dashboard.php" class="btn btn-outline-primary nav-button"><i class="bi bi-people-fill me-1"></i> Karyawan</a>
    <hr>
    <h6 class="fw-bold">MENU LAINNYA</h6>
    <?php if ($user['role'] === 'Manajer Umum' || $user['role'] === 'Manajer HR'): ?>
      <a href="laporan_kerja.php" class="btn btn-outline-dark nav-button"><i class="bi bi-file-earmark-text me-1"></i> Laporan Kerja</a>
    <?php elseif ($user['role'] === 'HR'): ?>
      <a href="laporan_kerja.php" class="btn btn-outline-dark nav-button"><i class="bi bi-file-earmark-text me-1"></i> Kirim Laporan Kerja</a>
      <?php elseif ($user['role'] === 'Karyawan'): ?>
        <a href="pengajuan_cuti.php" class="btn btn-outline-dark nav-button"><i class="bi bi-file-earmark-text me-1"></i> Pengajuan Cuti</a>
        <a href="slip_gaji.php" class="btn btn-outline-dark nav-button"><i class="bi bi-file-earmark-text me-1"></i> Slip Gaji</a>

    <?php endif; ?>
    <a href="feedback_pegawai.php" class="btn btn-outline-dark nav-button"><i class="bi bi-chat-dots me-1"></i> Feedback Pegawai</a>
    <a href="shift_karyawan.php" class="btn btn-outline-dark nav-button"><i class="bi bi-clock-history me-1"></i> Shift & Jadwal Karyawan</a>
  </nav>

  <!-- Main -->
<main class="px-4 py-4">
  <div class="container">
    <h3 class="mb-4">What's New</h3>
    <div class="row g-3">
      <?php 
        $totalItems = count($newsItems);
        foreach ($newsItems as $index => $item): 
          $isLastTwo = $index >= $totalItems - 2;
          $columnClass = $isLastTwo ? 'col-md-6' : 'col-md-3';
      ?>
      <div class="col-12 col-sm-6 <?= $columnClass ?>">
        <div class="card card-news p-2 shadow-sm h-100">
          <img src="<?= htmlspecialchars($item['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>">
          <div class="card-body p-2">
            <h6 class="fw-bold mb-1"><?= htmlspecialchars($item['title']) ?></h6>
            <small class="text-muted"><?= htmlspecialchars($item['date']) ?></small>
            <p class="mb-0 small"><?= htmlspecialchars($item['description']) ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</main>

  <script>
  $(document).ready(function(){
    $('#profileDropdownToggle').click(function(e){
      e.stopPropagation();
      var w = $(window).width();
      if (w>=400 && w<=765) $('#profileDropdown').slideToggle(150);
      else if (w>765){ e.preventDefault(); $('body').addClass('fade-out'); setTimeout(function(){ window.location.href='dashboard_profil.php'; },600); }
    });
    $(document).click(function(e){ if(!$(e.target).closest('#profileDropdown, #profileDropdownToggle').length) $('#profileDropdown').slideUp(150); });
    $(window).resize(function(){ var w=$(window).width(); if(w<400||w>765) $('#profileDropdown').hide(); });
  });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>