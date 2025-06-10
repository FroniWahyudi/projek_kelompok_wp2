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
    <!-- Css Custom -->
    <link rel="stylesheet" href="{{ asset('css/shift_karyawan.css') }}">
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

        <!-- Search Bar -->
        <div class="row mb-3 justify-content-center">
            <div class="col-md-6 col-12">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari nama, departemen, atau shift...">
            </div>
        </div>

        <!-- Data Table -->
        <div class="card animate__animated animate__fadeIn">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0" id="shiftTable">
                        <thead class="table-light">
                            <tr>
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
            // After filtering by shift, also apply search filter
            applySearchFilter();
        }

        // Search filter function
        function applySearchFilter() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('#shiftTable tbody tr').forEach(row => {
                // Always check if row matches the current shift filter
                const shiftType = row.dataset.shift;
                let isShiftVisible = true;
                // Check which filter button is active
                const activeBtn = document.querySelector('.filter-btn.active');
                if (activeBtn && !activeBtn.textContent.includes('Semua')) {
                    const filterType = activeBtn.textContent.trim().replace(/\s+/g, '');
                    isShiftVisible = (shiftType === filterType);
                }
                if (!isShiftVisible) {
                    row.style.display = 'none';
                    return;
                }
                if (!query) {
                    row.style.display = '';
                    return;
                }
                const cells = row.querySelectorAll('td');
                let match = false;
                // Nama (2), Departemen (3), Shift (5)
                if (
                    cells[2] && cells[2].textContent.toLowerCase().includes(query) ||
                    cells[3] && cells[3].textContent.toLowerCase().includes(query) ||
                    cells[5] && cells[5].textContent.toLowerCase().includes(query)
                ) {
                    match = true;
                }
                row.style.display = match ? '' : 'none';
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

        // Event listener for search input
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('searchInput').addEventListener('input', applySearchFilter);
        });
    </script>
</body>
</html>