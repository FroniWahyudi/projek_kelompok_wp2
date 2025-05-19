@unless(request()->has('ajax'))
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manajemen Dashboard - Naga Hytam Sejahtera Abadi</title>
  @vite([
    'resources/js/app.js',
    'resources/sass/app.scss',
    'resources/css/app.css'
  ])
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    html, body { height:100%; margin:0; }
    body { display:flex; flex-direction:column; font-family:'Poppins',sans-serif; font-size:.9rem; color:#6c757d; background:#f8f9fa; }
    main { flex:1; padding-top:70px; }
    .navbar-custom { background:#fff; border-bottom:1px solid #dee2e6; padding:.5rem 1rem; position:fixed; top:0; width:100%; z-index:1000; margin-bottom: 10px; }
    .navbar-brand { display:flex; align-items:center; gap:.5rem; font-weight:600; color:#495057; text-decoration:none; }
    .navbar-brand .dot { width:10px; height:10px; background:#00c8c8; border-radius:50%; display:inline-block; }
    .navbar-nav .nav-link { margin-left:1rem; color:#6c757d; }
    .navbar-nav .nav-link.active { color:#0d6efd; font-weight:500; }

    .manager-card { background:#fff; border:1px solid #dee2e6; border-radius:.5rem; box-shadow:0 2px 4px rgba(0,0,0,.05); padding:1.5rem; display:flex; flex-direction:row; align-items:center; gap:1.5rem; transition:transform .2s; }
    .manager-card:hover { transform:translateY(-5px); }
    .profile-photo { width:120px; height:120px; border-radius:50%; object-fit:cover; border:2px solid #dee2e6; }
    .manager-info h5 { margin:0; font-size:1.25rem; font-weight:600; color:#495057; }
    .manager-info .role { font-size:.9rem; color:#00c8c8; font-weight:500; }
    .manager-info p { margin:.5rem 0; line-height:1.5; }
    .footer { background:#fff; border-top:1px solid #dee2e6; padding:1rem 0; text-align:center; }
    .main-container { margin-top: 47px; padding-top: 2rem; }
    .profile-photo { width: 120px; height: 120px; aspect-ratio: 1 / 1; object-fit: cover; border-radius: 50%; border: 2px solid #dee2e6; }

    .form-control {
    display: block;
    width: 407px;
    margin-left: 37px;
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: var(--bs-body-color);
    background-color: var(--bs-body-bg);
    background-clip: padding-box;
    border: var(--bs-border-width) solid var(--bs-border-color);
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: var(--bs-border-radius);
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ url('dashboard') }}"><span class="dot"></span>Divisi Operator</a>
      <!-- Search Bar -->
      <form class="d-flex ms-3" role="search">
        <input
          class="form-control me-2"
          type="search"
          placeholder="Cari nama operator..."
          aria-label="Cari"
          id="searchInput"
          value="{{ request('search') }}"
        />
      </form>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navMenu">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="{{ url('dashboard') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('manajemen') }}">Manajer</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('admin') }}">Admin</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('leader') }}">Leader</a></li>
          <li class="nav-item"><a class="nav-link active" href="{{ url('operator') }}">Operator</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container py-5 main-container">
    @endunless 
    <div class="row g-4" id="operator-list">
      @foreach($Operator as $op)
        <div class="col-md-6">
          <div class="manager-card">
            <img src="{{ asset($op->photo_url) }}" alt="{{ $op->name }}" class="profile-photo">
            <div class="manager-info">
              <h5>{{ $op->name }}</h5>
              <div class="role">{{ $op->role }} <span class="badge bg-info text-dark ms-2">{{ $op->level }}</span></div>
              <p>{{ $op->email }} | {{ $op->phone }}</p>
              <p>{{ Str::limit($op->bio, 100) }}</p>
              <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $op->id }}">Detail</button>
            </div>
          </div>
        </div>

        <!-- Detail Modal -->
        <div class="modal fade" id="detailModal{{ $op->id }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">{{ $op->name }} — Detail Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="d-flex align-items-center mb-4">
                  <img src="{{ asset($op->photo_url) }}" class="profile-photo me-3" alt="">
                  <div>
                    <h6>{{ $op->name }}</h6>
                    <small class="role">{{ $op->role }} <span class="badge bg-info text-dark ms-2">{{ $op->level }}</span></small>
                    <p class="mt-2"><i class="bi bi-envelope me-1"></i> {{ $op->email }}</p>
                    <p><i class="bi bi-telephone me-1"></i> {{ $op->phone }}</p>
                  </div>
                </div>
                <h6>Bio</h6>
                <p>{{ $op->bio }}</p>
                <h6>Deskripsi Pekerjaan</h6>
                <ul>@foreach(explode(', ', $op->job_descriptions) as $jd)<li>{{ $jd }}</li>@endforeach</ul>
                <h6>Keahlian</h6>
                <p>@foreach(explode(', ', $op->skills) as $s)<span class="badge bg-secondary me-1">{{ $s }}</span>@endforeach</p>
                <h6>Pencapaian</h6>
                <ul>@foreach(explode(', ', $op->achievements) as $a)<li>{{ $a }}</li>@endforeach</ul>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

   @unless(request()->has('ajax'))

  <footer id="my-footer" class="footer">
    <small>© {{ date('Y') }} PT Naga Hytam Sejahtera Abadi.</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // AJAX search
    document.addEventListener('DOMContentLoaded', () => {
      const input = document.getElementById('searchInput');
      const list  = document.getElementById('operator-list');
      if (!input || !list) return;

      input.addEventListener('input', () => {
        fetch(`{{ url('operator') }}?search=${encodeURIComponent(input.value)}&ajax=1`)
          .then(res => res.text())
          .then(html => list.innerHTML = html)
          .catch(console.error);
      });
    });
  </script>
</body>
</html>
@endunless