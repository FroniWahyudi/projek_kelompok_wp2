@php
use Illuminate\Support\Facades\Auth;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manajemen Dashboard - Naga Hytam Sejahtera Abadi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Css Custom -->
    <link rel="stylesheet" href="{{ asset('css/modal_edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal_create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/operator.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @media (max-width: 576px) {
          .modal-dialog {
            max-width: 100vw !important;
            width: 100vw !important;
            height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
            display: flex;
            align-items: stretch;
          }
          .modal-content {
            border-radius: 0 !important;
            height: 100vh !important;
            min-height: 100vh !important;
            width: 100vw !important;
            display: flex;
            flex-direction: column;
          }
          .modal-header, .modal-footer {
            flex-shrink: 0;
          }
          .modal-body {
            flex: 1 1 auto;
            overflow-y: auto !important;
            max-height: none !important;
            padding: 1rem;
          }
        }
    </style>
</head>
<body>
@unless(request()->has('ajax'))
    <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid px-lg-5">
      <a class="navbar-brand" href="{{ route('dashboard') }}">
        <span class="dot"></span>
        <span>Divisi Manajemen</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#mainNav" aria-controls="mainNav"
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="mainNav">
        <div class="d-flex ms-3 w-100 d-none d-lg-block" style="max-width:400px;">
            <input
                class="form-control me-2"
                type="search"
                placeholder="Cari nama operator..."
                aria-label="Cari"
                id="searchInputDesktop"
                value="{{ request('search') }}"
            />
        </div>
        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
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
        <!-- Mobile search bar above filter buttons -->
        <div class="d-block d-lg-none search-bar-mobile">
            <input
                class="form-control"
                type="search"
                placeholder="Cari nama operator..."
                aria-label="Cari"
                id="searchInputMobile"
                value="{{ request('search') }}"
            />
        </div>
        <div class="mb-3 filter-btn-group">
            <button id="btnAll" class="btn btn-outline-secondary">Semua</button>
            <button id="btnFilterInbound" class="btn btn-outline-primary">Inbound</button>
            <button id="btnFilterOutbound" class="btn btn-outline-success">Outbound</button>
            <button id="btnFilterStorage" class="btn btn-outline-warning">Storage</button>
        </div>
        @if (session('success'))
            <div class="success-message" id="successMessage">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" id="errorMessage">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <script>
                setTimeout(function() {
                    var err = document.getElementById('errorMessage');
                    if (err) err.style.display = 'none';
                }, 2000);
            </script>
        @endif
@endunless

<div class="row g-4" id="operator-list">
    @forelse($users as $op)
        <div class="col-md-6">
            <div class="manager-card" data-divisi="{{ strtolower($op->divisi) }}">
                <img src="{{ $op->photo_url ? asset($op->photo_url) : asset('images/default-user.png') }}" alt="{{ $op->name }}" class="profile-photo">
                <div class="manager-info">
                    <h5>{{ $op->name }}</h5>
                    <div class="role">
                        {{ $op->role }}
                        <span class="badge
                            @if(strtolower($op->level) === 'junior') bg-success 
                            @elseif(strtolower($op->level) === 'intermediate') bg-primary 
                            @elseif(strtolower($op->level) === 'senior') bg-warning text-dark 
                            @else bg-info text-dark 
                            @endif ms-2">
                            {{ $op->level }}
                        </span>
                    </div>
                    <p>{{ $op->email }}</p>
                    <p>{{ $op->divisi }}</p>
                    <p>{{ Str::limit($op->bio, 100) }}</p>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $op->id }}">Detail</button>
                    @if(Auth::user() && Auth::user()->role === 'Admin')
                        <a href="{{ route('operator.edit', $op->id) }}" class="btn btn-warning btn-sm btn-edit ms-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $op->id }}" title="Edit Profil Operator">Edit</a>
                        <form action="{{ route('operator.destroy', $op->id) }}" method="POST" class="delete-form" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-btn">Hapus</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <!-- Modal Detail -->
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
                    <h6 class="mb-0">{{ $op->name }}</h6>
                    <small class="text-primary">{{ $op->role }}</small>
                    <span class="badge
                        @if(strtolower($op->level) === 'junior') bg-success 
                        @elseif(strtolower($op->level) === 'intermediate') bg-primary 
                        @elseif(strtolower($op->level) === 'senior') bg-warning text-dark 
                        @else bg-info text-dark 
                        @endif ms-2">
                        {{ $op->level }}
                    </span><br>
                    <small class="text-muted"><i class="bi bi-envelope me-1"></i> {{ $op->email }}</small>
                    <small class="text-muted ms-3"><i class="bi bi-telephone me-1"></i> {{ $op->phone }}</small>
                  </div>
                </div>

                <h6><strong>Informasi Pribadi</strong></h6>
                <div class="row g-3 mb-4">
                  @if(auth()->user()->role !== 'Operator')
                  <div class="col-sm-6"><strong>Alamat:</strong><br>{{ $op->alamat }}</div>
                  @endif
                  <div class="col-sm-6"><strong>Joined:</strong><br>{{ \Carbon\Carbon::parse($op->joined_at)->format('d M Y') }}</div>
                  @if(auth()->user()->role !== 'Operator')
                  <div class="col-sm-6"><strong>Pendidikan:</strong><br>{{ $op->education }}</div>
                  @endif
                  <div class="col-sm-6"><strong>Departemen:</strong><br>{{ $op->department }}</div>
                  <div class="col-sm-6">
                      <p class="mb-1"><strong>Keahlian:</strong></p>
                      <p class="mb-0">
                          @if($op->skills)
                              @foreach(explode(', ', $op->skills) as $s)
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
                  @foreach(explode(', ', $op->job_descriptions) as $jd)
                    <li>{{ $jd }}</li>
                  @endforeach
                </ul>
                @if(auth()->user()->role !== 'Operator')
                <h6><strong>Pencapaian</strong></h6>
                <ul>
                  @foreach(explode(', ', $op->achievements) as $a)
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
        <!-- Modal Edit -->
        @if(Auth::user() && Auth::user()->role === 'Admin')
            <div class="modal fade" id="editModal{{ $op->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    @include('index.modal_edit', ['user' => $op])
                </div>
            </div>
        @endif
    @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">Tidak ada operator ditemukan.</div>
        </div>
    @endforelse
</div>

@if(Auth::user() && Auth::user()->role === 'Admin')
    <button type="button" class="fab" data-bs-toggle="modal" data-bs-target="#createOperatorModal" title="Tambah Operator">
        <i class="bi bi-plus-lg"></i>
    </button>
    <div class="modal fade" id="createOperatorModal" tabindex="-1" aria-labelledby="createOperatorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            @include('index.modal_create_operator')
        </div>
    </div>
@endif

@unless(request()->has('ajax'))
    </main>
    <footer class="footer">
        <small>© {{ date('Y') }} PT Naga Hytam Sejahtera Abadi.</small>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Function untuk menginisialisasi event listener delete
        function initializeDeleteConfirmation() {
            // Menggunakan event delegation untuk handle delete buttons
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('delete-btn')) {
                    e.preventDefault();
                    
                    const form = e.target.closest('.delete-form');
                    if (form) {
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: 'Operator ini akan dihapus permanen!',
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
                    }
                }
            });
        }

        // Function untuk menginisialisasi semua event listeners
        function initializeEventListeners() {
            const inputDesktop = document.getElementById('searchInputDesktop');
            const inputMobile = document.getElementById('searchInputMobile');
            const list = document.getElementById('operator-list');
            if (!inputDesktop && !inputMobile || !list) return;

            let timeoutDesktop = null;
            let timeoutMobile = null;

            const buttons = {
                all: document.getElementById('btnAll'),
                inbound: document.getElementById('btnFilterInbound'),
                outbound: document.getElementById('btnFilterOutbound'),
                storage: document.getElementById('btnFilterStorage')
            };

            function setActiveButton(activeBtn) {
                Object.values(buttons).forEach(btn => {
                    if (btn) btn.classList.remove('active');
                });
                if (activeBtn) activeBtn.classList.add('active');
            }

            function filterBy(divisi) {
                const cards = document.querySelectorAll('#operator-list .manager-card');
                cards.forEach(card => {
                    const d = card.dataset.divisi || '';
                    card.parentElement.style.display = (divisi === 'all' || d.includes(divisi)) ? '' : 'none';
                });
            }

            // Search functionality for both desktop and mobile
            function searchHandler(inputElement, timeoutVar) {
                clearTimeout(timeoutVar.value);
                timeoutVar.value = setTimeout(() => {
                    fetch(`{{ url('operator') }}?search=${encodeURIComponent(inputElement.value)}&ajax=1`)
                        .then(res => res.text())
                        .then(html => {
                            list.innerHTML = html;
                            setActiveButton(null);
                            // Re-initialize Bootstrap modals setelah konten diupdate
                            initializeBootstrapModals();
                        })
                        .catch(err => console.error('Search error:', err));
                }, 300);
            }

            if (inputDesktop) {
                const timeoutVar = { value: null };
                inputDesktop.addEventListener('input', () => searchHandler(inputDesktop, timeoutVar));
            }
            if (inputMobile) {
                const timeoutVar = { value: null };
                inputMobile.addEventListener('input', () => searchHandler(inputMobile, timeoutVar));
            }

            // Filter buttons
            if (buttons.all) {
                buttons.all.addEventListener('click', () => {
                    setActiveButton(buttons.all);
                    filterBy('all');
                });
            }
            if (buttons.inbound) {
                buttons.inbound.addEventListener('click', () => {
                    setActiveButton(buttons.inbound);
                    filterBy('inbound');
                });
            }
            if (buttons.outbound) {
                buttons.outbound.addEventListener('click', () => {
                    setActiveButton(buttons.outbound);
                    filterBy('outbound');
                });
            }
            if (buttons.storage) {
                buttons.storage.addEventListener('click', () => {
                    setActiveButton(buttons.storage);
                    filterBy('storage');
                });
            }

            // Set default active button
            setActiveButton(buttons.all);

            // Success message animation
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'block';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3000);
            }
        }

        // Function untuk menginisialisasi Bootstrap modals
        function initializeBootstrapModals() {
            // Re-initialize semua modal Bootstrap
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modalEl => {
                // Dispose existing modal instance jika ada
                const existingModal = bootstrap.Modal.getInstance(modalEl);
                if (existingModal) {
                    existingModal.dispose();
                }
                // Create new modal instance
                new bootstrap.Modal(modalEl);
            });
        }

        // Initialize semua functionality saat DOM ready
        document.addEventListener('DOMContentLoaded', () => {
            initializeEventListeners();
            initializeDeleteConfirmation();
            initializeBootstrapModals();
        });
    </script>
</body>
</html>
@endunless