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
            --background-main: #f0f4f8; /* Peringkat 1: Latar belakang utama */
            --card-background: #ffffff; /* Peringkat 2: Latar kartu */
            --button-focus: #007bff; /* Peringkat 3: Tombol dan fokus input */
            --gradient-start: #e3f2fd; /* Peringkat 4: Gradien sisi kiri kartu */
            --gradient-end: #e1f5fe; /* Peringkat 4: Gradien sisi kanan kartu */
            --primary-text: #003366; /* Peringkat 5: Teks utama, judul, logo */
            --secondary-text: #4a4a4a; /* Peringkat 6: Teks sekunder */
            --secondary-text-alt: #555; /* Peringkat 6: Teks sekunder alternatif */
            --toggle-button: #6c757d; /* Peringkat 7: Tombol toggle */
        }

        body {
            background-color: var(--background-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--primary-text);
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
            border-radius: 10px;
            background-color: var(--card-background);
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
            background-color: var(--button-focus);
            border-color: var(--button-focus);
            color: var(--card-background);
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: var(--toggle-button);
            border-color: var(--toggle-button);
            transform: translateY(-2px);
            color: var(--card-background);
        }

        .btn-outline-primary-custom {
            border-color: var(--button-focus);
            color: var(--button-focus);
        }

        .btn-outline-primary-custom:hover {
            background-color: var(--button-focus);
            color: var(--card-background);
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
            background-color: var(--gradient-start);
            color: var(--primary-text);
        }

        .badge-sore {
            background-color: var(--gradient-end);
            color: var(--primary-text);
        }

        .badge-overtime {
            background-color: var(--gradient-start);
            color: var(--primary-text);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--card-background);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .filter-btn {
            border-radius: 20px;
            padding: 8px 15px;
            margin-right: 8px;
            margin-bottom: 8px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            border-color: var(--toggle-button);
            color: var(--secondary-text);
        }

        .filter-group .btn.active {
            color: var(--card-background);
            background-color: var(--button-focus);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table th {
            font-weight: 600;
            color: var(--secondary-text-alt);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
            color: var(--secondary-text);
        }

        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
            color: var(--secondary-text);
            border-color: var(--toggle-button);
        }

        .action-btn:hover {
            transform: scale(1.1);
            background-color: var(--button-focus);
            color: var(--card-background);
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
            color: var(--secondary-text);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--button-focus);
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
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
                                    <td>{{ $shift->user->name }}</td>
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