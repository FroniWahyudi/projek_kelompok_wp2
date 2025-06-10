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
    <!-- Css Custom -->
    <link rel="stylesheet" href="{{ asset('css/slip_gaji.css') }}">
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
                                                        <a href="{{ route('slips.show', $slip->id) }}" class="btn btn-sm btn-outline-info btn-action" data-bs-toggle="tooltip">
                                                         Lihat Detail
                                                        </a>
                                                        @if(auth()->user()->role === 'Admin')
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
                                                @if(auth()->user()->role === 'Admin')
                                                    <p class="text-muted">Silakan buat slip gaji baru atau sesuaikan filter pencarian Anda</p>
                                                @endif
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

 <!-- Mobile Bottom Navbar -->
<nav class="mobile-bottom-nav">
  <a href="{{ route('slips.index') }}" class="nav-link">
    <i class="fas fa-file-invoice-dollar"></i>
    <span>Slip Gaji</span>
  </a>
  <a href="{{ route('dashboard') }}" class="nav-link active">
    <i class="fas fa-home"></i>
    <span>Home</span>
  </a>
  <a href="{{ isset($user) && isset($user['id']) ? url('edit_profil/' . $user['id']) : '#' }}" class="nav-link">
    <img src="{{ isset($user['photo_url']) ? htmlspecialchars($user['photo_url'] ?? '/default.jpg') : '/default.jpg' }}"
         class="profile-img-mobile"
         alt="Profile Image">
    <span>Profil</span>
  </a>
</nav>
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


          // Ensure mobile bottom navbar visibility is controlled
    function toggleMobileNav() {
      const mobileNav = document.querySelector('.mobile-bottom-nav');
      if (window.innerWidth > 500) {
        mobileNav.style.display = 'none';
      } else {
        mobileNav.style.display = 'flex';
      }
    }

    // Run on load and resize
    window.addEventListener('load', toggleMobileNav);
    window.addEventListener('resize', toggleMobileNav);

    // Navbar link active state
  document.querySelectorAll('.mobile-bottom-nav .nav-link').forEach(link => {
  link.addEventListener('click', (e) => {
    const href = link.getAttribute('href');
    if (href && !href.startsWith('#')) {
      window.location.href = href; // Izinkan navigasi jika bukan anchor
    } else {
      e.preventDefault();
      document.querySelectorAll('.mobile-bottom-nav .nav-link').forEach(item => {
        item.classList.remove('active');
      });
      link.classList.add('active');
    }
  });
});
    </script>
</body>
</html>