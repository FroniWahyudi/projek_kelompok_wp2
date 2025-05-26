<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Pengelolaan Slip Gaji' }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }
        .main-content {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            min-height: 90vh;
        }
        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #212529;
            margin-bottom: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 15px;
            font-weight: 600;
        }
        .table th {
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
        }
        .btn-action {
            padding: 5px 10px;
            margin-right: 5px;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-published {
            background: #d1e7dd;
            color: #0f5132;
        }
        .mt-auto {
            margin-top: 0.5rem !important;
        }
        .btn-primary {
            background-color: #3a86ff;
            border-color: #3a86ff;
        }
        .btn-primary:hover {
            background-color: #2a6ecc;
            border-color: #2a6ecc;
        }
        td {
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="main-content">
                    <!-- Payslips List View -->
                    <div id="payslips-view">
                        <div class="mb-3">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="bi bi-house-door-fill"></i> Home
                            </a>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h1 class="page-title mb-0">{{ $title ?? 'Pengelolaan Slip Gaji' }}</h1>
                        </div>
                        <form method="GET" action="{{ route('slips.index') }}" class="row mb-3">
                            <div class="col-md-3">
                                <label for="filter-month" class="form-label">Pilih Bulan</label>
                                <select name="month" id="filter-month" class="form-select">
                                    <option value="" {{ request('month') == '' ? 'selected' : '' }}>Semua Bulan</option>
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ sprintf('%02d', $m) }}" {{ request('month') == sprintf('%02d', $m) ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filter-year" class="form-label">Pilih Tahun</label>
                                <select name="year" id="filter-year" class="form-select">
                                    <option value="" {{ request('year') == '' ? 'selected' : '' }}>Semua Tahun</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mt-auto text-end">
                                @if(auth()->user()->role != 'Operator')
                                    <a href="{{ route('slip_create') }}" class="btn btn-primary mt-4">
                                        <i class="bi bi-plus-lg"></i> Buat Slip Gaji Baru
                                    </a>
                                @endif
                            </div>
                        </form>
                        <div class="card">
                            <div class="card-header">Daftar Slip Gaji</div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="col-1 text-center">ID Slip</th>
                                            <th class="col-3">Nama Karyawan</th>
                                            <th class="col-2">Periode</th>
                                            <th class="col-2">Gaji Bersih</th>
                                            <th class="col-1">Status</th>
                                            <th class="col-3 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($slips as $slip)
                                            <tr>
                                                <td class="text-center">{{ $slip->id }}</td>
                                                <td>{{ $slip->user->name }}</td>
                                                <td>{{ $slip->period->formatLocalized('%B %Y') }}</td>
                                                <td>{{ 'Rp ' . number_format($slip->net_salary, 0, ',', '.') }}</td>
                                                <td>
                                                    <span class="status-badge status-{{ strtolower($slip->status) }}">
                                                        {{ $slip->status }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('slips.show', $slip->id) }}" class="btn btn-sm btn-outline-info btn-action">
                                                        <i class="bi bi-eye"></i> Lihat Detail
                                                    </a>
                                                    @if(auth()->user()->role != 'Operator')
                                                        <a href="{{ route('slips.edit', $slip) }}" class="btn btn-sm btn-outline-primary btn-action">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <form action="{{ route('slips.destroy', $slip) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-action">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit filter
            const filterForm  = document.querySelector('form.row.mb-3');
            const filterMonth = document.getElementById('filter-month');
            const filterYear  = document.getElementById('filter-year');

            filterMonth?.addEventListener('change', () => filterForm.submit());
            filterYear?.addEventListener('change', () => filterForm.submit());
        });
    </script>
</body>
</html>