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
        <li class="nav-item"><a class="nav-link" href="{{ url('manajemen') }}">Manajemen</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Karyawan</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h3>Data Karyawan</h3>
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari nama karyawan..." onkeyup="filterTable()">
        </div>
    </div>

    <form method="POST" action="{{ url('/karyawan/update_sisa_cuti') }}">
        @csrf
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="karyawanTable">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Bio</th>
                        <th>Tanggal Dibuat</th>
                        @if($role == 'HR')
                            <th>Sisa Cuti ({{ $tahun }})</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="karyawanBody">
                    @foreach($karyawan as $index => $k)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><img src="{{ $k->photo_url }}" width="40" height="40" class="rounded-circle"></td>
                        <td>{{ $k->name }}</td>
                        <td>{{ $k->email }}</td>
                        <td>{{ $k->phone }}</td>
                        <td>{{ $k->bio }}</td>
                        <td>{{ $k->created_at }}</td>
                        @if($role == 'HR')
                            <td>
                                <input type="number" name="sisa_cuti[{{ $k->id }}]" 
                                       value="{{ $k->total_cuti ?? 12 }}" 
                                       class="form-control form-control-sm" min="0">
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($role == 'HR')
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-1"></i> Simpan Sisa Cuti
            </button>
        @endif
    </form>
</div>

@push('scripts')
<script>
function filterTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    document.querySelectorAll("#karyawanBody tr").forEach(row => {
        const nama = row.cells[2].innerText.toLowerCase();
        row.style.display = nama.includes(input) ? "" : "none";
    });
}
</script>
@endpush
