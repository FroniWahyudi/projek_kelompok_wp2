<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Shift & Jadwal Karyawan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body { background-color: #f8f9fa; }
    .nav-button { margin-bottom: 1rem; }
    .filter-group .btn { margin-right: 0.5rem; }
    .card { border: none; border-radius: 0.5rem; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    .badge-shift { min-width: 60px; }
    @media (max-width: 700px) {
      .d-flex.justify-content-between { flex-direction: column; align-items: stretch; }
      .filter-group { display: flex; flex-wrap: wrap; gap: 0.5rem; }
      .filter-group .btn { flex: 1 1 auto; }
      .table-responsive { font-size: 0.9rem; }
      .badge-shift { min-width: 50px; font-size: 0.8rem; }
    }
    @media (max-width: 400px) {
      .filter-group { flex-direction: column; }
      .filter-group .btn { width: 100%; }
      #shiftTable th:nth-child(4), #shiftTable td:nth-child(4) { display: none; }
      #shiftTable th:nth-child(1), #shiftTable td:nth-child(1) { display: none; }
      .table-responsive { overflow-x: auto; }
      .modal-dialog { max-width: 90%; margin: 1.5rem auto; }
      .btn-sm { padding: 0.25rem 0.4rem; font-size: 0.75rem; }
    }
    @media (max-width: 300px) {
      h2 { font-size: 1.25rem; }
      .badge-shift { min-width: 40px; font-size: 0.7rem; padding: 0.3rem; }
      .btn { font-size: 0.75rem; padding: 0.4rem; }
      .filter-group .btn { font-size: 0.75rem; padding: 0.3rem; }
    }
  </style>
</head>
<body>
  <div class="container py-4">
    <a href="{{ route('dashboard') }}" class="btn btn-outline-dark nav-button">
      <i class="bi bi-house-door me-1"></i> Home
    </a>
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="mb-0">Shift & Jadwal Karyawan</h2>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#shiftModal" id="createBtn">
        <i class="bi bi-plus-circle me-1"></i> Jadwal Baru
      </button>
    </div>

    <div class="filter-group mb-3">
      <button class="btn btn-outline-primary" onclick="filterShift('All')">Semua</button>
      <button class="btn btn-outline-info" onclick="filterShift('Pagi')">Pagi</button>
      <button class="btn btn-outline-warning" onclick="filterShift('Sore')">Sore</button>
      <button class="btn btn-outline-dark" onclick="filterShift('Overtime')">Overtime</button>
    </div>

    <div class="card">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped align-middle mb-0" id="shiftTable">
            <thead class="table-dark">
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
                       width="40" height="40" class="rounded-circle" 
                       alt="{{ $shift->user->name }}">
                </td>
                <td>{{ $shift->user->name }}</td>
                <td>{{ $shift->user->department }}</td>
                <td>{{ $shift->date->format('Y-m-d') }}</td>
                <td>
                  <span class="badge bg-{{ $shift->type=='Pagi'?'info':($shift->type=='Sore'?'warning':'dark') }} text-dark badge-shift">
                    {{ $shift->type }}
                  </span>
                </td>
                <td>
                  <button class="btn btn-sm btn-outline-warning" 
                          onclick="openEditModal('{{ $shift->id }}')">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <form action="{{ route('shifts.destroy', $shift) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                            onclick="return confirm('Hapus jadwal shift ini?')">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
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
          <div class="modal-header">
            <h5 class="modal-title" id="shiftModalLabel">Jadwal Shift</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="shiftForm" method="POST" action="" novalidate>
            @csrf
            <div class="modal-body">
              <input type="hidden" name="shift_id" id="shiftId">
              <div class="mb-3">
                <label for="usersSelect" class="form-label">Nama Karyawan</label>
                <select name="users_id" id="usersSelect" class="form-select" required>
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
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
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
    }

  
  // Cetak data shifts PHP ke JavaScript
  <?php $shiftsJson = json_encode($shifts); ?>
  const shifts = <?php echo $shiftsJson; ?>;

  function openEditModal(id) {
    const shift = shifts.find(s => s.id == id);
    if (!shift) return;
    const form  = document.getElementById('shiftForm');

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
    document.getElementById('shiftId').value        = shift.id;
    document.getElementById('usersSelect').value  = shift.users_id;
    // Jika shift.date masih ISO full, potong 10 karakter pertama:
    document.getElementById('dateInput').value       = shift.date.substr(0,10);
    document.getElementById('typeSelect').value      = shift.type;

    // Tampilkan modal
    new bootstrap.Modal(
      document.getElementById('shiftModal')
    ).show();
  }


  </script>
</body>
</html>