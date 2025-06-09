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

    <!-- [TAMBAHKAN KODE DI SINI: Tombol Resi hari ini] -->
    <!-- @auth
        @if(auth()->user()->role === 'Leader' || (auth()->user()->role === 'Operator' && str_contains(auth()->user()->job_descriptions, 'Inventory checker')))
          <div class="mb-4 d-print-none">
            <a href="{{ route('laporan.index') }}" class="btn btn-outline-dark">
              <i class="bi bi-journal-text me-1"></i> Resi hari ini
            </a>
          </div>
        @endif
    @endauth -->
    <!-- [END TAMBAHKAN KODE] -->

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
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th class="text-center">Checklist</th>
                    <!-- [TAMBAHKAN KODE DI SINI: Kolom Dicek Oleh] -->
                    <th class="text-center">Dicek Oleh</th>
                    <!-- [END TAMBAHKAN KODE] -->
                  </tr>
                </thead>
                <tbody id="resiTableBody"></tbody>
              </table>
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
    // Perbaikan di sini: Gunakan Blade untuk mengkonversi ke boolean JS
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

      const tbody = $("#resiTableBody").empty();

      if (d.items && d.items.length > 0) {
        d.items.forEach((it, i) => {
          const isDisabled = d.status === 'Selesai' ? 'disabled' : '';
          const isChecked = d.status === 'Selesai' || it.is_checked ? 'checked' : '';
          tbody.append(`
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
              <!-- [TAMBAHKAN KODE DI SINI: Kolom Dicek Oleh] -->
              <td data-label="Dicek Oleh" class="text-center" id="checked-by-${it.id ?? ''}">${it.checked_by ?? '-'}</td>
              <!-- [END TAMBAHKAN KODE] -->
            </tr>
          `);
        });
      } else {
        tbody.append(`
          <tr>
            <td colspan="5" class="empty-state">
              <i class="bi bi-inbox empty-state-icon"></i>
              <h5>Belum ada item</h5>
              <p class="text-muted">Tidak ada item untuk ditampilkan</p>
            </td>
          </tr>
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
      const all = $(".checklist").length;
      const done = $(".checklist:checked").length;
      const pct = all ? Math.round(done / all * 100) : 0;
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
              kode: newResi.kode,
              tujuan: newResi.tujuan,
              tanggal: newResi.tanggal,
              status: newResi.status,
              items: newResi.items
            };
            buildDropdown();
            renderResi(key);
          })
          .fail(xhr => {
            alert("Gagal membuat resi: " + (xhr.responseJSON?.message || xhr.statusText));
          });
      });

      // [PERBAIKAN DI SINI: Event Handler untuk Checklist]
      $(document).on("change", ".checklist", function() {
        // Gunakan variabel userHasInventoryChecker yang sudah didefinisikan
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
              // Update data di resiData
              const kode = $("#infoKode").text();
              const key = Object.keys(resiData).find(k => resiData[k].kode === kode);
              if (key) {
                const item = resiData[key].items.find(it => it.id == id);
                if (item) {
                  item.is_checked = isChecked;
                  item.checked_by = response.checked_by;
                }
              }
              // Update kolom Dicek Oleh
              $(`#checked-by-${id}`).text(response.checked_by || '-');
              updateProgress();
              showSuccess("Berhasil!", "Checklist diperbarui.");
            } else {
              alert(response.message);
              $(this).prop('checked', !isChecked); // Undo change
            }
          })
          .fail(xhr => {
            alert("Gagal memperbarui checklist: " + (xhr.responseJSON?.message || xhr.statusText));
            $(this).prop('checked', !isChecked); // Undo change
          });
      });
      // [END PERBAIKAN]

      // Responsive table labels
      if (window.innerWidth <= 768) {
        const headers = ['No', 'Item', 'Qty', 'Checklist', 'Dicek Oleh'];
        document.querySelectorAll('#resiTableBody td').forEach((td, index) => {
          const colIndex = index % headers.length;
          td.setAttribute('data-label', headers[colIndex]);
        });
      }

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
