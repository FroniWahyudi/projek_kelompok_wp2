<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Divisi HR & Leader - Naga Hytam Sejahtera Abadi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
     <!-- Css Custom -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid px-lg-5">
      <a class="navbar-brand" href="#">
        <span class="dot"></span>
        <span>Divisi Manajemen</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#mainNav" aria-controls="mainNav"
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="mainNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="{{ url('dashboard') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('manajemen') }}">Manajer</a></li>
          <li class="nav-item"><a class="nav-link active" href="{{ url('admin') }}">Admin</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('leader') }}">Leader</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('operator') }}">Operator</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <main class="container">
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
                  <span class="badge
                      @if(strtolower($user->level) === 'junior') bg-success 
                      @elseif(strtolower($user->level) === 'intermediate') bg-primary 
                      @elseif(strtolower($user->level) === 'senior') bg-warning text-dark 
                      @else bg-info text-dark 
                      @endif ms-2">
                      {{ $user->level }}
                  </span>
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
                    <span class="badge
                        @if(strtolower($user->level) === 'junior') bg-success 
                        @elseif(strtolower($user->level) === 'intermediate') bg-primary 
                        @elseif(strtolower($user->level) === 'senior') bg-warning text-dark 
                        @else bg-info text-dark 
                        @endif ms-2">
                        {{ $user->level }}
                    </span><br>
                    <small class="text-muted"><i class="bi bi-envelope me-1"></i> {{ $user->email }}</small>
                    <small class="text-muted ms-3"><i class="bi bi-telephone me-1"></i> {{ $user->phone }}</small>
                  </div>
                </div>

                <h6><strong>Informasi Pribadi</strong></h6>
                <div class="row g-3 mb-4">
                  @if(auth()->user()->role !== 'Operator')
                  <div class="col-sm-6"><strong>Alamat:</strong><br>{{ $user->alamat }}</div>
                  @endif
                  <div class="col-sm-6"><strong>Joined:</strong><br>{{ \Carbon\Carbon::parse($user->joined_at)->format('d M Y') }}</div>
                  @if(auth()->user()->role !== 'Operator')
                  <div class="col-sm-6"><strong>Pendidikan:</strong><br>{{ $user->education }}</div>
                  @endif
                  <div class="col-sm-6"><strong>Departemen:</strong><br>{{ $user->department }}</div>
                  <div class="col-sm-6">
                      <p class="mb-1"><strong>Keahlian:</strong></p>
                      <p class="mb-0">
                          @if($user->skills)
                              @foreach(explode(', ', $user->skills) as $s)
                                  <span class="badge bg-secondary me-1 mb-1">{{ $s }}</span>
                              @endforeach
                          @else
                              -
                          @endif
                      </p>
                  </div>
                </div>

                <h6><strong>Deskripsi Pekerjaan</strong></h6>
                <ul>
                  @foreach(explode(', ', $user->job_descriptions) as $jd)
                    <li>{{ $jd }}</li>
                  @endforeach
                </ul>
                @if(auth()->user()->role !== 'Operator')
                <h6><strong>Pencapaian</strong></h6>
                <ul>
                  @foreach(explode(', ', $user->achievements) as $a)
                    <li>{{ $a }}</li>
                  @endforeach
                </ul>
                @endif
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
