<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Kerja - Naga Hytam</title>
  @vite([
      'resources/js/app.js',
      'resources/sass/app.scss',
      'resources/css/app.css'
      ])
  <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<div class="container py-4">
    <a href="{{ url('dashboard') }}" class="btn btn-outline-dark mb-3">
        <i class="bi bi-house-door"></i> Home
    </a>

    <h3 class="mb-4">Laporan Kerja</h3>
    <a href="{{ url('laporan.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus"></i> Tambah Laporan
    </a>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Divisi</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporanKerja as $index => $laporan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $laporan->tanggal }}</td>
                    <td>{{ $laporan->nama }}</td>
                    <td>{{ $laporan->divisi }}</td>
                    <td>{{ $laporan->deskripsi }}</td>
                    <td>
                        <a href="{{ url('laporan.show', $laporan->id) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>

                        @if ($role === 'Leader')
                            <a href="{{ url('laporan.edit', $laporan->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ url('laporan.destroy', $laporan->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin ingin menghapus laporan ini?')" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Tidak ada data laporan kerja.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>