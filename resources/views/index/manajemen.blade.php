<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Dashboard - Naga Hytam Sejahtera Abadi</title>
  @vite([
      'resources/js/app.js',
      'resources/sass/app.scss',
      'resources/css/app.css'
      ])
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
    <a href="{{ url('dashboard') }}" class="btn btn-primary me-3">
      <i class="bi bi-house-door-fill me-1"></i> Home
    </a>
    <a class="navbar-brand" href="#">Manajemen Dashboard</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="{{ url('hr') }}">HR</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Manajemen</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('karyawan') }}">Karyawan</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-4">
  <h3 class="mb-4">Divisi Manajemen</h3>
  <div class="row row-cols-1 row-cols-md-2 g-4">
    @foreach ($managers as $manager)
      <div class="col">
        <div class="manager-card d-flex flex-column h-100">
          <div class="d-flex mb-3">
            <img src="{{ asset($manager->photo_url) }}" alt="Foto {{ $manager->name }}" class="profile-photo me-3">
            <div>
              <h5 class="mb-1">{{ $manager->name }}</h5>
              <p class="mb-1"><strong>Jabatan:</strong> {{ $manager->role }}</p>
              <p class="mb-1"><strong>Email:</strong> {{ $manager->email }}</p>
              <p class="mb-1"><strong>Telepon:</strong> {{ $manager->phone }}</p>
            </div>
          </div>
          <p class="mt-auto mb-0">{{ $manager->bio }}</p>
        </div>
      </div>
    @endforeach
  </div>
</div>
</body>
</html>
