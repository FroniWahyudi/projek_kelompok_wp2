<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Pengelolaan Slip Gaji' }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --background-color: #f0f4f8;
            --card-background: #ffffff;
            --primary-button: #007bff;
            --text-primary: #003366;
            --text-secondary: #4a4a4a;
            --toggle-button: #6c757d;
            --table-header-bg: #e3f2fd;
        }
        
        body {
            background-color: var(--background-color);
            font-family: 'Poppins', sans-serif;
            color: var(--text-primary);
        }
        
        .main-content {
            background: var(--card-background);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
            min-height: 90vh;
            margin-top: 20px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 25px;
            position: relative;
            display: inline-block;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 50px;
            height: 4px;
            background: var(--primary-button);
            border-radius: 2px;
        }
        
        .card {
            background-color: var(--card-background);
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
            margin-bottom: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background: var(--primary-button);
            color: white;
            border-bottom: none;
            padding: 15px 20px;
            font-weight: 500;
            border-radius: 12px 12px 0 0 !important;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            font-weight: 600;
            color: var(--text-primary);
            background-color: var(--table-header-bg);
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f1f1;
            color: var(--text-primary);
        }
        
        .table tr:last-child td {
            border-bottom: none;
        }
        
        .table tr:hover td {
            background-color: rgba(0, 123, 255, 0.05);
        }
        
        .btn-primary {
            background-color: var(--primary-button);
            border-color: var(--primary-button);
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #0056b3; /* Darken #007bff */
            border-color: #0056b3;
            transform: translateY(-2px);
        }
        
        .btn-outline-primary {
            color: var(--primary-button);
            border-color: var(--primary-button);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-button);
            color: white;
        }
        
        .btn-action {
            padding: 5px 10px;
            margin-right: 5px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        
        .btn-action:hover {
            transform: translateY(-1px);
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }
        
        .status-published {
            background: rgba(56, 176, 0, 0.1);
            color: #38b000;
        }
        
        .status-draft {
            background: rgba(255, 158, 0, 0.1);
            color: #ff9e00;
        }
        
        .status-canceled {
            background: rgba(239, 35, 60, 0.1);
            color: #ef233c;
        }
        
        .form-select, .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .form-select:focus, .form-control:focus {
            border-color: var(--primary-button);
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }
        
        .filter-section {
            background: var(--card-background);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }
        
        .filter-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--text-primary);
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: var(--text-secondary);
        }
        
        .no-data i {
            font-size: 50px;
            margin-bottom: 15px;
            color: #e0e0e0;
        }
        
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        
        .page-item.active .page-link {
            background-color: var(--primary-button);
            border-color: var(--primary-button);
        }
        
        .page-link {
            color: var(--primary-button);
        }
        
        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }
            
            .page-title {
                font-size: 22px;
            }
            
            .table-responsive {
                border-radius: 10px;
                overflow: hidden;
            }
            
            .table th, .table td {
                padding: 8px 10px;
                font-size: 14px;
            }
            
            .btn-action {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">
                <div class="main-content">
                    <!-- Payslips List View -->
                    <div id="payslips-view">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <a href="{{ route('dashboard') }}" class="btn btn-primary me-2">
                                    <i class="bi bi-house-door-fill me-1"></i> Home
                                </a>
                                <h1 class="page-title d-inline-block ms-2">{{ $title ?? 'Pengelolaan Slip Gaji' }}</h1>
                            </div>
                            @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
                                <a href="{{ route('slip_create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-lg me-1"></i> Buat Slip Baru
                                </a>
                            @endif
                        </div>
                        
                        <div class="filter-section mb-4">
                            <form method="GET" action="{{ route('slips.index') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label for="filter-month" class="filter-label">Pilih Bulan</label>
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
                                    <label for="filter-year" class="filter-label">Pilih Tahun</label>
                                    <select name="year" id="filter-year" class="form-select">
                                        <option value="" {{ request('year') == '' ? 'selected' : '' }}>Semua Tahun</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 d-flex align-items-end justify-content-end">
                                    <button type="button" id="reset-filter" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-file-earmark-text me-2"></i> Daftar Slip Gaji</span>
                                <span class="badge bg-white text-primary">{{ $slips->count() }} Data Ditemukan</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID Slip</th>
                                            <th>Nama Karyawan</th>
                                            <th>Periode</th>
                                            <th>Gaji Bersih</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($slips->count() > 0)
                                            @foreach($slips->sortByDesc('id') as $slip)
                                                <tr>
                                                    <td class="text-center fw-bold">#{{ $slip->id }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                                                <i class="bi bi-person-fill text-primary"></i>
                                                            </div>
                                                            <span>{{ $slip->user->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $slip->period->formatLocalized('%B %Y') }}</td>
                                                    <td class="fw-bold text-success">{{ 'Rp ' . number_format($slip->net_salary, 0, ',', '.') }}</td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <a href="{{ route('slips.show', $slip->id) }}" class="btn btn-sm btn-outline-info btn-action me-2" data-bs-toggle="tooltip" title="Lihat Detail">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            @if(auth()->user()->role != 'Operator')
                                                                <a href="{{ route('slips.edit', $slip) }}" class="btn btn-sm btn-outline-primary btn-action me-2" data-bs-toggle="tooltip" title="Edit">
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('slips.destroy', $slip) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-action" data-bs-toggle="tooltip" title="Hapus">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="no-data">
                                                    <i class="bi bi-file-earmark-excel"></i>
                                                    <h5 class="mt-3">Tidak ada data slip gaji</h5>
                                                    <p class="text-muted">Silakan buat slip gaji baru atau sesuaikan filter pencarian Anda</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if($slips->count() > 0)
                                <div class="card-footer bg-white">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center mb-0">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                            </li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            @endif
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
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Auto-submit filter
            const filterForm = document.querySelector('form.row.g-3');
            const filterMonth = document.getElementById('filter-month');
            const filterYear = document.getElementById('filter-year');
            
            filterMonth?.addEventListener('change', () => filterForm.submit());
            filterYear?.addEventListener('change', () => filterForm.submit());
            
            // Reset filter
            const resetFilter = document.getElementById('reset-filter');
            resetFilter?.addEventListener('click', function() {
                filterMonth.value = '';
                filterYear.value = '';
                filterForm.submit();
            });
            
            // Add animation to table rows
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                row.style.transition = `all 0.3s ease ${index * 0.05}s`;
                
                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, 50);
            });
            
            // Add confirmation for delete action
            const deleteButtons = document.querySelectorAll('.btn-outline-danger');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Apakah Anda yakin ingin menghapus slip gaji ini?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>