<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tugas Harian Resi – Naga Hytam</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <style>
    body {
      background-color: #f0f4f8;
    }
    .text-dark-blue {
      color: #003366;
    }
    .text-gray {
      color: #555;
    }
    .card-body {
      color: #555;
    }
    .card-body strong {
      color: #003366;
    }
    .table th {
      color: #003366;
    }
    .table td {
      color: #555;
    }
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
    #resultOverlay h3 {
      color: #003366;
    }
    #resultOverlay p {
      color: #555;
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
    .print-only {
      display: none;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="container py-4">
  <div class="print-only text-center mb-3">
    <h2>Receipt - <span id="printKode"></span></h2>
  </div>
  <div class="d-flex align-items-center mb-4 d-print-none">
    <a href="{{ url('dashboard') }}" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors me-3" style="text-decoration: none;">
      <i class="fas fa-home mr-2"></i> Home
    </a>
    <h2 class="m-0 flex-grow-1 text-dark-blue d-print-none">Tugas Harian Resi – Naga Hytam</h2>
    @if(auth()->user() && auth()->user()->role === 'Admin')
      <a href="{{ route('resi.buat') }}" class="btn btn-primary d-print-none">
      <i class="bi bi-plus-lg me-1"></i> Buat Resi
      </a>
    @endif
  </div>

  <div class="row gx-4">
    <!-- KIRI -->
    <div class="col-lg-4 mb-4">
      <div class="dropdown mb-4 d-print-none">
        <button id="dropdownResiBtn" class="btn btn-outline-secondary dropdown-toggle w-100 text-start" data-bs-toggle="dropdown">
          Pilih resi dari daftar
        </button>
        <ul id="dropdownMenu" class="dropdown-menu w-100"></ul>
      </div>

      <div class="card mb-4">
        <div class="card-header" style="background: linear-gradient(to right, #e3f2fd, #e1f5fe);">
          <h5 class="mb-0 text-dark-blue">Informasi Resi</h5>
        </div>
        <div class="card-body">
          <p class="mb-1"><strong>Resi:</strong> <span id="infoKode">-</span></p>
          <p class="mb-1"><strong>Tujuan:</strong> <span id="infoTujuan">-</span></p>
          <p class="mb-1"><strong>Tanggal:</strong> <span id="infoTanggal">-</span></p>
          <p class="mb-0"><strong>Status:</strong> <span id="infoStatus">-</span></p>
        </div>
      </div>

      <div class="card">
        <div class="card-header d-print-none" style="background: linear-gradient(to right, #e3f2fd, #e1f5fe);">
          <h5 class="mb-0 text-dark-blue">Progress Checklist</h5>
        </div>
        <div class="card-body d-print-none">
          <div class="d-flex justify-content-between mb-1">
            <small><span id="doneCount">0</span>/<span id="totalCount">0</span> item selesai</small>
            <small><span id="percentDone">0%</span></small>
          </div>
          <div class="progress mb-3 d-print-none" style="height:8px;">
            <div id="progressBar" class="progress-bar bg-primary" role="progressbar" style="width:0%"></div>
          </div>
          <div class="d-flex gap-2 d-print-none">
            <button id="markAll" class="btn btn-primary flex-grow-1">
              <i class="bi bi-check-circle me-1"></i> Tandai Selesai
            </button>
            <button id="printResi" class="btn btn-secondary">
              <i class="bi bi-printer"></i> Cetak / Save as PDF
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- KANAN -->
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header" style="background: linear-gradient(to right, #e3f2fd, #e1f5fe);">
          <h5 class="mb-0 text-dark-blue">Checklist Item</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table mb-0">
              <thead><tr><th>No</th><th>Item</th><th>Qty</th><th class="text-center">Checklist</th></tr></thead>
              <tbody id="resiTableBody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Overlay -->
<div id="resultOverlay" class="d-print-none">
  <div class="box">
    <div class="spinner" id="spinner"></div>
    <div class="checkmark" id="checkmark"></div>
    <h3 id="textTitle">Berhasil!</h3>
    <p id="textDesc">Operasi berhasil.</p>
  </div>
</div>

<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  const resiData = <?= json_encode($resis, JSON_UNESCAPED_UNICODE) ?>;

  console.log("[DEBUG] resiData:", resiData);

  function buildDropdown() {
    $("#dropdownMenu").empty();
    Object.entries(resiData).forEach(([key, r]) => {
      const badgeClass = r.status === 'Selesai'
        ? 'bg-success'
        : 'bg-warning text-dark';
      $("#dropdownMenu").append(`
        <li>
          <a class="dropdown-item" href="#" data-key="${key}">
            <div><strong class="text-dark-blue">${r.kode}</strong>
              <div class="resi-info text-gray">${r.tujuan}</div>
            </div>
            <span class="badge ${badgeClass}">${r.status}</span>
          </a>
        </li>
      `);
    });
  }

  function renderResi(key) {
    const d = resiData[key];
    if (!d) return;

    $("#dropdownResiBtn").text(d.kode);
    $("#infoKode").text(d.kode);
    $("#infoTujuan").text(d.tujuan);
    $("#infoTanggal").text(d.tanggal);
    $("#infoStatus")
      .text(d.status)
      .removeClass("badge bg-success bg-warning text-dark")
      .addClass(
        d.status === "Selesai"
          ? "badge bg-success"
          : "badge bg-warning text-dark"
      );
    $("#printKode").text(d.kode);

    const tbody = $("#resiTableBody").empty();

    if (d.items && d.items.length > 0) {
      d.items.forEach((it, i) => {
        tbody.append(`
          <tr>
            <td>${i + 1}</td>
            <td>${it.nama ?? it.item ?? '-'}</td>
            <td>${it.qty ?? '-'}</td>
            <td class="text-center">
              <input type="checkbox" class="form-check-input checklist" data-index="${i}" 
                ${d.status === 'Selesai' ? 'checked disabled' : ''}>
            </td>
          </tr>
        `);
      });
    } else {
      tbody.append(`<tr><td colspan="4" class="text-center text-muted">Belum ada item</td></tr>`);
    }

    if (d.status === 'Selesai') {
      const total = d.items.length;
      $("#doneCount").text(total);
      $("#totalCount").text(total);
      $("#percentDone").text("100%");
      $("#progressBar").css("width", "100%");
      $("#markAll").prop("disabled", true);
    } else {
      updateProgress();
    }
  }

  function updateProgress() {
    const all  = $(".checklist").length;
    const done = $(".checklist:checked").length;
    const pct  = all ? Math.round(done / all * 100) : 0;
    $("#doneCount").text(done);
    $("#totalCount").text(all);
    $("#percentDone").text(pct + "%");
    $("#progressBar").css("width", pct + "%");
    $("#markAll").prop("disabled", done !== all);
    $("#printResi").prop("disabled", done !== all);
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

    setTimeout(() => $("#resultOverlay").fadeOut(200), delay);
  }

  function downloadPDF() {
    if (typeof html2pdf === 'undefined') {
      alert('Pustaka html2pdf gagal dimuat. Pastikan koneksi internet stabil atau coba lagi nanti.');
      return;
    }

    // Create a new div for the PDF content
    const pdfContent = document.createElement('div');
    pdfContent.style.background = '#fff';
    pdfContent.style.padding = '20px';
    pdfContent.style.maxWidth = '800px';
    pdfContent.style.margin = '0 auto';
    
    // Get the current receipt data
    const kode = $("#infoKode").text();
    const tujuan = $("#infoTujuan").text();
    const tanggal = $("#infoTanggal").text();
    const status = $("#infoStatus").text();
    
    // Create receipt header
    pdfContent.innerHTML = `
      <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="color: #003366; margin-bottom: 10px;">Receipt - ${kode}</h2>
        <hr style="border-top: 2px solid #003366;">
      </div>
      <div style="margin-bottom: 30px;">
        <p><strong>Resi:</strong> ${kode}</p>
        <p><strong>Tujuan:</strong> ${tujuan}</p>
        <p><strong>Tanggal:</strong> ${tanggal}</p>
        <p><strong>Status:</strong> ${status}</p>
      </div>
    `;

    // Create table for items
    const table = document.createElement('table');
    table.style.width = '100%';
    table.style.borderCollapse = 'collapse';
    table.style.marginTop = '20px';
    
    // Add table header
    table.innerHTML = `
      <thead>
        <tr style="background: #f0f4f8;">
          <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">No</th>
          <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Item</th>
          <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Qty</th>
        </tr>
      </thead>
      <tbody>
    `;

    // Add table rows
    const items = $("#resiTableBody tr").map(function() {
      return {
        no: $(this).find('td:eq(0)').text(),
        item: $(this).find('td:eq(1)').text(),
        qty: $(this).find('td:eq(2)').text()
      };
    }).get();

    items.forEach(item => {
      table.querySelector('tbody').innerHTML += `
        <tr>
          <td style="border: 1px solid #ddd; padding: 12px;">${item.no}</td>
          <td style="border: 1px solid #ddd; padding: 12px;">${item.item}</td>
          <td style="border: 1px solid #ddd; padding: 12px;">${item.qty}</td>
        </tr>
      `;
    });

    pdfContent.appendChild(table);
    document.body.appendChild(pdfContent);

    // Configure PDF options
    const opt = {
      margin: [15, 15, 15, 15],
      filename: `resi-${kode}.pdf`,
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: { 
        scale: 1,
        useCORS: true,
        logging: false
      },
      jsPDF: { 
        unit: 'mm', 
        format: 'a4', 
        orientation: 'portrait'
      }
    };

    // Generate PDF
    html2pdf()
      .from(pdfContent)
      .set(opt)
      .save()
      .then(() => {
        document.body.removeChild(pdfContent);
        showSuccess("Berhasil!", "PDF telah diunduh.");
      })
      .catch(err => {
        console.error('Gagal membuat PDF:', err);
        document.body.removeChild(pdfContent);
        alert('Terjadi kesalahan saat membuat PDF. Silakan coba lagi.');
      });
  }

  $(function() {
    buildDropdown();
    const firstKey = Object.keys(resiData)[0];
    if (firstKey) {
      renderResi(firstKey);
    }

    $(document).on("click", "#dropdownMenu .dropdown-item", function(e) {
      e.preventDefault();
      renderResi($(this).data("key"));
    });

    $("#markAll").on("click", function() {
      const kode = $("#infoKode").text();
      if (kode !== "-") {
        $.post('{{ route("resi.update_status") }}', {
          kode,
          status: "Selesai"
        })
        .done(() => {
          const currentKey = Object.keys(resiData).find(k => resiData[k].kode === kode);
          resiData[currentKey].status = "Selesai";
          showSuccess("Berhasil!", "Status diubah menjadi Selesai.");
          buildDropdown();
          renderResi(currentKey);
        })
        .fail(() => alert("Gagal memperbarui status."));
      }
    });

    $("#printResi").on("click", function() {
      downloadPDF();
    });

    let itemIndex = 1;
    $("#addItem").on("click", () => {
      const row = $(".item-row:first").clone();
      row.find("input").each(function() {
        const oldName = $(this).attr("name");
        const newName = oldName.replace(/items\[\d+\]/, `items[${itemIndex}]`);
        $(this).attr("name", newName).val("");
      });
      $("#itemsContainer").append(row);
      itemIndex++;
    });

    $(document).on("click", ".remove-item", function() {
      if ($("#itemsContainer .item-row").length > 1) {
        $(this).closest(".item-row").remove();
      }
    });

    $("#submitCreate").on("click", function() {
      const raw = $("#createResiForm").serializeArray();
      const data = raw.reduce((acc, { name, value }) => {
        if (name.startsWith("items")) {
          const m = name.match(/items\[(\d+)\]\[(\w+)\]/);
          if (m) {
            const idx = m[1], fld = m[2];
            acc.items = acc.items || {};
            acc.items[idx] = acc.items[idx] || {};
            acc.items[idx][fld] = value;
          }
        } else {
          acc[name] = value;
        }
        return acc;
      }, { items: {} });

      data.items = Object.values(data.items);

      $.post('{{ route("resi.store") }}', data)
        .done(newResi => {
          $("#createResiModal").modal("hide");
          showSuccess("Berhasil!", "Resi baru dibuat.");
          const key = "resi" + newResi.id;
          resiData[key] = {
            kode:    newResi.kode,
            tujuan:  newResi.tujuan,
            tanggal: newResi.tanggal,
            status:  newResi.status,
            items:   newResi.items
          };
          buildDropdown();
          renderResi(key);
        })
        .fail(xhr => {
          alert("Gagal membuat resi: " + (xhr.responseJSON?.message || xhr.statusText));
        });
    });

    $(document).on("change", ".checklist", updateProgress);
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>