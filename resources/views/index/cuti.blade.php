<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan Cuti</title>
    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/cuti.css') }}">
</head>
<body>
    <div class="container py-4">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb align-items-center" style="font-size: 1.25rem;">
                <li class="breadcrumb-item d-flex align-items-center">
                    <a href="{{ url('dashboard') }}" class="home-button">
                        <i class="fas fa-home mr-2"></i> Home
                    </a>
                </li>
            </ol>
        </nav>

        <!-- Judul dan Tombol Ajukan Cuti -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 fw-bold">Pengajuan Cuti</h2>
            <div>
                @if(!in_array(auth()->user()->role, ['Manajer']))
                    <button class="btn btn-primary nav-button" data-bs-toggle="modal" data-bs-target="#cutiModal">
                        <i class="bi bi-plus-circle me-1"></i> Ajukan Cuti
                    </button>
                @endif
            </div>
        </div>

        <!-- Kartu Sisa Cuti Pengguna -->
        @if(!in_array(auth()->user()->role, ['Manajer']))
            <div class="card sisa-cuti-card mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-2 text-secondary">Sisa Cuti Anda</h5>
                        <p class="sisa-cuti-value mb-0">
                            {{ auth()->user()->sisaCuti->cuti_sisa ?? 0 }} hari
                        </p>
                    </div>
                    <i class="bi bi-calendar-check sisa-cuti-icon"></i>
                </div>
            </div>
        @endif

        <!-- Modal Success -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-white">
                        <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2"></i>Berhasil</h5>
                 
                    </div>
                    <div class="modal-body text-center">
                        {{ session('success') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Error -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Terjadi Kesalahan</h5>
                   
                    </div>
                    <div class="modal-body">
                        {{ session('error') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script untuk Menampilkan Modal Sukses/Error -->
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    new bootstrap.Modal(document.getElementById('successModal')).show();
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    new bootstrap.Modal(document.getElementById('errorModal')).show();
                });
            </script>
        @endif

        <!-- Modal Konfirmasi Hapus -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="confirmDeleteLabel"><i class="bi bi-trash-fill me-2"></i>Konfirmasi Hapus</h5>
                      
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus pengajuan ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="btnConfirmDelete" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Status untuk Manajer -->
        @if(in_array(auth()->user()->role, ['Manajer']))
            @php
                $currentFilter = request('status');
            @endphp
            <div class="mb-4 status-filter">
                <a href="{{ route('cuti.index') }}"
                   class="btn {{ is_null($currentFilter) ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-list-check me-1"></i> Semua
                </a>
                <a href="{{ route('cuti.index', ['status' => 'Menunggu']) }}"
                   class="btn {{ $currentFilter === 'Menunggu' ? 'btn-warning' : 'btn-outline-warning' }}">
                    <i class="bi bi-clock me-1"></i> Menunggu
                </a>
                <a href="{{ route('cuti.index', ['status' => 'Disetujui']) }}"
                   class="btn {{ $currentFilter === 'Disetujui' ? 'btn-success' : 'btn-outline-success' }}">
                    <i class="bi bi-check-circle me-1"></i> Disetujui
                </a>
                <a href="{{ route('cuti.index', ['status' => 'Ditolak']) }}"
                   class="btn {{ $currentFilter === 'Ditolak' ? 'btn-danger' : 'btn-outline-danger' }}">
                    <i class="bi bi-x-circle me-1"></i> Ditolak
                </a>
                <form action="{{ route('cuti.reset') }}"
                      method="POST"
                      class="confirmable d-inline"
                      data-message="Anda yakin ingin mereset seluruh cuti tahunan?">
                    @csrf
                    <button type="submit" class="btn btn-info float-end">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Cuti Tahunan
                    </button>
                </form>
            </div>
        @endif

        <!-- Tabel Pengajuan Cuti -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tgl Pengajuan</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Durasi Cuti</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                @if(
                                    (in_array(auth()->user()->role, ['Manajer'])) ||
                                    (!in_array(auth()->user()->role, ['Manajer']) && $cutiRequests->where('status', 'Menunggu')->count() > 0)
                                )
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cutiRequests as $i => $r)
                                @php
                                    $badge = match($r->status) {
                                        'Disetujui' => 'success',
                                        'Ditolak' => 'danger',
                                        default => 'warning'
                                    };
                                @endphp
                                <tr>
                                    <td>{{ $r->user->name }}</td>
                                    <td>{{ $r->tanggal_pengajuan->format('Y-m-d') }}</td>
                                    <td>{{ $r->tanggal_mulai->format('Y-m-d') }}</td>
                                    <td>{{ $r->tanggal_selesai->format('Y-m-d') }}</td>
                                    <td>{{ $r->lama_cuti }} hari</td>
                                    <td>{{ $r->alasan }}</td>
                                    <td>
                                        <span class="badge badge-{{ $badge }} badge-status">
                                            {{ $r->status }}
                                        </span>
                                    </td>
                                    @if(!in_array(auth()->user()->role, ['Manajer']) && $r->status === 'Menunggu' && $r->status !== 'Ditolak')
                                        <td class="action-buttons">
                                            <form action="{{ route('cuti.batal', $r->id) }}"
                                                  method="POST"
                                                  class="confirmable d-inline"
                                                  data-message="Batalkan pengajuan cuti ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="bi bi-x-circle"></i> Batal
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                    @if(in_array(auth()->user()->role, ['Manajer']) && $r->status === 'Menunggu')
                                        <td class="action-buttons">
                                            <form action="{{ route('cuti.accept', $r->id) }}"
                                                  method="POST"
                                                  class="confirmable d-inline"
                                                  data-message="Setujui pengajuan cuti ini?">
                                                @csrf
                                                <button class="btn btn-sm btn-success">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('cuti.reject', $r->id) }}"
                                                  method="POST"
                                                  class="confirmable d-inline"
                                                  data-message="Tolak pengajuan cuti ini?">
                                                @csrf
                                                <button class="btn btn-sm btn-warning">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                    @if(in_array(auth()->user()->role, ['Manajer']) && ($r->status === 'Disetujui' || $r->status === 'Ditolak'))
                                        <td class="action-buttons">
                                            <form action="{{ route('cuti.destroy', $r->id) }}"
                                                  method="POST"
                                                  class="confirmable d-inline"
                                                  data-message="Hapus pengajuan cuti ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ in_array(auth()->user()->role, ['Manajer']) ? 9 : 8 }}" class="empty-state">
                                        <i class="bi bi-inbox empty-state-icon"></i>
                                        <h5>Belum ada pengajuan cuti</h5>
                                        <p class="text-muted">Mulai dengan mengajukan cuti baru</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Pengajuan Cuti -->
        <div class="modal fade" id="cutiModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="{{ route('cuti.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-calendar-plus me-2"></i>Form Pengajuan Cuti</h5>
                   
                        </div>
                        <div class="modal-body-pengajuan" style="position: relative; left: 10px; top: 10px; width: 400px;">
                            <div class="mb-3">
                                <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" id="tgl_mulai" name="tgl_mulai"
                                       class="form-control @error('tgl_mulai') is-invalid @enderror"
                                       value="{{ old('tgl_mulai') }}" required>
                                @error('tgl_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" id="tgl_selesai" name="tgl_selesai"
                                       class="form-control @error('tgl_selesai') is-invalid @enderror"
                                       value="{{ old('tgl_selesai') }}" required>
                                @error('tgl_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="alasan" class="form-label">Keterangan</label>
                                <textarea id="alasan" name="alasan"
                                          class="form-control @error('alasan') is-invalid @enderror"
                                          rows="3" required>{{ old('alasan') }}</textarea>
                                @error('alasan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi Global -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-primary">
                    <div class="modal-header bg-primary text-white text-center">
                        <h5 class="modal-title" id="confirmModalLabel"><i class="bi bi-question-circle-fill me-2"></i>Konfirmasi</h5>
                       
                    </div>
                    <div class="modal-body text-center">
                        <p id="confirmModalMessage">Pesan konfirmasi di sini</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="confirmModalYes" class="btn btn-primary">Ya</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript untuk Konfirmasi dan Responsivitas -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            const messageElem = document.getElementById('confirmModalMessage');
            const yesBtn = document.getElementById('confirmModalYes');
            let formToSubmit = null;

            // Handler untuk tombol hapus
            document.querySelectorAll('form.form-hapus button[type="submit"]').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    formToSubmit = this.closest('form');
                    deleteModal.show();
                });
            });

            document.getElementById('btnConfirmDelete').addEventListener('click', function() {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
            });

            // Handler untuk form confirmable
            document.querySelectorAll('form.confirmable button').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    formToSubmit = this.closest('form');
                    messageElem.textContent = formToSubmit.dataset.message || 'Yakin?';
                    confirmModal.show();
                });
            });

            yesBtn.addEventListener('click', function() {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
            });

            // Responsive table labels
            if (window.innerWidth <= 768) {
                const headers = document.querySelectorAll('thead th');
                const headerTexts = Array.from(headers).map(th => th.textContent.trim());
                document.querySelectorAll('tbody td').forEach((td, index) => {
                    const colIndex = index % headerTexts.length;
                    td.setAttribute('data-label', headerTexts[colIndex]);
                });
            }
        });
    </script>
    
    <!-- Auto show modal if there are errors -->
    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var cutiModal = new bootstrap.Modal(document.getElementById('cutiModal'));
                cutiModal.show();
            });
        </script>
    @endif
</body>
</html>
