<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Shift & Jadwal Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --dark-text: #212529;
            --success-color: #4caf50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark-text);
        }

        .navbar-custom {
            background-color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            height: 76px;
        }

        .navbar-custom .nav-link {
    color: white;
    font-weight: 500;
    font-size: 24px;
}

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 0;
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-outline-primary-custom {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary-custom:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .badge-shift {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            min-width: 60px;
        }

        .badge-pagi {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .badge-sore {
            background-color: #fff8e1;
            color: #ff8f00;
        }

        .badge-overtime {
            background-color: #f3e5f5;
            color: #8e24aa;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .filter-btn {
            border-radius: 20px;
            padding: 8px 15px;
            margin-right: 8px;
            margin-bottom: 8px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .filter-group .btn.active {
            color: black;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table th {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(76, 201, 240, 0.25);
        }

        @media (max-width: 700px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                align-items: stretch;
            }
            .filter-group {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            .filter-group .btn {
                flex: 1 1 auto;
            }
            .table-responsive {
                font-size: 0.9rem;
            }
            .badge-shift {
                min-width: 50px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 400px) {
            .filter-group {
                flex-direction: column;
            }
            .filter-group .btn {
                width: 100%;
            }
            #shiftTable th:nth-child(4),
            #shiftTable td:nth-child(4) {
                display: none;
            }
            #shiftTable th:nth-child(1),
            #shiftTable td:nth-child(1) {
                display: none;
            }
            .table-responsive {
                overflow-x: auto;
            }
            .modal-dialog {
                max-width: 90%;
                margin: 1.5rem auto;
            }
            .action-btn {
                width: 28px;
                height: 28px;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 300px) {
            h2 {
                font-size: 1.25rem;
            }
            .badge-shift {
                min-width: 40px;
                font-size: 0.7rem;
                padding: 0.3rem;
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
    </style>
</head>
<body>
    <nav class="navbar navbar-custom mb-4">
        <div class="container">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="bi bi-house-door me-1"></i> Home
            </a>
        </div>
    </nav>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
            <h2 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Shift & Jadwal Karyawan</h2>
            <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#shiftModal" id="createBtn">
                <i class="bi bi-plus-circle me-1"></i> Jadwal Baru
            </button>
        </div>

        <div class="filter-group mb-4 animate__animated animate__fadeIn">
            <button class="btn btn-outline-primary-custom filter-btn active" onclick="filterShift('All')">
                <i class="bi bi-grid-3x3-gap me-1"></i>Semua
            </button>
            <button class="btn btn-outline-info filter-btn" onclick="filterShift('Pagi')">
                <i class="bi bi-sunrise me-1"></i>Pagi
            </button>
            <button class="btn btn-outline-warning filter-btn" onclick="filterShift('Sore')">
                <i class="bi bi-sunset me-1"></i>Sore
            </button>
            <button class="btn btn-outline-dark filter-btn" onclick="filterShift('Overtime')">
                <i class="bi bi-moon-stars me-1"></i>Overtime
            </button>
        </div>

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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shifts as $index => $shift)
                                <tr data-shift="{{ $shift->type }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($shift->user->name) }}"
                                             class="user-avatar" alt="{{ $shift->user->name }}">
                                    </td>
                                    <td>{{ $shift->user->name }}</td>
                                    <td>{{ $shift->user->department }}</td>
                                    <td>{{ $shift->date->format('Y-m-d') }}</td>
                                    <td>
                                        <span class="badge badge-shift {{ $shift->type=='Pagi'?'badge-pagi':($shift->type=='Sore'?'badge-sore':'badge-overtime') }}">
                                            {{ $shift->type }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-warning action-btn"
                                                onclick="openEditModal('{{ $shift->id }}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
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
                                <select name="user_id" id="userSelect" class="form-select" required>
                                    <option value="" disabled selected>Pilih karyawan...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
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
            if (!shift) return;
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
            document.getElementById('userSelect').value = shift.user_id;
            // Jika shift.date masih ISO full, potong 10 karakter pertama:
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