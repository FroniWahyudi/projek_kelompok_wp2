<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan Cuti</title>
    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .nav-button {
            margin-bottom: 1rem;
        }
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .badge-status {
            min-width: 60px;
        }
        .table {
            white-space: normal;
            text-align: center;
            vertical-align: middle;
        }
        .table th.alasan,
        .table td.alasan {
            width: 25%;
            white-space: normal;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-dark nav-button">
            <i class="bi bi-house-door me-1"></i> Home
        </a>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Pengajuan Cuti</h2>
            <div>
                
                @if(in_array(auth()->user()->role, ['Operator']))
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cutiModal">
                        <i class="bi bi-plus-circle me-1"></i> Ajukan Cuti
                    </button>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(in_array(auth()->user()->role, ['Admin','Manajer']))
            @php
                $currentFilter = request('status');
            @endphp
            <div class="mb-3">
                <a href="{{ route('cuti.index') }}"
                   class="btn {{ is_null($currentFilter) ? 'btn-primary' : 'btn-outline-primary' }} me-2">
                    Semua
                </a>
                <a href="{{ route('cuti.index', ['status' => 'Menunggu']) }}"
                   class="btn {{ $currentFilter === 'Menunggu' ? 'btn-warning' : 'btn-outline-warning' }} me-2">
                    Menunggu
                </a>
                <a href="{{ route('cuti.index', ['status' => 'Disetujui']) }}"
                   class="btn {{ $currentFilter === 'Disetujui' ? 'btn-success' : 'btn-outline-success' }}">
                    Disetujui
                </a>


             <form action="{{ route('cuti.reset') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" 
            class="btn btn-info float-end"
            onclick="return confirm('Anda yakin ingin melakukan Reset Cuti Tahunan?')">
        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Cuti Tahunan
    </button>
</form>




            </div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                @if(in_array(auth()->user()->role, ['Admin','Manajer','Operator']))
                                    <th>Nama</th>
                                    <th>Sisa Cuti</th>
                                @endif
                                <th>Tgl Pengajuan</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Durasi Cuti</th>
                                <th class="alasan">Alasan</th>
                                <th>Status</th>
                                <th>Aksi</th>
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
                                    <td>{{ $i + 1 }}</td>
                                    @if(in_array(auth()->user()->role, ['Admin','Manajer','Operator']))
                                        <td>{{ $r->user->name }}</td>
                                        <td>{{ $r->user->sisaCuti->cuti_sisa ?? 0 }}</td>
                                    @endif
                                    <td>{{ $r->tanggal_pengajuan->format('Y-m-d') }}</td>
                                    <td>{{ $r->tanggal_mulai->format('Y-m-d') }}</td>
                                    <td>{{ $r->tanggal_selesai->format('Y-m-d') }}</td>
                                    <td>{{ $r->lama_cuti }}</td>
                                    <td class="alasan">{{ $r->alasan }}</td>
                                    <td>
                                        <span class="badge bg-{{ $badge }} text-dark badge-status">
                                            {{ $r->status }}
                                        </span>
                                    </td>
                                  <td class="d-flex gap-1">
    @if(in_array(auth()->user()->role, ['Admin','Manajer']) && $r->status === 'Menunggu')
        <form action="{{ route('cuti.accept', $r->id) }}" method="POST" onsubmit="return confirm('Setujui pengajuan ini?')">
            @csrf
            <button class="btn btn-sm btn-outline-success"><i class="bi bi-check-circle"></i></button>
        </form>

        <form action="{{ route('cuti.reject', $r->id) }}" method="POST" onsubmit="return confirm('Tolak pengajuan ini?')">
            @csrf
            <button class="btn btn-sm btn-outline-warning"><i class="bi bi-x-circle"></i></button>
        </form>
    @endif

    <form action="{{ route('cuti.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus pengajuan ini?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
    </form>
</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ in_array(auth()->user()->role, ['Admin','Manajer']) ? 9 : 8 }}"
                                        class="text-center py-4">
                                        Belum ada pengajuan cuti.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="cutiModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="{{ route('cuti.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Form Pengajuan Cuti</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" id="tgl_mulai" name="tgl_mulai"
                                       class="form-control @error('tgl_mulai') is-invalid @enderror"
                                       value="{{ old('tgl_mulai') }}" required>
                                @error('tgl_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" id="tgl_selesai" name="tgl_selesai"
                                       class="form-control @error('tgl_selesai') is-invalid @enderror"
                                       value="{{ old('tgl_selesai') }}" required>
                                @error('tgl_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="alasan" class="form-label">Alasan</label>
                                <textarea id="alasan" name="alasan"
                                          class="form-control @error('alasan') is-invalid @enderror"
                                          rows="3" required>{{ old('alasan') }}</textarea>
                                @error('alasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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