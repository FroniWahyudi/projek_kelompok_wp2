<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divisi HR & Leader - Naga Hytam Sejahtera Abadi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
     <!-- Css Custom -->
    <link rel="stylesheet" href="{{ asset('css/leader.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
          <li class="nav-item"><a class="nav-link" href="{{ url('admin') }}">Admin</a></li>
          <li class="nav-item"><a class="nav-link active" href="{{ url('leader') }}">Leader</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('operator') }}">Operator</a></li>
        </ul>
      </div>
    </div>
  </nav>

    <!-- Content -->
    <main class="container py-5">
        <!-- Floating Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success floating-alert alert-dismissible fade show" role="alert">
                <div class="alert-content">
                    <i class="bi bi-check-circle-fill alert-icon"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger floating-alert alert-dismissible fade show" role="alert">
                <div class="alert-content">
                    <i class="bi bi-exclamation-triangle-fill alert-icon"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row gx-4">
            @forelse ($users as $user)
                <div class="col-md-6 d-flex mb-4">
                    <div class="profile-card w-100">
                        <div class="profile-header">
                            <img src="{{ $user->photo_url ? asset($user->photo_url) : asset('images/default-user.png') }}" class="avatar me-3" alt="{{ $user->name }}">
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
                        <p class="mb-2">{{ $user->bio ?? '-' }}</p>
                        <p class="mb-3"><i class="bi bi-envelope me-1"></i> {{ $user->email }}</p>
                        <div class="admin-action-btns d-flex align-items-center">
                            <button class="btn btn-primary btn-sm btn-detail" data-bs-toggle="modal" data-bs-target="#detailModal{{ $user->id }}">
                                Lihat Detail
                            </button>
                            @if(Auth::user() && Auth::user()->role === 'Admin')
                                <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}" title="Edit Profil Leader">Edit</button>
                                <form action="{{ route('leader.destroy', $user->id) }}" method="POST" class="delete-form" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Detail Modal -->
                <div class="modal fade" id="detailModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $user->name }} — Detail Profil</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex align-items-center mb-4">
                                    <img src="{{ $user->photo_url ? asset($user->photo_url) : asset('images/default-user.png') }}" class="avatar me-3" alt="">
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
                                    <div class="col-sm-6"><strong>Alamat:</strong><br>{{ $user->alamat ?? '-' }}</div>
                                    @endif
                                    <div class="col-sm-6"><strong>Joined:</strong><br>{{ $user->joined_at ? \Carbon\Carbon::parse($user->joined_at)->format('d M Y') : '-' }}</div>
                                    @if(auth()->user()->role !== 'Operator')
                                    <div class="col-sm-6"><strong>Pendidikan:</strong><br>{{ $user->education ?? '-' }}</div>
                                    @endif
                                    <div class="col-sm-6"><strong>Departemen:</strong><br>{{ $user->department ?? '-' }}</div>
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
                                    @if($user->job_descriptions)
                                        @foreach(explode(', ', $user->job_descriptions) as $jd)
                                            <li>{{ $jd }}</li>
                                        @endforeach
                                    @else
                                        <li>-</li>
                                    @endif
                                </ul>
                                @if(auth()->user()->role !== 'Operator')
                                <h6><strong>Pencapaian</strong></h6>
                                <ul>
                                    @if($user->achievements)
                                        @foreach(explode(', ', $user->achievements) as $a)
                                            <li>{{ $a }}</li>
                                        @endforeach
                                    @else
                                        <li>-</li>
                                    @endif
                                </ul>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                @if(Auth::user() && Auth::user()->role === 'Admin')
                    <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            @include('index.modal_edit', ['user' => $user])
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">Tidak ada leader ditemukan.</div>
                </div>
            @endforelse
        </div>

        <!-- Floating Action Button - Admin Only -->
        @if(Auth::user() && Auth::user()->role === 'Admin')
            <button type="button" class="fab" data-bs-toggle="modal" data-bs-target="#createLeaderModal" title="Tambah Leader">
                <i class="bi bi-plus-lg"></i>
            </button>
            <!-- Create Leader Modal -->
            <div class="modal fade" id="createLeaderModal" tabindex="-1" aria-labelledby="createLeaderModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    @include('index.modal_create_operator', ['role' => 'Leader'])
                </div>
            </div>
        @endif
    </main>

    <footer id="my-footer">
        <div class="container text-center">
            <small>© {{ date('Y') }} PT Naga Hytam Sejahtera Abadi. All Rights Reserved.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Delete confirmation
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Leader ini akan dihapus permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Enhanced floating alert auto-hide with smooth animation
            const floatingAlerts = document.querySelectorAll('.floating-alert');
            
            floatingAlerts.forEach(alert => {
                // Auto-hide after 3 seconds with smooth animation
                const autoHideTimer = setTimeout(() => {
                    hideAlert(alert);
                }, 3000);

                // Clear timer if user manually closes the alert
                const closeBtn = alert.querySelector('.btn-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        clearTimeout(autoHideTimer);
                        hideAlert(alert);
                    });
                }

                // Pause auto-hide on hover
                alert.addEventListener('mouseenter', () => {
                    clearTimeout(autoHideTimer);
                    // Remove progress bar animation
                    alert.style.setProperty('--pause-animation', 'paused');
                });

                // Resume auto-hide when mouse leaves (with remaining time)
                alert.addEventListener('mouseleave', () => {
                    setTimeout(() => {
                        hideAlert(alert);
                    }, 1000);
                });
            });

            function hideAlert(alert) {
                alert.classList.add('hiding');
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 300);
            }

            // Function to create dynamic floating notifications (for use with AJAX calls)
            window.showFloatingAlert = function(message, type = 'success') {
                const alertContainer = document.createElement('div');
                const iconClass = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
                
                alertContainer.className = `alert alert-${type} floating-alert alert-dismissible fade show`;
                alertContainer.setAttribute('role', 'alert');
                
                alertContainer.innerHTML = `
                    <div class="alert-content">
                        <i class="${iconClass} alert-icon"></i>
                        <span>${message}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                document.body.appendChild(alertContainer);
                
                // Auto-hide
                const autoHideTimer = setTimeout(() => {
                    hideAlert(alertContainer);
                }, 3000);

                // Manual close
                const closeBtn = alertContainer.querySelector('.btn-close');
                closeBtn.addEventListener('click', () => {
                    clearTimeout(autoHideTimer);
                    hideAlert(alertContainer);
                });

                // Hover effects
                alertContainer.addEventListener('mouseenter', () => {
                    clearTimeout(autoHideTimer);
                });

                alertContainer.addEventListener('mouseleave', () => {
                    setTimeout(() => {
                        hideAlert(alertContainer);
                    }, 1000);
                });
            };
        });
    </script>
</body>
</html>