<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tugas Harian Resi – Naga Hytam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="container py-4">
  <div class="d-flex align-items-center mb-4">
    <!-- Ubah tombol home agar mengarah ke dashboard -->
    <a href="{{ route('dashboard') }}" class="me-3 text-secondary fs-4"><i class="bi bi-house-door"></i></a>
    <h2 class="m-0">Tugas Harian Resi – Naga Hytam</h2>
  </div>

  <div class="row gx-4">
    <!-- KIRI -->
    <div class="col-lg-4 mb-4">
      <div class="dropdown mb-4">
        <button id="dropdownResiBtn" class="btn btn-outline-secondary dropdown-toggle w-100 text-start" type="button" data-bs-toggle="dropdown">
          Pilih resi dari daftar
        </button>
        <ul id="dropdownMenu" class="dropdown-menu w-100">
          @foreach($data as $key => $r)
            <li>
              <a class="dropdown-item" href="#" data-key="{{ $key }}">
                <div>
                  <strong>{{ $r['kode'] }}</strong>
                  <div class="resi-info">{{ $r['tujuan'] }}</div>
                </div>
                <span class="badge {{ $r['status'] === 'Selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                  {{ $r['status'] }}
                </span>
              </a>
            </li>
          @endforeach
        </ul>
      </div>

      <div class="card mb-4 p-3">
        <h5 class="mb-3 text-primary">Informasi Resi</h5>
        <p class="mb-1"><strong>Resi:</strong> <span id="infoKode">-</span></p>
        <p class="mb-1"><strong>Tujuan:</strong> <span id="infoTujuan">-</span></p>
        <p class="mb-1"><strong>Tanggal:</strong> <span id="infoTanggal">-</span></p>
        <p class="mb-0"><strong>Status:</strong> <span id="infoStatus">-</span></p>
      </div>

      <div class="card p-3">
        <h5 class="mb-3 text-primary">Progress Checklist</h5>
        <div class="d-flex justify-content-between mb-1">
          <small><span id="doneCount">0</span>/<span id="totalCount">0</span> item selesai</small>
          <small><span id="percentDone">0%</span></small>
        </div>
        <div class="progress mb-3" style="height: 8px;">
          <div id="progressBar" class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
        </div>
        <button id="markAll" class="btn btn-primary w-100">
          <i class="bi bi-check-circle me-1"></i> Tandai Selesai
        </button>
      </div>
    </div>

    <!-- KANAN -->
    <div class="col-lg-8">
      <div class="card p-3">
        <h5 class="mb-3 text-primary">Checklist Item</h5>
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th>No</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Checklist</th>
              </tr>
            </thead>
            <tbody id="resiTableBody">
              <!-- Diisi via JS -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    const resiData = <?= json_encode($data, JSON_UNESCAPED_UNICODE) ?>;
  function buildDropdown() {
    const menu = $("#dropdownMenu");
    menu.empty();
    Object.keys(resiData).forEach(key => {
      const r = resiData[key];
      const badgeClass = r.status === "Selesai" ? "bg-success" : "bg-warning text-dark";
      menu.append(`
        <li>
          <a class="dropdown-item" href="#" data-key="${key}">
            <div>
              <strong>${r.kode}</strong>
              <div class="resi-info">${r.tujuan}</div>
            </div>
            <span class="badge ${badgeClass}">${r.status}</span>
          </a>
        </li>
      `);
    });
  }

  function renderResi(key) {
    const d = resiData[key];
    $("#dropdownResiBtn").text(d.kode);
    $("#infoKode").text(d.kode);
    $("#infoTujuan").text(d.tujuan);
    $("#infoTanggal").text(d.tanggal);
    $("#infoStatus").text(d.status);

    const tbody = $("#resiTableBody").empty();
    d.items.forEach((it, i) => {
      tbody.append(`
        <tr>
          <td>${i+1}</td>
          <td>${it.item}</td>
          <td>${it.qty}</td>
          <td class="text-center">
            <input type="checkbox" class="form-check-input checklist" data-index="${i}">
          </td>
        </tr>
      `);
    });
    updateProgress();
  }

  function updateProgress() {
    const all = $(".checklist").length;
    const done = $(".checklist:checked").length;
    const pct = all ? Math.round(done / all * 100) : 0;
    $("#doneCount").text(done);
    $("#totalCount").text(all);
    $("#percentDone").text(pct + "%");
    $("#progressBar").css("width", pct + "%");
    $("#infoStatus").text(done === all && all > 0 ? "Selesai" : "Pending");
  }

  $(function() {
    buildDropdown();

    $(document).on("click", "#dropdownMenu .dropdown-item", function(e) {
      e.preventDefault();
      const key = $(this).data("key");
      renderResi(key);
    });

    $("#markAll").on("click", function() {
      $(".checklist").prop("checked", true);
      updateProgress();
    });

    $(document).on("change", ".checklist", updateProgress);

    // Default tampilkan resi pertama
    renderResi(Object.keys(resiData)[0]);
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
