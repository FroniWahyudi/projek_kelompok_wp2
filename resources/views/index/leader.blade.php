<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Divisi HR & Leader - Naga Hytam Sejahtera Abadi</title>
  @vite([
      'resources/js/app.js',
      'resources/sass/app.scss',
      'resources/css/app.css'
      ])
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    html, body { height: 100%; margin: 0; }
    body { display: flex; flex-direction: column; font-family: 'Poppins', sans-serif; font-size:.9rem; color:#6c757d; background:#f8f9fa; }
    main { flex: 1; }
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
      text-decoration: none;
    }
    .navbar-brand .dot {
      width: 10px;
      height: 10px;
      background-color: #00c8c8;
      border-radius: 50%;
      display: inline-block;
    }
    .navbar-nav .nav-link {
      color: #6c757d;
      font-weight: 500;
      margin-left: 1.5rem;
      font-size: .9rem;
    }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: #0d6efd !important;
    }
    .profile-card {
      background: #fff;
      border-radius: .5rem;
      box-shadow: 0 .25rem .5rem rgba(0,0,0,.1);
      padding: 1.5rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: transform .2s;
      height: 100%;
    }
    .profile-card:hover { transform: translateY(-5px); }
    .avatar {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #dee2e6;
    }
    .profile-header {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
    }
    .profile-header h5 { margin: 0; font-weight: 600; color: #495057; }
    .profile-header .role { font-size: .85rem; color: #00c8c8; font-weight: 500; }
    .badge-level { background: #e0f7f7; color: #0d6efd; font-size: .65rem; padding: .25em .5em; margin-left: .5em; }
    .btn-detail { font-size: .85rem; padding: .25rem .5rem; width: 100px; }
    footer#my-footer {
      background: #fff;
      border-top: 1px solid #dee2e6;
      padding: 1rem 0;
      text-align: center;
      font-size: .8rem;
      color: #868e96;
      /* sticky footer */
      margin-top: auto;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid px-lg-5">
      <a class="navbar-brand" href="{{ url('dashboard') }}">
        <span class="dot"></span>
        <span>Divisi Leader</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navMenu">
  <ul class="navbar-nav">
    <li class="nav-item"><a class="nav-link" href="{{ url('dashboard') }}">Home</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ url('manajemen') }}">Manajer</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ url('admin') }}">Admin</a></li>
    <li class="nav-item"><a class="nav-link active" href="{{ url('leader') }}">Leader</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ url('operator') }}">Operator</a></li>
  </ul>
</div>

    </div>
  </nav>

  <!-- Content -->
  <main class="container py-5">
    <div class="row gx-4">
      @foreach ($users as $user)
        <div class="col-md-6 d-flex mb-4">
          <div class="profile-card w-100">
            <div class="profile-header">
              <img src="{{ asset($user->photo_url) }}" class="avatar me-3" alt="{{ $user->name }}">
              <div>
                <h5>{{ $user->name }}</h5>
                <div class="role">
                  {{ $user->role }}
                  <span class="badge-level">{{ $user->level }}</span>
                </div>
              </div>
            </div>
            <p class="mb-2">{{ $user->bio }}</p>
            <p class="mb-3"><i class="bi bi-envelope me-1"></i> {{ $user->email }}</p>
            <button class="btn btn-primary btn-sm btn-detail" data-bs-toggle="modal" data-bs-target="#detailModal{{ $user->id }}">
              Lihat Detail
            </button>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="detailModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">{{ $user->name }} — Detail Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="d-flex align-items-center mb-4">
                  <img src="{{ asset($user->photo_url) }}" class="avatar me-3" alt="">
                  <div>
                    <h6 class="mb-0">{{ $user->name }}</h6>
                    <small class="text-primary">{{ $user->role }}</small>
                    <span class="badge bg-info text-dark ms-2">{{ $user->level }}</span><br>
                    <small class="text-muted"><i class="bi bi-envelope me-1"></i> {{ $user->email }}</small>
                    <small class="text-muted ms-3"><i class="bi bi-telephone me-1"></i> {{ $user->phone }}</small>
                  </div>
                </div>

                <h6>Informasi Pribadi</h6>
                <div class="row mb-3">
                  <div class="col-sm-6"><strong>Alamat:</strong><br>{{ $user->alamat }}</div>
                  <div class="col-sm-6"><strong>Joined:</strong><br>{{ \Carbon\Carbon::parse($user->joined_at)->format('d M Y') }}</div>
                </div>
                <div class="row mb-4">
                  <div class="col-sm-6"><strong>Pendidikan:</strong><br>{{ $user->education }}</div>
                  <div class="col-sm-6"><strong>Departemen:</strong><br>{{ $user->department }}</div>
                </div>

                <h6>Deskripsi Pekerjaan</h6>
                <ul>
                  @foreach(explode(', ', $user->job_descriptions) as $jd)
                    <li>{{ $jd }}</li>
                  @endforeach
                </ul>

                <h6>Keahlian</h6>
                <div class="mb-3">
                  @foreach(explode(', ', $user->skills) as $s)
                    <span class="badge bg-secondary me-1">{{ $s }}</span>
                  @endforeach
                </div>

                <h6>Pencapaian</h6>
                <ul>
                  @foreach(explode(', ', $user->achievements) as $a)
                    <li>{{ $a }}</li>
                  @endforeach
                </ul>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </main>

  <footer id="my-footer">
    <div class="container text-center">
      <small>© {{ date('Y') }} PT Naga Hytam Sejahtera Abadi. All Rights Reserved.</small>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
