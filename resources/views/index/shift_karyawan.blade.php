<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Shift & Jadwal Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --background-main: #f0f4f8;
            --card-background: #ffffff;
            --button-focus: #007bff;
            --gradient-start: #e3f2fd;
            --gradient-end: #e1f5fe;
            --primary-text: #003366;
            --secondary-text: #4a4a4a;
            --secondary-text-alt: #555;
            --toggle-button: #6c757d;
            --home-button-bg: #ffffff;
            --home-button-hover: #f8f9fa;
            --home-button-border: #dee2e6;
        }

        body {
            background-color: var(--background-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--primary-text);
            position: relative;
            padding-top: 70px; /* Space for fixed home button */
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

        /* Main Container Adjustments */
        .main-container {
            margin-top: 20px;
            padding: 0 20px;
        }

        /* Header Styling */
        .page-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px 0;
        }

        .page-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-text);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .page-header h2 i {
            color: var(--button-focus);
            font-size: 2.2rem;
        }

        .navbar-custom {
            background-color: var(--button-focus);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            height: 76px;
        }

        .navbar-custom .nav-link {
            color: var(--card-background);
            font-weight: 500;
            font-size: 18px;
        }

        .card {
            border: none;
            border-radius: 15px;
            background-color: var(--card-background);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }

        .card-body {
            padding: 30px;
        }

        .btn-primary-custom {
            background-color: var(--button-focus);
            border-color: var(--button-focus);
            color: var(--card-background);
            transition: all 0.3s ease;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 8px;
        }

        .btn-primary-custom:hover {
            background-color: var(--toggle-button);
            border-color: var(--toggle-button);
            transform: translateY(-2px);
            color: var(--card-background);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-outline-primary-custom {
            border-color: var(--button-focus);
            color: var(--button-focus);
            font-weight: 500;
        }

        .btn-outline-primary-custom:hover {
            background-color: var(--button-focus);
            color: var(--card-background);
        }

        /* Filter Group Styling */
        .filter-group {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 30px;
            padding: 20px;
            background-color: var(--card-background);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .filter-btn {
            border-radius: 25px;
            padding: 12px 20px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid var(--toggle-button);
            color: var(--secondary-text);
            min-width: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .filter-group .btn.active {
            color: var(--card-background);
            background-color: var(--button-focus);
            border-color: var(--button-focus);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.25);
        }

        .filter-btn:hover:not(.active) {
            border-color: var(--button-focus);
            color: var(--button-focus);
            transform: translateY(-1px);
        }

        .badge-shift {
            padding: 10px 16px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            min-width: 80px;
            text-align: center;
        }

        .badge-pagi {
            background-color: #00eaff;
            color: #5e5757;
        }

        .badge-sore {
            background-color: #ffc107;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .badge-overtime {
            background-color: black;
            color: white;
            border: 1px solid #003366;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--card-background);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 700;
            color: var(--secondary-text-alt);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 20px 15px;
            border-bottom: 2px solid var(--gradient-start);
            background-color: #f8f9fa;
        }

        .table td {
            vertical-align: middle;
            color: var(--secondary-text);
            padding: 18px 15px;
            font-size: 0.95rem;
        }

        .table-striped > tbody > tr:nth-of-type(odd) > td {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: var(--secondary-text);
            border: 1px solid var(--toggle-button);
            background-color: transparent;
        }

        .action-btn:hover {
            transform: scale(1.05);
            background-color: var(--button-focus);
            color: var(--card-background);
            border-color: var(--button-focus);
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            color: var(--secondary-text);
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--button-focus);
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.15);
        }

        /* Modal Improvements */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background-color: var(--gradient-start);
            border-radius: 15px 15px 0 0;
            padding: 20px 30px;
        }

        .modal-body {
            padding: 30px;
        }

        .modal-footer {
            padding: 20px 30px;
            background-color: #f8f9fa;
            border-radius: 0 0 15px 15px;
        }

        /* Badge for current user */
        .badge.bg-success {
            background-color: #28a745 !important;
            font-size: 0.75rem;
            padding: 4px 8px;
            margin-left: 8px;
            border-radius: 12px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .page-header h2 {
                font-size: 2rem;
            }
            
            .filter-group {
                padding: 15px;
            }
            
            .card-body {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding-top: 80px;
            }
            
            .home-button {
                top: 15px;
                left: 15px;
                padding: 10px 16px;
                font-size: 13px;
                min-width: 90px;
            }
            
            .page-header h2 {
                font-size: 1.8rem;
                flex-direction: column;
                gap: 10px;
            }
            
            .filter-group {
                flex-direction: column;
                align-items: stretch;
            }
            
            .filter-btn {
                min-width: auto;
                width: 100%;
            }
            
            .card-body {
                padding: 15px;
            }
            
            .table th, .table td {
                padding: 12px 8px;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .main-container {
                padding: 0 15px;
            }
            
            .home-button {
                padding: 8px 12px;
                font-size: 12px;
                min-width: 80px;
            }
            
            .page-header {
                margin-bottom: 25px;
                padding: 20px 0;
            }
            
            .page-header h2 {
                font-size: 1.5rem;
            }
            
            .table-responsive {
                font-size: 0.8rem;
            }
            
            .badge-shift {
                min-width: 60px;
                font-size: 0.75rem;
                padding: 6px 10px;
            }
            
            .user-avatar {
                width: 35px;
                height: 35px;
            }
            
            .action-btn {
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 400px) {
            #shiftTable th:nth-child(4),
            #shiftTable td:nth-child(4) {
                display: none;
            }
            #shiftTable th:nth-child(1),
            #shiftTable td:nth-child(1) {
                display: none;
            }
            
            .modal-dialog {
                max-width: 90%;
                margin: 1.5rem auto;
            }
        }

        @media (max-width: 300px) {
            .page-header h2 {
                font-size: 1.25rem;
            }
            
            .badge-shift {
                min-width: 50px;
                font-size: 0.7rem;
                padding: 4px 8px;
            }
            
            .btn {
                font-size: 0.75rem;
                padding: 0.4rem;
            }
            
            .filter-group .btn {
                font-size: 0.75rem;
                padding: 0.3rem;
            }
        }

        /* Animation Enhancements */
        .animate__fadeIn {
            animation-duration: 0.8s;
        }

        .card, .filter-group, .home-button {
            animation: slideInUp 0.6s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
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

    <div class="container main-container">
        <!-- Page Header -->
        <div class="page-header animate__animated animate__fadeIn">
            <h2>
                <i class="bi bi-calendar-check"></i>
                <span>Shift & Jadwal Karyawan</span>
            </h2>
        </div>

        <!-- Filter Buttons -->
        <div class="filter-group animate__animated animate__fadeIn">
            <button class="btn btn-outline-primary-custom filter-btn active" onclick="filterShift('All')">
                <i class="bi bi-grid-3x3-gap"></i>
                <span>Semua</span>
            </button>
            <button class="btn btn-outline-info filter-btn" onclick="filterShift('Pagi')">
                <i class="bi bi-sunrise"></i>
                <span>Pagi</span>
            </button>
            <button class="btn btn-outline-warning filter-btn" onclick="filterShift('Sore')">
                <i class="bi bi-sunset"></i>
                <span>Sore</span>
            </button>
            <button class="btn btn-outline-dark filter-btn" onclick="filterShift('Overtime')">
                <i class="bi bi-moon-stars"></i>
                <span>Overtime</span>
            </button>
        </div>

        <!-- Data Table -->
        <div class="card animate__animated animate__fadeIn">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0" id="shiftTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Departemen</th>
                                <th>Tanggal</th>
                                <th>Shift</th>
                                @if (auth()->user() && auth()->user()->role === 'Admin')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shifts as $index => $shift)
                                <tr data-shift="{{ $shift->type }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if ($shift->user->photo_url)
                                            <img src="{{ asset($shift->user->photo_url) }}" class="user-avatar" alt="{{ $shift->user->name }}">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($shift->user->name) }}" class="user-avatar" alt="{{ $shift->user->name }}">
                                        @endif
                                    </td>
                                    <td>
                                    {{ $shift->user->name }}
                                    @if ($shift->user->name === auth()->user()->name)
                                        <span class="badge bg-success text-white">Anda</span>
                                    @endif          
                                    </td>
                                    <td>{{ $shift->user->department }}</td>
                                    <td>{{ $shift->date->format('Y-m-d') }}</td>
                                    <td>
                                        <span class="badge badge-shift {{ $shift->type=='Pagi'?'badge-pagi':($shift->type=='Sore'?'badge-sore':'badge-overtime') }}">
                                            {{ $shift->type }}
                                        </span>
                                    </td>
                                    @if (auth()->user() && auth()->user()->role === 'Admin')
                                        <td>
                                            <button class="btn btn-outline-warning action-btn"
                                                    onclick="openEditModal('{{ $shift->id }}')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Create/Edit -->
        <div class="modal fade" id="shiftModal" tabindex="-1" aria-labelledby="shiftModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title" id="shiftModalLabel">
                            <i class="bi bi-calendar-plus me-2"></i>Jadwal Shift
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="shiftForm" method="POST" action="" novalidate>
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="shift_id" id="shiftId">
                            <div class="mb-3">
                                <label for="userSelect" class="form-label">Nama Karyawan</label>
                                <div id="userSelect" class="form-control" style="background-color: var(--card-background); padding: 10px;" readonly>{{-- Nama akan diisi oleh JavaScript --}}</div>
                                <input type="hidden" name="user_id" id="userId">
                            </div>
                            <div class="mb-3">
                                <label for="dateInput" class="form-label">Tanggal</label>
                                <input type="date" name="date" id="dateInput" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="typeSelect" class="form-label">Shift</label>
                                <select name="type" id="typeSelect" class="form-select" required>
                                    <option value="" disabled selected>Pilih shift...</option>
                                    <option value="Pagi">Pagi</option>
                                    <option value="Sore">Sore</option>
                                    <option value="Overtime">Overtime</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="bi bi-save me-1"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterShift(type) {
            document.querySelectorAll('#shiftTable tbody tr').forEach(row => {
                row.style.display = (type === 'All' || row.dataset.shift === type) ? '' : 'none';
            });
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.textContent.includes(type) || (type === 'All' && btn.textContent.includes('Semua'))) {
                    btn.classList.add('active');
                }
            });
        }

        // Cetak data shifts PHP ke JavaScript
        <?php $shiftsJson = json_encode($shifts); ?>
        const shifts = <?php echo $shiftsJson; ?>;

        function openEditModal(id) {
            const shift = shifts.find(s => s.id == id);
            if (!shift) {
                console.error('Shift tidak ditemukan untuk ID:', id);
                return;
            }
            const form = document.getElementById('shiftForm');

            // Set action URL untuk update
            form.action = '/shifts/' + shift.id;

            // Hapus input _method lama jika ada
            const oldMethod = form.querySelector('[name="_method"]');
            if (oldMethod) oldMethod.remove();

            // Tambah input method PUT untuk update
            form.insertAdjacentHTML('afterbegin',
                '<input type="hidden" name="_method" value="PUT">'
            );

            // Isi form dengan data shift
            document.getElementById('shiftId').value = shift.id;
            document.getElementById('userSelect').textContent = shift.user.name; // Isi nama karyawan di div
            document.getElementById('userId').value = shift.user_id; // Isi user_id di hidden input
            document.getElementById('dateInput').value = shift.date.substr(0,10);
            document.getElementById('typeSelect').value = shift.type;

            // Tampilkan modal
            new bootstrap.Modal(
                document.getElementById('shiftModal')
            ).show();
        }
    </script>
</body>
</html>