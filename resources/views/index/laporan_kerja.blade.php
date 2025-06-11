<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tugas Harian Resi – Naga Hytam</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <!-- Css Custom -->
  <link rel="stylesheet" href="{{ asset('css/laporan_kerja.css') }}">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
  <div id="adminChecklistNotif">Hanya Leader atau Operator dengan tugas Inventory checker yang diizinkan.</div>
  <div class="container py-4">
    <!-- Home Button -->
    <a href="{{ url('dashboard') }}" class="home-button d-print-none">
      <i class="fas fa-home"></i> Home
    </a>

    <!-- Print Header -->
    <div class="print-only text-center mb-3">
      <h2>Receipt - <span id="printKode"></span></h2>
    </div>

    <!-- Title and Create Button -->
    <div class="d-flex justify-content-between align-items-center mb-4 mt-5 d-print-none">
      <h2 class="mb-0 fw-bold text-dark-blue">Tugas Harian Resi – PT Naga Hytam Sejahtera Abadi</h2>
      @if(auth()->user() && auth()->user()->role === 'Admin')
        <a href="{{ route('resi.buat') }}" class="btn btn-primary nav-button d-print-none">
          <i class="bi bi-plus-circle me-1"></i> Buat Resi
        </a>
      @endif
    </div>

    <div class="row gx-4">
      <!-- Left Column -->
      <div class="col-lg-4 mb-4">
        <div class="dropdown mb-4 d-print-none">
          <button id="dropdownResiBtn" class="btn btn-outline-primary dropdown-toggle w-100 text-start nav-button" data-bs-toggle="dropdown">
            Pilih resi dari daftar
          </button>
          <ul id="dropdownMenu" class="dropdown-menu w-100"></ul>
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Informasi Resi</h5>
          </div>
          <div class="card-body">
            <p class="mb-1 d-print-none"><strong>Resi:</strong> <span id="infoKode">-</span></p>
            <p class="mb-1"><strong>Tujuan:</strong> <span id="infoTujuan">-</span></p>
            <p class="mb-1"><strong>Tanggal:</strong> <span id="infoTanggal">-</span></p>
            <p class="mb-0"><strong>Status:</strong> <span id="infoStatus" class="badge badge-warning">-</span></p>
            @if(auth()->user() && auth()->user()->role === 'Admin')
              <button id="deleteResi" class="btn btn-danger btn-sm mt-3" style="display:none;">
                <i class="bi bi-trash"></i> Hapus Resi
              </button>
            @endif
          </div>
        </div>

        <div class="card">
          <div class="card-header d-print-none">
            <h5 class="mb-0">Progress Checklist</h5>
          </div>
          <div class="card-body d-print-none">
            <div class="d-flex justify-content-between mb-1">
              <small><span id="doneCount">0</span>/<span id="totalCount">0</span> item selesai</small>
              <small><span id="percentDone">0%</span></small>
            </div>
            <div class="progress mb-3" style="height:8px;">
              <div id="progressBar" class="progress-bar" role="progressbar" style="width:0%"></div>
            </div>
            <div class="d-flex gap-2">
              <button id="markAll" class="btn btn-primary nav-button flex-grow-1">
                <i class="bi bi-check-circle me-1"></i> Tandai Selesai
              </button>
              <button id="printResi" class="btn btn-secondary nav-button">
                <i class="bi bi-printer me-1"></i> Cetak / Save as PDF
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Checklist Item</h5>
          </div>
          <div class="card-body p-0">
            <!-- Tabel untuk layar besar -->
            <div class="table-responsive d-none d-sm-block">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th class="text-center">Checklist</th>
                    <th class="text-center">Dicek Oleh</th>
                  </tr>
                </thead>
                <tbody id="resiTableBody"></tbody>
              </table>
            </div>
            <!-- Accordion untuk layar kecil (300-400px) -->
            <div class="d-sm-none">
              <div class="accordion" id="accordionResi"></div>
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

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="modalConfirmDelete" tabindex="-1" aria-labelledby="modalConfirmDeleteLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-header bg-primary text-white" style="justify-content:center;">
            <h5 class="modal-title" id="modalConfirmDeleteLabel"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus Resi</h5>
          </div>
          <div class="modal-body text-center">
            <i class="bi bi-trash display-4 text-danger mb-3"></i>
            <p class="mb-0 fs-5">Apakah Anda yakin ingin menghapus resi ini?<br><span class="fw-bold text-danger" id="deleteResiKode"></span></p>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-danger px-4" id="btnConfirmDeleteResi"><i class="bi bi-trash me-1"></i> Hapus</button>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    const resiData = <?= json_encode($resis, JSON_UNESCAPED_UNICODE) ?>;
    const userRole = "{{ auth()->user()->role }}";
    const userHasInventoryChecker = <?= 
        str_contains(auth()->user()->job_descriptions ?? '', 'Inventory checker') 
        ? 'true' 
        : 'false' 
    ?>;

    console.log("[DEBUG] resiData:", resiData);
    console.log("[DEBUG] userRole:", userRole);
    console.log("[DEBUG] userHasInventoryChecker:", userHasInventoryChecker);

    function buildDropdown() {
      $("#dropdownMenu").empty();
      Object.entries(resiData).forEach(([key, r]) => {
        const badgeClass = r.status === 'Selesai' ? 'badge-success' : 'badge-warning';
        $("#dropdownMenu").append(`
          <li>
            <a class="dropdown-item" href="#" data-key="${key}">
              <div><strong>${r.kode}</strong>
                <div class="resi-info">${r.tujuan}</div>
              </div>
              <span class="badge badge-status ${badgeClass}">${r.status}</span>
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
        .removeClass("badge badge-success badge-warning")
        .addClass(d.status === "Selesai" ? "badge badge-success" : "badge badge-warning");
      $("#printKode").text(d.kode);

      const tableBody = $("#resiTableBody").empty();
      const accordionContainer = $("#accordionResi").empty();

      if (d.items && d.items.length > 0) {
        d.items.forEach((it, i) => {
          const isDisabled = d.status === 'Selesai' ? 'disabled' : '';
          const isChecked = d.status === 'Selesai' || it.is_checked ? 'checked' : '';

          // Generate table row
          tableBody.append(`
            <tr>
              <td data-label="No">${i + 1}</td>
              <td data-label="Item">${it.nama ?? it.item ?? '-'}</td>
              <td data-label="Qty">${it.qty ?? '-'}</td>
              <td data-label="Checklist" class="text-center">
                <input type="checkbox" class="form-check-input checklist"
                  data-item-id="${it.id ?? ''}"
                  ${isChecked}
                  ${isDisabled}
                >
              </td>
              <td data-label="Dicek Oleh" class="text-center" id="checked-by-${it.id ?? ''}">${it.checked_by ?? '-'}</td>
            </tr>
          `);

          // Generate accordion item
          const accordionItem = `
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading${i}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${i}" aria-expanded="false" aria-controls="collapse${i}">
                  ${it.nama ?? it.item ?? '-'}
                </button>
              </h2>
              <div id="collapse${i}" class="accordion-collapse collapse" aria-labelledby="heading${i}" data-bs-parent="#accordionResi">
                <div class="accordion-body">
                  <p><strong>No:</strong> ${i + 1}</p>
                  <p><strong>Qty:</strong> ${it.qty ?? '-'}</p>
                  <p><strong>Checklist:</strong> <input type="checkbox" class="form-check-input checklist" data-item-id="${it.id ?? ''}" ${isChecked} ${isDisabled}></p>
                  <p><strong>Dicek Oleh:</strong> <span id="checked-by-accordion-${it.id ?? ''}">${it.checked_by ?? '-'}</span></p>
                </div>
              </div>
            </div>
          `;
          accordionContainer.append(accordionItem);
        });
      } else {
        // Handle empty state for both
        tableBody.append(`
          <tr>
            <td colspan="5" class="empty-state">
              <i class="bi bi-inbox empty-state-icon"></i>
              <h5>Belum ada item</h5>
              <p class="text-muted">Tidak ada item untuk ditampilkan</p>
            </td>
          </tr>
        `);
        accordionContainer.append(`
          <div class="empty-state">
            <i class="bi bi-inbox empty-state-icon"></i>
            <h5>Belum ada item</h5>
            <p class="text-muted">Tidak ada item untuk ditampilkan</p>
          </div>
        `);
      }

      $("#printResi").prop("disabled", true);

      if (userRole === 'Admin') {
        if (d.kode) {
          $("#deleteResi").show().data('id', d.id);
        } else {
          $("#deleteResi").hide();
        }
      }

      if (d.status === 'Selesai') {
        const total = d.items.length;
        $("#doneCount").text(total);
        $("#totalCount").text(total);
        $("#percentDone").text("100%");
        $("#progressBar").css("width", "100%");
        $("#markAll").prop("disabled", true);
        $("#printResi").prop("disabled", false);
      } else {
        updateProgress();
      }
    }

   function updateProgress() {
  const kode = $("#infoKode").text();
  const key = Object.keys(resiData).find(k => resiData[k].kode === kode);
  if (!key) return;
  const items = resiData[key].items;
  const all = items.length;
  const done = items.filter(it => it.is_checked).length;
  const pct = all ? Math.round((done / all) * 100) : 0;
  $("#doneCount").text(done);
  $("#totalCount").text(all);
  $("#percentDone").text(pct + "%");
  $("#progressBar").css("width", pct + "%");
  const isSelesai = $("#infoStatus").text() === "Selesai";
  $("#markAll").prop("disabled", isSelesai || userRole !== 'Leader' || pct < 100);
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

      const pdfContent = document.createElement('div');
      pdfContent.style.background = '#fff';
      pdfContent.style.padding = '20px';
      pdfContent.style.maxWidth = '800px';
      pdfContent.style.margin = '0 auto';

      const kode = $("#infoKode").text();
      const tujuan = $("#infoTujuan").text();
      const tanggal = $("#infoTanggal").text();
      const status = $("#infoStatus").text();

      pdfContent.innerHTML = `
        <div style="text-align: center; margin-bottom: 30px;">
          <h2 style="color: #003366; margin-bottom: 10px;">Receipt - ${kode}</h2>
          <hr style="border-top: 2px solid #003366;">
        </div>
        <div style="margin-bottom: 30px;">
          <p><strong>Tujuan:</strong> ${tujuan}</p>
          <p><strong>Tanggal:</strong> ${tanggal}</p>
          <p><strong>Status:</strong> ${status}</p>
        </div>
      `;

      const table = document.createElement('table');
      table.style.width = '100%';
      table.style.borderCollapse = 'collapse';
      table.style.marginTop = '20px';

      table.innerHTML = `
        <thead>
          <tr style="background: #f0f4f8;">
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">No</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Item</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Qty</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Dicek Oleh</th>
          </tr>
        </thead>
        <tbody>
      `;

      const items = $("#resiTableBody tr").map(function() {
        return {
          no: $(this).find('td:eq(0)').text(),
          item: $(this).find('td:eq(1)').text(),
          qty: $(this).find('td:eq(2)').text(),
          checked_by: $(this).find('td:eq(4)').text()
        };
      }).get();

      items.forEach(item => {
        table.querySelector('tbody').innerHTML += `
          <tr>
            <td style="border: 1px solid #ddd; padding: 12px;">${item.no}</td>
            <td style="border: 1px solid #ddd; padding: 12px;">${item.item}</td>
            <td style="border: 1px solid #ddd; padding: 12px;">${item.qty}</td>
            <td style="border: 1px solid #ddd; padding: 12px;">${item.checked_by}</td>
          </tr>
        `;
      });

      pdfContent.appendChild(table);
      document.body.appendChild(pdfContent);

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

    function showAdminChecklistNotif() {
      const notif = $("#adminChecklistNotif");
      notif.addClass("active");
      notif.show();
      setTimeout(() => {
        notif.removeClass("active");
        setTimeout(() => notif.hide(), 400);
      }, 1800);
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
        if (userRole !== 'Leader') {
          alert("Hanya Leader yang dapat menandai semua item sebagai selesai.");
          return;
        }
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
        window.scrollTo({ top: 0, behavior: 'smooth' });
        setTimeout(function() {
          downloadPDF();
        }, 400);
      });

    $(document).on("change", ".checklist", function() {
  if (userRole === 'Admin' || userRole === 'Manajer' || (userRole === 'Operator' && !userHasInventoryChecker)) {
    showAdminChecklistNotif();
    $(this).prop('checked', !$(this).is(":checked"));
    return;
  }
  const id = $(this).data("item-id");
  const isChecked = $(this).is(":checked");
  $.post('{{ route("resi.checklist", ":id") }}'.replace(':id', id), {
    is_checked: isChecked,
    _token: $('meta[name="csrf-token"]').attr('content')
  })
    .done(response => {
      if (response.success) {
        // Update resiData
        const kode = $("#infoKode").text();
        const key = Object.keys(resiData).find(k => resiData[k].kode === kode);
        if (key) {
          const item = resiData[key].items.find(it => it.id == id);
          if (item) {
            item.is_checked = isChecked;
            item.checked_by = response.checked_by;
          }
        }
        // Sinkronisasi kedua checklist
        $(`.checklist[data-item-id="${id}"]`).prop('checked', isChecked);
        // Update field "Dicek Oleh"
        $(`#checked-by-${id}`).text(response.checked_by || '-');
        $(`#checked-by-accordion-${id}`).text(response.checked_by || '-');
        updateProgress();
      } else {
        alert(response.message);
        $(this).prop('checked', !isChecked);
      }
    })
    .fail(xhr => {
      alert("Gagal memperbarui checklist: " + (xhr.responseJSON?.message || xhr.statusText));
      $(this).prop('checked', !isChecked);
    });
});

      $(document).on("click", "#deleteResi", function() {
        resiIdToDelete = $(this).data('id');
        const kode = $("#infoKode").text();
        resiKodeToDelete = kode;
        $("#deleteResiKode").text(kode);
        const modal = new bootstrap.Modal(document.getElementById('modalConfirmDelete'));
        modal.show();
      });

      $(document).on("click", "#btnConfirmDeleteResi", function() {
        if (!resiIdToDelete) return;
        $.ajax({
          url: '/resi/' + resiIdToDelete,
          type: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            $('#modalConfirmDelete').modal('hide');
            if (response.success) {
              showSuccess("Berhasil!", response.message);
              const key = Object.keys(resiData).find(k => resiData[k].id == resiIdToDelete);
              if (key) {
                delete resiData[key];
                buildDropdown();
                const firstKey = Object.keys(resiData)[0];
                if (firstKey) {
                  renderResi(firstKey);
                } else {
                  $("#resiTableBody").html(`
                    <tr>
                      <td colspan="5" class="empty-state">
                        <i class="bi bi-inbox empty-state-icon"></i>
                        <h5>Belum ada resi</h5>
                        <p class="text-muted">Tidak ada resi untuk ditampilkan</p>
                      </td>
                    </tr>
                  `);
                  $("#accordionResi").html(`
                    <div class="empty-state">
                      <i class="bi bi-inbox empty-state-icon"></i>
                      <h5>Belum ada resi</h5>
                      <p class="text-muted">Tidak ada resi untuk ditampilkan</p>
                    </div>
                  `);
                  $("#infoKode, #infoTujuan, #infoTanggal").text("-");
                  $("#infoStatus").text("-").removeClass("badge-success badge-warning");
                  $("#deleteResi").hide();
                }
              }
            } else {
              alert("Gagal menghapus resi: " + response.message);
            }
          },
          error: function(xhr) {
            $('#modalConfirmDelete').modal('hide');
            console.error("Gagal menghapus resi:", xhr.responseText);
            alert("Gagal menghapus resi: " + (xhr.responseJSON?.message || xhr.statusText));
          }
        });
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<style>
    :root {
      --primary-bg: #f0f4f8;
      --card-bg: #ffffff;
      --primary-action: #007bff;
      --gradient-start: #e3f2fd;
      --gradient-end: #e1f5fe;
      --primary-text: #003366;
      --secondary-text: #4a4a4a;
      --tertiary-text: #555;
      --minimal-action: #6c757d;
      --home-button-border: #dee2e6;
    }

    body {
      background-color: var(--primary-bg);
      color: var(--primary-text);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .navbar-brand {
      font-weight: 600;
      color: var(--primary-text);
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      background-color: var(--card-bg);
    }

    .card:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    }

    .card-header {
      background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
      border-bottom: none;
      border-radius: 12px 12px 0 0 !important;
      padding: 1.25rem;
      font-weight: 600;
      color: var(--primary-text);
    }

    .card-body {
      color: var(--tertiary-text);
    }

    .card-body strong {
      color: var(--primary-text);
    }

    .btn-primary {
      background-color: var(--primary-action);
      border-color: var(--primary-action);
      padding: 0.5rem 1.25rem;
      font-weight: 500;
    }

    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }

    .btn-outline-primary {
      color: var(--primary-action);
      border-color: var(--primary-action);
    }

    .btn-outline-primary:hover {
      background-color: var(--primary-action);
      color: white;
    }

    .badge-status {
      min-width: 80px;
      padding: 0.5rem;
      font-weight: 500;
      font-size: 0.85rem;
      border-radius: 50px;
    }

    .badge-warning {
      background-color: #fff3cd;
      color: #856404;
    }

    .badge-success {
      background-color: #d4edda;
      color: #155724;
    }

    .table {
      border-radius: 12px;
      overflow: hidden;
    }

    .table thead {
      background-color: var(--primary-text);
      color: white;
    }

    .table th {
      font-weight: 500;
      padding: 1rem;
    }

    .table td {
      padding: 0.75rem 1rem;
      vertical-align: middle;
      color: var(--tertiary-text);
    }

    .table-hover tbody tr:hover {
      background-color: rgba(0, 123, 255, 0.05);
    }

    .modal-header {
      background-color: var(--primary-action);
      color: white;
      border-bottom: none;
    }

    .modal-footer {
      border-top: none;
    }

    .form-control:focus {
      border-color: var(--primary-action);
      box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }

    .nav-button {
      border-radius: 8px;
      padding: 0.5rem 1rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .nav-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .action-buttons .btn {
      padding: 0.375rem 0.75rem;
      border-radius: 8px;
    }

    .empty-state {
      padding: 3rem 0;
      text-align: center;
      color: var(--secondary-text);
    }

    .empty-state-icon {
      font-size: 3rem;
      color: var(--minimal-action);
      margin-bottom: 1rem;
    }

    .home-button {
      background-color: var(--card-bg);
      color: var(--primary-action);
      padding: 8px 12px;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      font-size: 1rem;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      border: 2px solid var(--home-button-border);
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      animation: slideInUp 0.6s ease-out;
      position: fixed;
      top: 24px;
      left: 24px;
      z-index: 1050;
    }

    .home-button:hover {
      background-color: var(--primary-action);
      color: var(--card-bg);
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

    #resultOverlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.4);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }

    #resultOverlay .box {
      background: var(--card-bg);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
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
      width: 40px;
      height: 40px;
      border: 5px solid #ccc;
      border-top-color: var(--primary-action);
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    #resultOverlay .checkmark {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      border: 4px solid var(--primary-action);
      position: relative;
      display: none;
      animation: scale-in 0.25s ease forwards;
    }

    #resultOverlay .checkmark::after {
      content: '';
      position: absolute;
      left: 16px;
      top: 8px;
      width: 16px;
      height: 32px;
      border-right: 4px solid var(--primary-action);
      border-bottom: 4px solid var(--primary-action);
      transform: rotate(45deg);
    }

    #resultOverlay h3 {
      margin: 0;
      display: none;
      color: var(--primary-text);
    }

    #resultOverlay p {
      margin: 0;
      display: none;
      color: var(--tertiary-text);
    }

    @keyframes scale-in {
      0% {
        transform: scale(0);
        opacity: 0;
      }
      100% {
        transform: scale(1);
        opacity: 1;
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-5px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    .print-only {
      display: none;
    }

    .progress {
      height: 8px;
      border-radius: 4px;
      background-color: #e9ecef;
    }

    .progress-bar {
      background-color: var(--primary-action);
    }

    .dropdown-menu {
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-height: 300px;
      overflow-y: auto;
    }

    .dropdown-item:hover {
      background-color: rgba(0, 123, 255, 0.05);
    }

    #adminChecklistNotif {
      display: none;
      position: fixed;
      top: 30px;
      right: 30px;
      left: auto;
      transform: translateX(120%);
      background: #fff3cd;
      color: #856404;
      border: 1px solid #ffeeba;
      border-radius: 8px;
      padding: 14px 32px;
      font-size: 1.1rem;
      font-weight: 500;
      z-index: 11000;
      box-shadow: 0 4px 16px rgba(0,0,0,0.08);
      opacity: 0;
      transition: transform 0.4s cubic-bezier(.4,0,.2,1), opacity 0.4s cubic-bezier(.4,0,.2,1);
    }
    #adminChecklistNotif.active {
      display: block;
      transform: translateX(0);
      opacity: 1;
    }

    @media (max-width: 576px) {
      .home-button {
        padding: 6px 10px;
        font-size: 0.9rem;
      }
    }

    @media (min-width: 300px) and (max-width: 400px) {
      .accordion-button {
        font-size: 0.9rem;
        padding: 0.75rem 1rem;
      }
      .accordion-body {
        padding: 0.75rem 1rem;
      }
    }
</style>