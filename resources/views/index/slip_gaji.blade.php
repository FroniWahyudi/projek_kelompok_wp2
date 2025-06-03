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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --background-color: #f0f4f8;
            --card-background: #ffffff;
            --primary-button: #007bff;
            --text-primary: #003366;
            --text-secondary: #4a4a4a;
            --toggle-button: #6c757d;
            --table-header-bg: #e3f2fd;
            --shadow-light: 0 4px 6px rgba(0, 0, 0, 0.05);
            --shadow-medium: 0 10px 15px rgba(0, 0, 0, 0.07);
            --shadow-hover: 0 15px 25px rgba(0, 0, 0, 0.1);
            --border-radius: 16px;
            --transition: all 0.2s ease-in-out;
            /* Variables untuk home section tetap tidak berubah */
            --background-main: #f0f4f8;
            --button-focus: #007bff;
            --gradient-start: #e3f2fd;
            --gradient-end: #e1f5fe;
            --primary-text-home: #003366;
            --secondary-text-home: #4a4a4a;
            --muted-text: #6c757d;
            --home-button-bg: #ffffff;
            --home-button-hover: #f8f9fa;
            --home-button-border: #dee2e6;
            --notification-bg: #d4edda;
            --notification-text: #155724;
        }

        body {
            background-color: var(--background-color);
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Home Button Styling */
        .home-button {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1050;
            background-color: var(--home-button-bg);
            color: var(--button-focus);
            padding: 12px 15px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border: 2px solid var(--home-button-border);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 100px;
            justify-content: center;
        }

        .home-button:hover {
            background-color: var(--button-focus);
            color: var(--card-background);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.25);
            text-decoration: none;
        }

        .home-button i {
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .home-button:hover i {
            transform: scale(1.1);
        }

        .main-content {
            background: var(--card-background);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-medium);
            padding: 32px;
            min-height: 90vh;
            margin: 90px 24px 24px 24px;
        }

        /* Header Section */
        .header-section {
            background: var(--card-background);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            padding: 28px 32px;
            margin-bottom: 28px;
            text-align: center;
        }

        .page-title {
            font-size: 30px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
        }

        .page-title i {
            color: var(--primary-button);
            font-size: 34px;
        }

        .create-button {
            background: linear-gradient(135deg, var(--primary-button) 0%, #3b82f6 100%);
            border: none;
            color: white;
            padding: 14px 28px;
            border-radius: 40px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            transition: var(--transition);
            box-shadow: var(--shadow-light);
        }

        .create-button:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
            color: white;
        }

        /* Filter Section */
        .filter-section {
            background: var(--card-background);
            border-radius: var(--border-radius);
            padding: 28px;
            box-shadow: var(--shadow-light);
            margin-bottom: 28px;
        }

        .filter-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .filter-title i {
            color: var(--primary-button);
            font-size: 22px;
        }

        .filter-label {
            font-weight: 500;
            margin-bottom: 10px;
            color: var(--text-primary);
            font-size: 15px;
        }

        .form-select, .form-control {
            border-radius: 12px;
            padding: 14px 18px;
            border: 2px solid #e5e7eb;
            transition: var(--transition);
            font-size: 15px;
            background: #f9fafb;
        }

        .form-select:focus, .form-control:focus {
            border-color: var(--primary-button);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.2);
            background: white;
        }

        .reset-button {
            background: white;
            border: 2px solid var(--toggle-button);
            color: var(--toggle-button);
            padding: 12px 24px;
            border-radius: 40px;
            font-weight: 500;
            transition: var(--transition);
        }

        .reset-button:hover {
            background: var(--toggle-button);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-light);
        }

        .card {
            background-color: var(--card-background);
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            margin-bottom: 28px;
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-button) 0%, #3b82f6 100%);
            color: white;
            border-bottom: none;
            padding: 22px 28px;
            font-weight: 500;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .data-count-badge {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            backdrop-filter: blur(12px);
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            color: var(--text-primary);
            background: var(--table-header-bg);
            padding: 18px 22px;
            border-bottom: 2px solid #d1d5db;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .table td {
            padding: 18px 22px;
            vertical-align: middle;
            border-bottom: 1px solid #e5e7eb;
            color: var(--text-primary);
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tr:hover td {
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.05) 0%, rgba(0, 123, 255, 0.1) 100%);
        }

        .employee-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .avatar-sm {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--primary-button);
        }

        .avatar-sm i {
            color: var(--primary-button);
            font-size: 18px;
        }

        .employee-name {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 15px;
        }

        .slip-id {
            background: linear-gradient(135deg, var(--primary-button) 0%, #3b82f6 100%);
            color: white;
            padding: 8px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            display: inline-block;
        }

        .period-text {
            font-weight: 500;
            color: var(--text-secondary);
            background: #f9fafb;
            padding: 10px 14px;
            border-radius: 10px;
            display: inline-block;
            font-size: 14px;
        }

        .salary-amount {
            font-weight: 700;
            font-size: 16px;
            color: #16a34a;
            background: rgba(22, 163, 74, 0.1);
            padding: 10px 14px;
            border-radius: 10px;
            display: inline-block;
        }

        .btn-action {
            padding: 10px 14px;
            margin: 0 4px;
            border-radius: 10px;
            transition: var(--transition);
            font-size: 14px;
            border: 2px solid;
        }

        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-light);
        }

        .btn-outline-info {
            border-color: #0ea5e9;
            color: #0ea5e9;
        }

        .btn-outline-info:hover {
            background: #0ea5e9;
            color: white;
        }

        .btn-outline-primary {
            border-color: var(--primary-button);
            color: var(--primary-button);
        }

        .btn-outline-primary:hover {
            background: var(--primary-button);
            color: white;
        }

        .btn-outline-danger {
            border-color: #dc2626;
            color: #dc2626;
        }

        .btn-outline-danger:hover {
            background: #dc2626;
            color: white;
        }

        .no-data {
            text-align: center;
            padding: 64px 48px;
            color: var(--text-secondary);
        }

        .no-data i {
            font-size: 72px;
            margin-bottom: 24px;
            color: #d1d5db;
        }

        .no-data h5 {
            font-weight: 600;
            margin-bottom: 12px;
            color: var(--text-primary);
            font-size: 20px;
        }

        .no-data p {
            font-size: 15px;
            line-height: 1.7;
        }

        .pagination {
            justify-content: center;
            margin-top: 32px;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary-button) 0%, #3b82f6 100%);
            border-color: var(--primary-button);
        }

        .page-link {
            color: var(--primary-button);
            border-radius: 10px;
            margin: 0 4px;
            border: 2px solid #e5e7eb;
            transition: var(--transition);
            font-size: 14px;
        }

        .page-link:hover {
            background: var(--primary-button);
            color: white;
            transform: translateY(-2px);
        }

        /* Loading Animation */
        .table-loading {
            opacity: 0;
            transform: translateY(24px);
            animation: fadeInUp 0.4s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                margin: 90px 16px 16px 16px;
                padding: 24px;
            }
        }

        @media (max-width: 768px) {
            .home-button {
                top: 15px;
                left: 15px;
                padding: 10px 16px;
                font-size: 13px;
                min-width: 90px;
            }

            .main-content {
                margin: 80px 12px 12px 12px;
                padding: 20px;
            }

            .page-title {
                font-size: 24px;
                flex-direction: column;
                gap: 10px;
            }

            .header-section {
                padding: 20px;
            }

            .filter-section {
                padding: 20px;
            }

            .table-responsive {
                border-radius: 12px;
                overflow: hidden;
                box-shadow: var(--shadow-light);
            }

            .table th, .table td {
                padding: 14px 10px;
                font-size: 13px;
            }

            .btn-action {
                margin-bottom: 6px;
                padding: 8px 10px;
                font-size: 13px;
            }

            .employee-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .salary-amount {
                font-size: 14px;
            }

            .slip-id {
                font-size: 12px;
            }
        }

        @media (max-width: 640px) {
            .home-button span {
                display: none;
            }

            .main-content {
                margin: 70px 8px 8px 8px;
                padding: 16px;
            }

            .header-section {
                padding: 16px;
            }

            .filter-section {
                padding: 16px;
            }

            .page-title {
                font-size: 20px;
            }

            .table th, .table td {
                padding: 10px 6px;
                font-size: 12px;
            }

            .no-data {
                padding: 48px 24px;
            }

            .no-data i {
                font-size: 56px;
            }
        }
    </style>
</head>
<body>
    <!-- Fixed Home Button -->
    <a href="{{ url('dashboard') }}" class="home-button">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">
                <div class="main-content">
                    <!-- Header Section -->
                    <div class="header-section">
                        <h1 class="page-title">
                            <i class="bi bi-file-earmark-text"></i>
                            @if(auth()->user()->role === 'Admin')
                                {{ $title ?? 'Pengelolaan Slip Gaji' }}
                            @else
                                Slip Gaji {{ auth()->user()->name }}
                            @endif
                        </h1>
                        @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
                            <a href="{{ route('slip_create') }}" class="create-button">
                                <i class="bi bi-plus-lg"></i>
                                Buat Slip Baru
                            </a>
                        @endif
                    </div>

                    <!-- Filter Section -->
                    <div class="filter-section">
                        <div class="filter-title">
                            <i class="bi bi-funnel"></i>
                            Filter Data
                        </div>
                        <form method="GET" action="{{ route('slips.index') }}" class="row g-3">
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <label for="filter-year" class="filter-label">Pilih Tahun</label>
                                <select name="year" id="filter-year" class="form-select">
                                    <option value="" {{ request('year') == '' ? 'selected' : '' }}>Semua Tahun</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="button" id="reset-filter" class="reset-button w-100">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                                    Reset Filter
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Data Table -->
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <i class="bi bi-table"></i>
                                Daftar Slip Gaji
                            </span>
                            <span class="data-count-badge">{{ $slips->count() }} Data Ditemukan</span>
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
                                <tbody class="table-loading">
                                    @if($slips->count() > 0)
                                        @foreach($slips as $slip)
                                            <tr>
                                                <td class="text-center">
                                                    <span class="slip-id">#{{ $slip->id }}</span>
                                                </td>
                                                <td>
                                                    <div class="employee-info">
                                                        <div class="avatar-sm">
                                                            <i class="bi bi-person-fill"></i>
                                                        </div>
                                                        <span class="employee-name">{{ $slip->user->name ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="period-text">{{ $slip->period ? $slip->period->formatLocalized('%B %Y') : 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span class="salary-amount">{{ 'Rp ' . number_format($slip->net_salary ?? 0, 0, ',', '.') }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center flex-wrap">
                                                        <a href="{{ route('slips.show', $slip->id) }}" class="btn btn-sm btn-outline-info btn-action" data-bs-toggle="tooltip" title="Lihat Detail">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        @if(auth()->user()->role != 'Operator')
                                                            <a href="{{ route('slips.edit', $slip->id) }}" class="btn btn-sm btn-outline-primary btn-action" data-bs-toggle="tooltip" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <form action="{{ route('slips.destroy', $slip->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-secondary btn-action" data-bs-toggle="tooltip" title="Hapus">
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
                                            <td colspan="5" class="no-data">
                                                <i class="bi bi-file-earmark-excel"></i>
                                                <h5 class="mt-3">Tidak ada data slip gaji</h5>
                                                <p class="text-muted">Silakan buat slip gaji baru atau sesuaikan filter pencarian Anda</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if($slips->hasPages())
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item {{ $slips->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $slips->previousPageUrl() }}" tabindex="-1">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                                @foreach($slips->getUrlRange(1, $slips->lastPage()) as $page => $url)
                                    <li class="page-item {{ $slips->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li class="page-item {{ $slips->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $slips->nextPageUrl() }}">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Toast -->
    @if(session('success'))
    <div id="notif-success" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        <div class="toast align-items-center border-0 show" role="alert" aria-live="assertive" aria-atomic="true"
             style="background-color: #007bff; color: #fff;">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

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

            filterMonth?.addEventListener('change', () => {
                document.querySelector('.table tbody').style.opacity = '0.5';
                filterForm.submit();
            });

            filterYear?.addEventListener('change', () => {
                document.querySelector('.table tbody').style.opacity = '0.5';
                filterForm.submit();
            });

            // Reset filter
            const resetFilter = document.getElementById('reset-filter');
            resetFilter?.addEventListener('click', function() {
                filterMonth.value = '';
                filterYear.value = '';
                filterForm.submit();
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

            // Hide notification after 3.5 seconds
            const notif = document.getElementById('notif-success');
            if (notif) {
                setTimeout(() => {
                    notif.style.display = 'none';
                }, 3500);
            }
        });
    </script>
</body>
</html>