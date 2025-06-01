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
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        html, body { height: 100%; margin: 0; }
        body { display: flex; flex-direction: column; font-family: 'Poppins', sans-serif; font-size:.9rem; color:#6c757d; background:#f8f9fa; }
        main { flex: 1; padding-top: 70px; }
        .navbar-custom {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: .5rem 1rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
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
        .fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #00c8c8);
            border: none;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
            transition: all 0.3s ease;
            z-index: 1050;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .fab:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
            background: linear-gradient(135deg, #0b5ed7, #00a8a8);
        }
        .fab:active { transform: scale(0.95); }
        footer#my-footer {
            background: #fff;
            border-top: 1px solid #dee2e6;
            padding: 1rem 0;
            text-align: center;
            font-size: .8rem;
            color: #868e96;
            margin-top: auto;
        }
        .form-control { width: 100%; }
        .admin-action-btns { gap: 10px; }
        .admin-action-btns .btn-edit, .admin-action-btns .btn-danger {
            min-width: 70px;
            font-size: 0.85rem;
            padding: 0.25rem 0.5rem;
        }
        
        .gx-4 {
    margin-top: 30px;
}

.form-control {
    width: 57%;
}
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                                    <span class="badge-level">{{ $user->level }}</span>
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
                                <form action="{{ route('leader.destroy', $user->id) }}" method="POST" class="delete-form" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Leader {{ $user->name }}?')">
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
                                        <span class="badge bg-info text-dark ms-2">{{ $user->level }}</span><br>
                                        <small class="text-muted"><i class="bi bi-envelope me-1"></i> {{ $user->email }}</small>
                                        <small class="text-muted ms-3"><i class="bi bi-telephone me-1"></i> {{ $user->phone }}</small>
                                    </div>
                                </div>
                                <h6><strong>Informasi Pribadi</strong></h6>
                                <div class="row mb-3">
                                    <div class="col-sm-6"><strong>Alamat:</strong><br>{{ $user->alamat ?? '-' }}</div>
                                    <div class="col-sm-6"><strong>Joined:</strong><br>{{ $user->joined_at ? \Carbon\Carbon::parse($user->joined_at)->format('d M Y') : '-' }}</div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-6"><strong>Pendidikan:</strong><br>{{ $user->education ?? '-' }}</div>
                                    <div class="col-sm-6"><strong>Departemen:</strong><br>{{ $user->department ?? '-' }}</div>
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
                                <h6><strong>Keahlian</strong></h6>
                                <div class="mb-3">
                                    @if($user->skills)
                                        @foreach(explode(', ', $user->skills) as $s)
                                            <span class="badge bg-secondary me-1">{{ $s }}</span>
                                        @endforeach
                                    @else
                                        <span>-</span>
                                    @endif
                                </div>
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
                    @include('index.modal_create_operator')
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
        });
    </script>
</body>
</html>