<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tugas Harian Resi – Naga Hytam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* --- Modal Overlay Styles --- */
    #resultOverlay {
      position: fixed;
      top: 0; left: 0;
      width: 100vw; height: 100vh;
      background: rgba(0,0,0,0.4);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }
    #resultOverlay .box {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      text-align: center;
      animation: fadeIn 0.25s ease;
      max-width: 300px;
      width: 80%;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
    }
    #resultOverlay .spinner {
      width: 40px; height: 40px;
      border: 5px solid #ccc;
      border-top-color: #28a745;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    #resultOverlay .checkmark {
      width: 60px; height: 60px;
      border-radius: 50%;
      border: 4px solid #28a745;
      position: relative;
      display: none;
      animation: scale-in 0.25s ease forwards;
    }
    #resultOverlay .checkmark::after {
      content: '';
      position: absolute;
      left: 16px; top: 8px;
      width: 16px; height: 32px;
      border-right: 4px solid #28a745;
      border-bottom: 4px solid #28a745;
      transform: rotate(45deg);
    }
    #resultOverlay h3, #resultOverlay p {
      margin: 0;
      display: none;
    }
    @keyframes scale-in {
      0% { transform: scale(0); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-5px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="container py-4">
  <div class="d-flex align-items-center mb-4">
    <a href="{{ route('dashboard') }}" class="me-3 text-secondary fs-4">
      <i class="bi bi-house-door"></i>
    </a>
    <!-- Judul utama -->
    <h2 class="m-0">Tugas Harian Resi – Naga Hytam</h2>
  </div>

  <div class="row gx-4">
    <!-- KIRI -->
    <div class="col-lg-4 mb-4">
      <div class="dropdown mb-4">
        <button id="dropdownResiBtn" class="btn btn-outline-secondary dropdown-toggle w-100 text-start" data-bs-toggle="dropdown">
          Pilih resi dari daftar
        </button>
        <ul id="dropdownMenu" class="dropdown-menu w-100">
          @foreach($data as $key => $r)
            <li>
              <a class="dropdown-item" href="#" data-key="{{ $key }}">
                <div><strong>{{ $r['kode'] }}</strong>
                  <div class="resi-info">{{ $r['tujuan'] }}</div>
                </div>
                <span class="badge {{ $r['status']==='Selesai'?'bg-success':'bg-warning text-dark' }}">
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
        <div class="progress mb-3" style="height:8px;">
          <div id="progressBar" class="progress-bar bg-primary" role="progressbar" style="width:0%"></div>
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
              <tr><th>No</th><th>Item</th><th>Qty</th><th>Checklist</th></tr>
            </thead>
            <tbody id="resiTableBody"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Overlay -->
<div id="resultOverlay">
  <div class="box">
    <div class="spinner" id="spinner"></div>
    <div class="checkmark" id="checkmark"></div>
    <h3 id="textTitle">Berhasil!</h3>
    <p id="textDesc">Status diubah menjadi Selesai.</p>
  </div>
</div>

<script>
  const resiData = <?= json_encode($data, JSON_UNESCAPED_UNICODE) ?>;

  function buildDropdown() {
    $("#dropdownMenu").empty();
    Object.keys(resiData).forEach(key => {
      const r = resiData[key];
      const badgeClass = r.status === "Selesai" ? "bg-success" : "bg-warning text-dark";
      $("#dropdownMenu").append(`
        <li>
          <a class="dropdown-item" href="#" data-key="${key}">
            <div><strong>${r.kode}</strong>
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
    // Update header & info
    $("#dropdownResiBtn").text(d.kode);
    $("#infoKode").text(d.kode);
    $("#infoTujuan").text(d.tujuan);
    $("#infoTanggal").text(d.tanggal);
    $("#infoStatus").text(d.status);

    // Bangun tabel checklist
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

    // Jika status sudah Selesai, ceklis & disable semuanya
    if (d.status === "Selesai") {
      $(".checklist")
        .prop("checked", true)
        .prop("disabled", true);
      $("#markAll").prop("disabled", true);
      // Pastikan progress full
      $("#doneCount").text(d.items.length);
      $("#totalCount").text(d.items.length);
      $("#percentDone").text("100%");
      $("#progressBar").css("width", "100%");
      $("#infoStatus").text("Selesai");
    } else {
      updateProgress();
    }
  }

  function updateProgress() {
    const all  = $(".checklist").length;
    const done = $(".checklist:checked").length;
    const pct  = all ? Math.round(done/all*100) : 0;
    $("#doneCount").text(done);
    $("#totalCount").text(all);
    $("#percentDone").text(pct + "%");
    $("#progressBar").css("width", pct + "%");
    $("#infoStatus").text(done===all && all>0 ? "Selesai" : "Pending");
    $("#markAll").prop("disabled", done!==all);
  }

  function showSuccess(title, desc, delay = 1800) {
    $("#spinner").show();
    $("#checkmark, #textTitle, #textDesc").hide();
    $("#resultOverlay").css("display", "flex");

    setTimeout(() => {
      $("#spinner").hide();
      $("#checkmark").show();
      $("#textTitle").text(title).show();
      $("#textDesc").text(desc).show();
    }, 600);

    setTimeout(() => location.reload(), delay);
  }

  $(function(){
    buildDropdown();
    renderResi(Object.keys(resiData)[0]);

    // Event pick resi
    $(document).on("click", "#dropdownMenu .dropdown-item", function(e){
      e.preventDefault();
      renderResi($(this).data("key"));
    });

    // Tandai selesai
    $("#markAll").on("click", function(){
      const kode = $("#infoKode").text();
      if (kode !== "-") {
        $.ajax({
          url: `/update-status`,
          method: "POST",
          data: {
            _token: "{{ csrf_token() }}",
            kode: kode,
            status: "Selesai"
          },
          success: function(){
            // langsung animasi & reload
            showSuccess("Berhasil!", "Status diubah menjadi Selesai.");
          },
          error: function(){
            alert("Gagal memperbarui status. Silakan coba lagi.");
          }
        });
      }
    });

    // Update progress on checkbox change
    $(document).on("change", ".checklist", updateProgress);
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
