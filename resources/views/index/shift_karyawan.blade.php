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
    <a href="dashboard" class="btn btn-outline-dark nav-button">
      <i class="bi bi-house-door me-1"></i> Home
    </a>
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="mb-0">Shift & Jadwal Karyawan</h2>
      <button class="btn btn-success mt-2 mt-md-0" data-bs-toggle="modal" data-bs-target="#editModal">
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
              <tr data-shift="Pagi">
                <td>1</td>
                <td><img src="https://ui-avatars.com/api/?name=Ahmad+Yusuf" width="40" height="40" class="rounded-circle" alt="Ahmad Yusuf"></td>
                <td>Ahmad Yusuf</td>
                <td>HR</td>
                <td>2025-05-01</td>
                <td><span class="badge bg-info text-dark badge-shift">Pagi</span></td>
                <td>
                  <button class="btn btn-sm btn-outline-warning" onclick="openEditModal(this)"><i class="bi bi-pencil"></i></button>
                  <button class="btn btn-sm btn-outline-danger" onclick="deleteShift(this)"><i class="bi bi-trash"></i></button>
                </td>
              </tr>
              <tr data-shift="Sore">
                <td>2</td>
                <td><img src="https://ui-avatars.com/api/?name=Siti+Rahma" width="40" height="40" class="rounded-circle" alt="Siti Rahma"></td>
                <td>Siti Rahma</td>
                <td>Manajemen</td>
                <td>2025-05-01</td>
                <td><span class="badge bg-warning text-dark badge-shift">Sore</span></td>
                <td>
                  <button class="btn btn-sm btn-outline-warning" onclick="openEditModal(this)"><i class="bi bi-pencil"></i></button>
                  <button class="btn btn-sm btn-outline-danger" onclick="deleteShift(this)"><i class="bi bi-trash"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal Edit/Tambah -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Jadwal Shift</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="modalForm">
              <input type="hidden" id="rowIndex">
              <div class="mb-3">
                <label for="modalNama" class="form-label">Nama Karyawan</label>
                <select id="modalNama" class="form-select" required>
                  <option value="" disabled selected>Pilih karyawan...</option>
                  <option>Ahmad Yusuf</option>
                  <option>Siti Rahma</option>
                  <option>Budi Santoso</option>
                  <option>Lina Marlina</option>
                  <option>Rudi Hartono</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="modalTanggal" class="form-label">Tanggal</label>
                <input type="date" id="modalTanggal" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="modalShift" class="form-label">Shift</label>
                <select id="modalShift" class="form-select" required>
                  <option value="" disabled selected>Pilih shift...</option>
                  <option>Pagi</option>
                  <option>Sore</option>
                  <option>Overtime</option>
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" onclick="saveShift()">Simpan</button>
          </div>
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
    function openEditModal(btn) {
      const row = btn.closest('tr');
      const idx = Array.from(row.parentNode.children).indexOf(row);
      const [ , , nameCell, , dateCell, shiftCell ] = row.children;
      document.getElementById('rowIndex').value = idx;
      document.getElementById('modalNama').value = nameCell.textContent;
      document.getElementById('modalTanggal').value = dateCell.textContent;
      document.getElementById('modalShift').value = shiftCell.textContent.trim();
      new bootstrap.Modal(document.getElementById('editModal')).show();
    }
    function saveShift() {
      const idx = document.getElementById('rowIndex').value;
      const name = document.getElementById('modalNama').value;
      const date = document.getElementById('modalTanggal').value;
      const shift = document.getElementById('modalShift').value;
      const table = document.getElementById('shiftTable').querySelector('tbody');
      if (idx) {
        const row = table.children[idx];
        row.children[2].textContent = name;
        row.children[4].textContent = date;
        const badge = row.children[5].querySelector('span');
        badge.textContent = shift;
        badge.className = `badge badge-shift bg-${shift==='Pagi'?'info':shift==='Sore'?'warning':'dark'} text-dark`;
        row.dataset.shift = shift;
      } else {
        const newRow = table.insertRow();
        newRow.dataset.shift = shift;
        newRow.innerHTML = `
          <td>${table.children.length}</td>
          <td><img src="https://ui-avatars.com/api/?name=${encodeURIComponent(name)}" width="40" height="40" class="rounded-circle"></td>
          <td>${name}</td>
          <td>--</td>
          <td>${date}</td>
          <td><span class="badge badge-shift bg-${shift==='Pagi'?'info':shift==='Sore'?'warning':'dark'} text-dark">${shift}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-warning" onclick="openEditModal(this)"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-outline-danger" onclick="deleteShift(this)"><i class="bi bi-trash"></i></button>
          </td>`;
      }
      document.getElementById('modalForm').reset();
      document.getElementById('rowIndex').value = '';
      bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
    }
    function deleteShift(btn) {
      if (confirm('Hapus jadwal shift ini?')) btn.closest('tr').remove();
    }
  </script>
</body>
</html>
