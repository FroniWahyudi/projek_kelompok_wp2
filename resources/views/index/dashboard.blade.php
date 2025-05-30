<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Naga Hytam Sejahtera Abadi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <style>
    :root {
      --primary-color: #3498db;
      --secondary-color: #2c3e50;
      --accent-color: #e74c3c;
      --light-color: #ecf0f1;
      --dark-color: #2c3e50;
      --success-color: #2ecc71;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f7fa;
      color: #333;
      overflow-x: hidden;
    }
    
    /* === NAVBAR STYLING === */
    .navbar-custom {
      background-color: white;
      height: 80px;
      box-shadow: 0 2px 15px rgba(0,0,0,0.1);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1030;
      display: flex;
      align-items: center;
      padding: 0 1.5rem;
      transition: all 0.3s ease;
    }
    
    .navbar-custom.scrolled {
      height: 70px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .navbar-custom .nav-item {
      margin-right: 1rem;
    }
    
    .navbar-custom .logo-brand {
      flex: 1;
      text-align: center;
    }
    
    .navbar-custom .logo-brand img {
      height: 69px;
      object-fit: contain;
      transition: all 0.3s ease;
    }
    
    .navbar-custom.scrolled .logo-brand img {
      height: 70px;
    }
    
    /* === SIDEBAR STYLING === */
    .sidebar {
      position: fixed;
      top: 80px;
      bottom: 0;
      left: 0;
      width: 250px;
      background-color: white;
      border-right: 1px solid #e0e0e0;
      padding: 1.5rem 1rem;
      overflow-y: auto;
      z-index: 1020;
      transition: all 0.3s ease;
      box-shadow: 2px 0 10px rgba(0,0,0,0.05);
    }
    
    .sidebar:hover {
      box-shadow: 2px 0 15px rgba(0,0,0,0.1);
    }
    
    .sidebar h6 {
      color: var(--secondary-color);
      font-weight: 600;
      margin-top: 1rem;
      margin-bottom: 0.75rem;
      padding-left: 0.5rem;
      border-left: 3px solid var(--primary-color);
    }
    
    .sidebar hr {
      margin: 1.5rem 0;
      opacity: 0.2;
    }
    
    .sidebar .btn {
      margin-bottom: 0.75rem;
      text-align: center;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      transition: all 0.2s ease;
      font-size: 1rem;
      position: relative;
      overflow: hidden;
      width: 194px;
    }
    
    .sidebar .btn:hover {
      transform: translateX(5px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .sidebar .btn i {
      margin-right: 0.5rem;
      width: 20px;
      text-align: center;
    }
    
    /* === MAIN CONTENT STYLING === */
    main {
      margin-top: 100px;
      margin-left: 270px;
      padding: 1.5rem;
      transition: all 0.3s ease;
    }
    
    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid #eee;
    }
    
    .page-header h3 {
      font-weight: 700;
      color: var(--secondary-color);
      position: relative;
      padding-left: 1rem;
    }
    
    .page-header h3::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      height: 70%;
      width: 4px;
      background-color: var(--primary-color);
      border-radius: 4px;
    }
    
    /* === NEWS CARDS STYLING === */
    .news-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 1.5rem;
    }
    
    .card-news {
      border: none;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
      background-color: white;
      position: relative; /* Menambahkan posisi relatif untuk tombol absolut */
    }
    
    .card-news:hover {
      transform: translateY(-8px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .card-news a {
      text-decoration: none;
      color: inherit;
      display: flex;
      flex-direction: column;
      height: 100%; /* Mengubah dari 20% ke 100% untuk memastikan tautan mengisi seluruh kartu */
    }
    
    .card-news img {
      height: 180px;
      object-fit: cover;
      width: 100%;
      transition: transform 0.5s ease;
    }
    
    .card-news:hover img {
      transform: scale(1.05);
    }
    
    .card-news .card-body {
      padding: 1.25rem;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }
    
    .card-news .card-title {
      font-weight: 600;
      margin-bottom: 0.75rem;
      color: var(--dark-color);
    }
    
    .card-news .card-text {
      color: #666;
      font-size: 0.9rem;
      margin-bottom: 1rem;
      flex-grow: 1;
    }
    
    .card-news .card-date {
      font-size: 0.8rem;
      color: #999;
      margin-top: auto;
    }
    
    /* Styling untuk tombol edit dan delete */
     .delete-btn {
      position: absolute;
      top: 10px;
      background-color: rgba(255,255,255,0.9);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      z-index: 2;
      opacity: 0; /* Tombol disembunyikan secara default */
      transition: all 0.3s ease;
    }
    .edit-btn {
      position: absolute;
      top: 10px;
      background-color: rgba(255,255,255,0.9);
      width: 40px;
      height: 10px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      z-index: 2;
      opacity: 0; /* Tombol disembunyikan secara default */
      transition: all 0.3s ease;
    }

    /* Posisi tombol edit */
    .edit-btn {
      right: 60px; /* Tombol edit di sebelah kiri tombol delete */
    }

    /* Posisi tombol delete */
    .delete-btn {
      right: 10px; /* Tombol delete di pojok kanan atas */
    }

    /* Menampilkan tombol saat hover */
    .card-news:hover .edit-btn,
    .card-news:hover .delete-btn {
      opacity: 1; /* Tombol muncul saat card-news di-hover */
    }

    /* Efek hover pada tombol */
    .edit-btn:hover, .delete-btn:hover {
      /* background-color: white; */
      transform: scale(1.1);
    }
    
    /* === PROFILE MODAL STYLING === */
    .profile-modal .modal-content {
      border-radius: 15px;
      overflow: hidden;
      border: none;
    }
    
    .profile-modal .modal-header {
      background-color: var(--primary-color);
      color: white;
      border-bottom: none;
      padding: 1.5rem;
    }
    
    .profile-modal .modal-body {
      padding: 0;
    }
    
    .profile-card {
      border: none;
      border-radius: 0;
      padding: 2rem;
    }
    
    .profile-img-container {
      display: flex;
      justify-content: center;
      margin-bottom: 1.5rem;
    }
    
    .profile-img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 5px solid white;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .profile-name {
      font-size: 1.5rem;
      font-weight: 700;
      text-align: center;
      margin-bottom: 0.5rem;
      color: var(--dark-color);
    }
    
    .profile-email {
      text-align: center;
      color: #666;
      margin-bottom: 1.5rem;
    }
    
    .profile-contact {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0.5rem;
      margin-bottom: 1.5rem;
      color: #666;
    }
    
    .profile-bio {
      background-color: #f9f9f9;
      padding: 1rem;
      border-radius: 8px;
      margin-bottom: 1.5rem;
      color: #555;
    }
    
    .profile-section-title {
      font-weight: 600;
      color: var(--secondary-color);
      margin-bottom: 1rem;
      position: relative;
      padding-left: 0.75rem;
    }
    
    .profile-section-title::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      height: 70%;
      width: 3px;
      background-color: var(--primary-color);
      border-radius: 3px;
    }
    
    .profile-job-desc {
      margin-bottom: 1.5rem;
    }
    
    .profile-job-desc ul {
      padding-left: 1.5rem;
      margin-bottom: 0;
    }
    
    .profile-job-desc li {
      margin-bottom: 0.5rem;
      color: #555;
    }
    
    .profile-join-date {
      background-color: #f0f0f0;
      padding: 0.75rem;
      border-radius: 8px;
      text-align: center;
      font-weight: 500;
      color: #666;
    }
    
    .edit-profile-btn {
      display: block;
      width: 100%;
      padding: 0.75rem;
      background-color: var(--primary-color);
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: 500;
      transition: all 0.3s ease;
      margin-top: 1.5rem;
    }
    
    .edit-profile-btn:hover {
      background-color: #2980b9;
      transform: translateY(-2px);
      box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    }
    
    /* === BUTTON STYLING === */
    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      padding: 0.5rem 1.25rem;
      border-radius: 8px;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
      background-color: #2980b9;
      border-color: #2980b9;
      transform: translateY(-2px);
      box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    }
    
    .btn-outline-dark {
      border-radius: 8px;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .btn-outline-dark:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    }
    
    /* === MOBILE MENU STYLING === */
    .mobile-menu-btn {
      border-radius: 8px;
      padding: 0.5rem 1rem;
      font-weight: 500;
    }
    
    .mobile-dropdown-menu {
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      border: none;
      padding: 0.5rem;
    }
    
    .mobile-dropdown-menu .dropdown-header {
      font-weight: 600;
      color: var(--secondary-color);
    }
    
    .mobile-dropdown-menu .dropdown-item {
      border-radius: 6px;
      margin-bottom: 0.25rem;
      transition: all 0.2s ease;
    }
    
    .mobile-dropdown-menu .dropdown-item:hover {
      background-color: #f8f9fa;
      transform: translateX(5px);
    }
    
    .mobile-dropdown-menu .dropdown-item i {
      width: 20px;
      text-align: center;
      margin-right: 0.5rem;
    }
    
    /* === PROFILE DROPDOWN STYLING === */
    .profile-dropdown-toggle {
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: all 0.3s ease;
      padding: 0.5rem;
      border-radius: 50px;
    }
    
    .profile-dropdown-toggle:hover {
      background-color: #f0f0f0;
    }
    
    .profile-img-sm {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 50%;
      margin-right: 0.75rem;
      border: 2px solid #eee;
    }
    
    .profile-info {
      line-height: 1.2;
    }
    
    .profile-info strong {
      display: block;
      font-weight: 600;
    }
    
    .profile-info small {
      color: #666;
      font-size: 0.85rem;
    }
    
    /* === ANIMATIONS === */
    .animate-fade-in {
      animation: fadeIn 0.5s ease forwards;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    
    /* === RESPONSIVE STYLES === */
    @media (max-width: 992px) {
      .sidebar {
        transform: translateX(-100%);
        width: 280px;
      }
      
      .sidebar.active {
        transform: translateX(0);
      }
      
      main {
        margin-left: 0;
      }
      
      .navbar-custom .logo-brand img {
        height: 70px;
      }
    }
    
    @media (max-width: 768px) {
      .navbar-custom {
        padding: 0 1rem;
      }
      
      .navbar-custom .logo-brand img {
        height: 50px;
      }
      
      main {
        margin-top: 90px;
        padding: 1rem;
      }
      
      .page-header {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .page-header .btn {
        margin-top: 1rem;
      }
    }
    
    @media (max-width: 576px) {
      .news-grid {
        grid-template-columns: 1fr;
      }
      
      .navbar-custom .logo-brand img {
        height: 40px;
      }
      
      .profile-img-sm {
        width: 40px;
        height: 40px;
      }
    }
    
    /* === UTILITY CLASSES === */
    .cursor-pointer {
      cursor: pointer;
    }
    
    .shadow-soft {
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .transition {
      transition: all 0.3s ease;
    }
    
    /* === CUSTOM SCROLLBAR === */
    ::-webkit-scrollbar {
      width: 8px;
    }
    
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
      background: #ccc;
      border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
      background: #aaa;
    }
  .notification-dot {
    display: inline-block;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background-color: red;
    margin-left: 5px;
    position: absolute;
    top: 416px;
    z-index: 100;
    left: 197px;
}

.notification-dot-cuti {
    width: 15px;
    height: 15px;
    background-color: red;
    border-radius: 50%;
    position: absolute;
    top: 363px;
    z-index: 100;
    left: 200px;
}
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar-custom">
    <!-- Mobile Menu Button -->
    <div class="dropdown d-lg-none nav-item">
      <button class="btn btn-outline-secondary mobile-menu-btn" type="button" id="mobileMenu" data-bs-toggle="dropdown">
        <i class="bi bi-list"></i> Menu
      </button>
      <ul class="dropdown-menu mobile-dropdown-menu animate__animated animate__fadeIn" aria-labelledby="mobileMenu">
        <li><h6 class="dropdown-header">Divisi Karyawan</h6></li>
        <li><a class="dropdown-item" href="{{ route('hr.manajemen') }}"><i class="bi bi-people-fill me-1"></i> Manajemen</a></li>
        <li><a class="dropdown-item" href="{{ route('hr.admin') }}"><i class="bi bi-person-circle me-1"></i> Administrasi</a></li>
        <li><a class="dropdown-item" href="{{ route('hr.leader') }}"><i class="bi bi-people-fill me-1"></i> Leader</a></li>
        <li><a class="dropdown-item" href="{{ route('operator.index') }}"><i class="bi bi-people-fill me-1"></i> Operator Gudang</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><h6 class="dropdown-header">Menu Lainnya</h6></li>
        @if(auth()->user()->role === 'Manajer' || auth()->user()->role === 'Admin')
          <li><a class="dropdown-item" href="{{ route('laporan.index') }}"><i class="bi bi-journal-text me-1"></i> Daftar Resi</a></li>
          <li><a class="dropdown-item" href="{{ route('reset.password.form') }}"><i class="bi bi-key me-1"></i> Reset Password</a></li>
        @endif

        @if(auth()->user()->role === 'Leader')
          <li><a class="dropdown-item" href="{{ route('laporan.index') }}"><i class="bi bi-journal-text me-1"></i> Resi hari ini</a></li>
        @endif
      @if(auth()->user()->role === 'Manajer')
        <li>
          <a class="dropdown-item" href="{{ route('cuti.index') }}">
            <i class="bi bi-check-square me-1"></i> Daftar Pengajuan Cuti
            @if(app('App\Http\Controllers\CutiController')->hasPendingRequests())
              <span class="notification-dot"></span>
            @endif
          </a>
        </li>
      @endif
        @if(auth()->user()->role === 'Operator' || auth()->user()->role === 'Admin' || auth()->user()->role === 'Leader')
          <li><a class="dropdown-item" href="{{ route('cuti.index') }}"><i class="bi bi-file-earmark-text me-1"></i> Pengajuan Cuti</a></li>
          <li><a class="dropdown-item" href="{{ route('slips.index') }}"><i class="bi bi-receipt me-1"></i> Slip Gaji</a></li>
        @endif
        <li>
          <a class="dropdown-item" href="feedback">
            <i class="bi bi-chat-dots me-1"></i>
            @if(auth()->user()->role === 'Operator')
              Evaluasi Kinerja
            @else
              Feedback Pegawai
            @endif
          </a>
        </li>
        <li><a class="dropdown-item" href="{{ route('shift.karyawan') }}"><i class="bi bi-clock-history me-1"></i> Shift & Jadwal</a></li>
        
      </ul>
    </div>

    <!-- Profile Dropdown -->
    <div id="profileDropdownToggle" class="profile-dropdown-toggle nav-item" data-bs-toggle="modal" data-bs-target="#profileModal">
      <img src="<?= htmlspecialchars($user['photo_url'] ?: 'img/default_profile.png') ?>" 
           class="profile-img-sm" alt="Foto Profil">
      <div class="profile-info d-none d-md-block">
        <strong><?= htmlspecialchars($user['name']) ?></strong>
        <small><?= htmlspecialchars($user['role']) ?></small>
      </div>
    </div>

    <!-- Logo Center -->
    <div class="logo-brand">
      <img src="img/logo_brand.png" alt="Logo Brand" class="transition">
    </div>

    <!-- Logout Button -->
    <div class="ms-auto nav-item d-none d-lg-block">
      <a href="/logout" class="btn btn-outline-dark">
        <i class="bi bi-box-arrow-right me-1"></i>
        Logout
      </a>
    </div>
  </nav>

  <!-- Sidebar -->
  <nav class="sidebar">
    <h6 class="fw-bold text-uppercase">Divisi Karyawan</h6>

    <a href="{{ route('hr.manajemen') }}" class="btn btn-outline-primary">
      <i class="bi bi-people-fill me-1"></i> Manajemen
    </a>
    <a href="{{ route('hr.admin') }}" class="btn btn-outline-primary">
      <i class="bi bi-person-circle me-1"></i> Administrasi
    </a>
    <a href="{{ route('hr.leader') }}" class="btn btn-outline-primary">
      <i class="bi bi-people-fill me-1"></i> Leader
    </a>
    <a href="{{ route('operator.index') }}" class="btn btn-outline-primary">
      <i class="bi bi-people-fill me-1"></i> Operator Gudang
    </a>

    <hr>

    <h6 class="fw-bold">Menu Lainnya</h6>
    @if(auth()->user()->role === 'Admin')
      <a class="btn btn-outline-dark" href="{{ route('reset.password.form') }}">
      <i class="bi bi-key me-1"></i> Reset Password
      <span id="resetNotification" class="badge bg-danger rounded-pill" style="display: none;">!</span>
      </a>
    @endif

    @if(auth()->user()->role === 'Manajer' || auth()->user()->role === 'Admin')
      <a href="{{ route('laporan.index') }}" class="btn btn-outline-dark">
      <i class="bi bi-journal-text me-1"></i> Daftar Resi
      </a>
    @endif

    @if(auth()->user()->role === 'Leader')
      <a href="{{ route('laporan.index') }}" class="btn btn-outline-dark">
        <i class="bi bi-journal-text me-1"></i> Resi hari ini
      </a>
    @endif

    @if(auth()->user()->role === 'Manajer')
     @if(app('App\Http\Controllers\CutiController')->hasPendingRequests())
          <span class="notification-dot"></span>
        @endif
      <a class="btn btn-outline-dark position-relative" href="{{ route('cuti.index') }}">
        <i class="bi bi-check-square me-1"></i> Daftar Cuti
      </a>
    @endif
    
@if(auth()->user()->role === 'Operator' || auth()->user()->role === 'Admin' || auth()->user()->role === 'Leader')
 @if(app('App\Http\Controllers\CutiController')->hasNonPendingRequests())
            <span class="notification-dot-cuti">
            </span>
        @endif
    <a href="{{ route('cuti.index') }}" class="btn btn-outline-dark">
        <i class="bi bi-check-square me-1"></i> Pengajuan Cuti
       
    </a>
    <a href="{{ route('slips.index') }}" class="btn btn-outline-dark">
        <i class="bi bi-receipt me-1"></i> Slip Gaji
    </a>
@endif

    <a href="feedback" class="btn btn-outline-dark">
      <i class="bi bi-chat-dots me-1"></i>
      @if(auth()->user()->role === 'Operator')
        Evaluasi Kinerja
      @else
        Feedback Pegawai
      @endif
    </a>

    <a href="{{ route('shift.karyawan') }}" class="btn btn-outline-dark">
      <i class="bi bi-clock-history me-1"></i> Shift & Jadwal
    </a>

  </nav>

  <!-- Main Content -->
  <main>
    <div class="page-header animate__animated animate__fadeIn">
      <h3>What's New</h3>
      @if(auth()->user()->role === 'Manajer' || auth()->user()->role === 'Admin')
        <a href="{{ route('whats_new.create') }}" class="btn btn-primary">
          <i class="bi bi-plus-lg me-1"></i> New Post
        </a>
      @endif
    </div>
    
    <div class="news-grid">
      @foreach($newsItems as $idx => $item)
        <div class="animate-fade-in delay-{{ ($idx % 4) + 1 }}">
          <div class="card card-news">
            <div class="position-relative">
              <a href="{{ route('whats_new', ['id' => $item['id']]) }}">
                <img src="{{ htmlspecialchars($item['image_url']) }}" 
                     class="card-img-top" 
                     alt="{{ htmlspecialchars($item['title']) }}">
              </a>
              @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manajer')
                <a href="{{ route('whats_new.edit', ['id' => $item['id']]) }}" 
                   class="edit-btn" 
                   title="Edit" style="height: 40px; width: 40px;">
                  <i class="bi bi-pencil-square text-primary"></i>
                </a>
                <form action="{{ route('whats_new.delete', ['id' => $item['id']]) }}" 
                      method="POST" 
                      class="delete-form">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="delete-btn" title="Delete">
                    <i class="bi bi-trash text-danger"></i>
                  </button>
                </form>
              @endif
            </div>
            <div class="card-body">
              <a href="{{ route('whats_new', ['id' => $item['id']]) }}">
                <h5 class="card-title">{{ htmlspecialchars($item['title']) }}</h5>
                <p class="card-text">{{ Str::limit($item['description'], 120) }}</p>
                <div class="card-date">
                  <i class="bi bi-calendar me-1"></i> {{ htmlspecialchars($item['date']) }}
                </div>
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </main>

  <!-- Profile Modal -->
  <div class="modal fade profile-modal" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="profileModalLabel">Profile Details</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="profile-card">
            <div class="profile-img-container">
              <img src="{{ htmlspecialchars($user['photo_url']) }}" 
                   class="profile-img" 
                   alt="Profile Image">
            </div>
            
            <h4 class="profile-name">{{ htmlspecialchars($user['name']) }}</h4>
            <div class="profile-email">{{ htmlspecialchars($user['email']) }}</div>
            
            <div class="profile-contact">
              <i class="bi bi-telephone"></i>
              <span>{{ htmlspecialchars($user['phone']) }}</span>
            </div>
            
            @if($user['bio'])
              <div class="profile-bio">
                {{ htmlspecialchars($user['bio']) }}
              </div>
            @endif
            
            <h6 class="profile-section-title">Deskripsi Pekerjaan</h6>
            <div class="profile-job-desc">
              <ul>
                @foreach(explode(', ', $user['job_descriptions']) as $jd)
                  <li>{{ $jd }}</li>
                @endforeach
              </ul>
            </div>
            
            <div class="profile-join-date">
              <i class="bi bi-calendar-check"></i> Joined {{ \Carbon\Carbon::parse($user['joined_at'])->format('j F Y') }}
            </div>
            
            <a href="edit_profil/{{ $user['id'] }}" class="edit-profile-btn">
              <i class="bi bi-pencil-square me-1"></i> Edit Profile
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      // Navbar scroll effect
      $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
          $('.navbar-custom').addClass('scrolled');
        } else {
          $('.navbar-custom').removeClass('scrolled');
        }
      });
      
      // Animate elements on scroll
      function animateOnScroll() {
        $('.animate-fade-in').each(function() {
          var elementPosition = $(this).offset().top;
          var scrollPosition = $(window).scrollTop() + $(window).height();
          
          if (elementPosition < scrollPosition - 100) {
            $(this).css('opacity', '1');
          }
        });
      }
      
      // Initial check
      animateOnScroll();
      
      // Check on scroll
      $(window).scroll(function() {
        animateOnScroll();
      });
      
      // Mobile menu toggle for sidebar
      $('#mobileMenu').click(function() {
        $('.sidebar').toggleClass('active');
      });
      
      // Close sidebar when clicking outside
      $(document).click(function(e) {
        if (!$(e.target).closest('.sidebar, #mobileMenu').length) {
          $('.sidebar').removeClass('active');
        }
      });
      
      // Prevent closing when clicking inside sidebar
      $('.sidebar').click(function(e) {
        e.stopPropagation();
      });
      
      // Smooth hover effects
      $('.card-news').hover(
        function() {
          $(this).find('.card-title').css('color', 'var(--primary-color)');
        },
        function() {
          $(this).find('.card-title').css('color', 'var(--dark-color)');
        }
      );
      
      // Profile modal animation
      $('#profileModal').on('show.bs.modal', function() {
        $(this).find('.modal-content').addClass('animate__animated animate__zoomIn');
      });
      
      $('#profileModal').on('hidden.bs.modal', function() {
        $(this).find('.modal-content').removeClass('animate__animated animate__zoomIn');
      });
      
      // Konfirmasi untuk tombol delete
      document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
          if (!confirm('Are you sure you want to delete this post?')) {
            e.preventDefault();
          }
        });
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      fetch("{{ route('check.reset.requests') }}")
        .then(response => response.json())
        .then(data => {
          const notification = document.getElementById('resetNotification');
          if (data.exists) {
            notification.style.display = 'inline-block';
          } else {
            notification.style.display = 'none';
          }
        })
        .catch(error => console.error('Error:', error));
    });
  </script>
</body>
</html>