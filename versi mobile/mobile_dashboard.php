<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Dashboard Mobile - Naga Hytam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">
  <style>
    body {
      background-color: #f9fafb;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding-bottom: 70px; /* ruang untuk bottom-nav */
    }

    /* Header Fixed Full Width */
    .app-header {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: 72px;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1rem;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      z-index: 1000;
    }
    .app-header img.logo {
      /* Isi lebar header, tetap proporsional */
      margin-left: -10px;
      width: 242px;
      margin-top: 7px;
    }
    .app-header .icon-btn {
      font-size: 1.2rem;
      color: #6c757d;
    }

    /* Konten di bawah header */
    .main-content {
      padding-top: 72px; /* cukup untuk header */
    }

    /* Welcome */
    .welcome-section {
      padding: 1.25rem 1rem 0.5rem;
    }
    .welcome-section h6 {
      color: #6c757d;
      margin-bottom: 0.25rem;
    }
    .welcome-section h5 {
      margin: 0;
      font-weight: bold;
    }

    /* Menu Grid */
    .menu-grid {
      display: flex;
      justify-content: space-between;
      gap: 1rem;
      padding: 0.5rem 1rem;
    }
    .menu-item {
      flex: 1;
      background: #fff;
      border-radius: 1rem;
      text-align: center;
      padding: 1rem 0.5rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .menu-item i {
      display: block;
      font-size: 1.5rem;
      margin-bottom: 0.5rem;
    }
    .menu-item.shift i {
      background: #dbeafe;
      color: #0d6efd;
      padding: 1rem;
      border-radius: 0.5rem;
    }
    .menu-item.karyawan i {
      background: #fee2e2;
      color: #d90516;
      padding: 1rem;
      border-radius: 0.5rem;
    }
  .menu-item.cuti i {
  background: #dcfce7;   /* pastel green */
  color: #059669;
  padding: 1rem;
  border-radius: 0.5rem;
}

    .menu-item small {
      display: block;
      font-weight: 600;
      color: #000;
      font-style: normal;
    }

    /* What's New Vertical List */
    .section-news {
      padding: 1rem;
    }
    .section-news .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 0.75rem;
    }
    .section-news .header h5 {
      margin: 0;
      font-weight: 600;
    }
    .section-news .header a {
      font-size: 0.875rem;
    }
    .card-news {
      background: #fff;
      border-radius: 1rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      margin-bottom: 1rem;
      overflow: hidden;
    }
    .card-news .card-body {
      padding: 1rem;
    }
    .badge-news {
      background: #e0e7ff;
      color: #3730a3;
      font-size: 0.75rem;
      padding: 0.25rem 0.5rem;
      border-radius: 0.375rem;
      margin-right: 0.5rem;
    }

    /* Bottom Nav */
    .bottom-nav {
      position: fixed;
      bottom: 0; left: 0; right: 0;
      display: flex;
      justify-content: space-around;
      background: #fff;
      border-top: 1px solid #dee2e6;
      padding: 0.5rem 0;
      z-index: 1000;
    }
    .bottom-nav .nav-item {
      text-align: center;
      font-size: 0.75rem;
      color: #6c757d;
    }
    .bottom-nav .nav-item.active {
      color: #0d6efd;
      font-weight: 600;
    }
    .bottom-nav i {
      display: block;
      font-size: 1.25rem;
      margin-bottom: 0.25rem;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="app-header">
    <div class="d-flex align-items-center">
      <img src="img/logo_brand.png" class="logo" alt="Logo Brand">
    </div>
    <a href="dashboard_profil.php" class="d-block">
    <img src="img/CJ.jpg" alt="Foto Profil" class="rounded-circle" style="width:32px; height:32px; object-fit:cover;">
  </a>
  </div>

  <div class="main-content">
    <!-- Welcome -->
    <div class="welcome-section">
      <h6>Selamat datang,</h6>
      <h5>Sutoyo dono</h5>
    </div>

   <!-- Menu -->
<div class="menu-grid">
  <a href="mobile_shift.php" class="menu-item shift text-decoration-none text-center">
    <i class="bi bi-clock-history fs-2"></i>
    <small class="d-block mt-1">Shift</small>
  </a>
  <a href="karyawan.php" class="menu-item karyawan text-decoration-none text-center">
    <i class="bi bi-person-circle fs-2"></i>
    <small class="d-block mt-1">Karyawan</small>
  </a>
  <a href="cuti.php" class="menu-item cuti text-decoration-none text-center">
    <i class="bi bi-calendar-check fs-2"></i>
    <small class="d-block mt-1">Daftar Cuti</small>
  </a>
</div>



    <!-- What's New -->
<div class="section-news">
  <div class="header">
    <h5>What's New</h5>
    <a href="#">Lihat Semua</a>
  </div>

  <!-- News Card 1 -->
<div class="card-news">
  <img src="img/karyawan_inovasi.png" alt="Series X"
       style="width:100%; height:180px; object-fit:cover; border-radius: 1rem 1rem 0 0;">
  <div class="card-body">
    <div class="d-flex align-items-center mb-2">
      <span class="badge-news">Pengumuman</span>
      <small class="text-muted">29 Juni 2025</small>
    </div>
    <h6 class="mb-1"><strong>Peluncuran Series X</strong></h6>
    <p class="mb-0 text-muted" style="font-size:0.9rem;">
      Perusahaan akan meluncurkan Series X, inovasi terbaru dari tim R&D kami.
    </p>
  </div>
</div>

<!-- News Card 2 -->
<div class="card-news">
  <img src="img/peningkatan_gudang.png" alt="Kantor Baru"
       style="width:100%; height:180px; object-fit:cover; border-radius: 1rem 1rem 0 0;">
  <div class="card-body">
    <div class="d-flex align-items-center mb-2">
      <span class="badge-news">Berita</span>
      <small class="text-muted">28 Juni 2025</small>
    </div>
    <h6 class="mb-1"><strong>Pembukaan Kantor Baru</strong></h6>
    <p class="mb-0 text-muted" style="font-size:0.9rem;">
      Kami membuka kantor cabang baru untuk mendekatkan layanan ke pelanggan.
    </p>
  </div>
</div>

<!-- News Card 3 -->
<div class="card-news">
  <img src="img/rapat_kenaikan_harga.png" alt="Workflow Tips"
       style="width:100%; height:180px; object-fit:cover; border-radius: 1rem 1rem 0 0;">
  <div class="card-body">
    <div class="d-flex align-items-center mb-2">
      <span class="badge-news">Tips</span>
      <small class="text-muted">27 Juni 2025</small>
    </div>
    <h6 class="mb-1"><strong>Optimalisasi Workflow</strong></h6>
    <p class="mb-0 text-muted" style="font-size:0.9rem;">
      Cara meningkatkan efisiensi kerja dengan memanfaatkan fitur dashboard.
    </p>
  </div>
</div>


</div>


  <!-- Bottom Navigation -->
<nav class="bottom-nav">
  <a href="mobile_dashboard.html" class="nav-item active text-decoration-none">
    <i class="bi bi-house-fill"></i>
    Home
  </a>
  <a href="explore.php" class="nav-item text-decoration-none">
    <i class="bi bi-search"></i>
    Explore
  </a>
  <a href="profile.php" class="nav-item text-decoration-none">
    <i class="bi bi-person-fill"></i>
    Profile
  </a>
</nav>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
  </script>
</body>
</html>
