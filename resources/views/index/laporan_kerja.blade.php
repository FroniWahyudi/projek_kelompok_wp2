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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Css Custom -->
  <link rel="stylesheet" href="{{ asset('css/laporan_kerja.css') }}">
  <!-- CSS untuk Slide-Up Modal -->
  <style>
    .profile-slide-modal {
      display: none;
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 2000;
      height: 100%;
      align-items: flex-end;
    }

    .profile-slide-modal-content {
      background-color: white;
      width: 100%;
      padding: 20px;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
      transform: translateY(100%);
      transition: transform 0.3s ease-in-out;
    }

    .profile-slide-modal.active {
      display: flex;
    }

    .profile-slide-modal.active .profile-slide-modal-content {
      transform: translateY(0);
    }

    .modal-option {
      display: block;
      padding: 15px;
      text-align: center;
      font-size: 16px;
      color: #333;
      text-decoration: none;
      border-bottom: 1px solid #eee;
    }

    .modal-option:last-child {
      border-bottom: none;
    }

    .modal-option:hover {
      background-color: #f5f5f5;
    }
  </style>
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

    <div class="row gx-4 card-list">
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
          <div class="card-body p-0 card-item">
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

  @include('components.profile-modal')

  <!-- Tambahkan navigasi bawah -->
  <nav class="mobile-bottom-nav">
    @if (auth()->user()->role === 'Leader' || (auth()->user()->role === 'Operator' && str_contains(auth()->user()->job_descriptions, 'Inventory checker')))
      <a href="{{ route('laporan.index') }}" class="nav-link active">
        <i class="bi bi-journal-text me-1"></i>
        <span>Resi Harian</span>
      </a>
    @else
      <a href="{{ route('slips.index') }}" class="nav-link">
        <i class="fas fa-file-invoice-dollar"></i>
        <span>Slip Gaji</span>
      </a>
    @endif
    <a href="{{ route('dashboard') }}" class="nav-link">
      <i class="fas fa-home" style="margin-top: 12px;"></i>
      <span style="margin-top: 3px;">Home</span>
    </a>
    <a href="#" class="nav-link profile-link" id="profileLink">
      <img src="{{ auth()->user()->photo_url ?? '/default.jpg' }}" 
           class="profile-img-mobile" 
           alt="Profile Image">
      <span>Profil</span>
    </a>
  </nav>

  <!-- Modal Slide-Up untuk Profil -->
  <div id="profileSlideUpModal" class="profile-slide-modal">
    <div class="profile-slide-modal-content">
      <a href="#" class="modal-option" data-bs-toggle="modal" data-bs-target="#profileModal">Detail Profil</a>
      <a href="{{ url('edit_profil/' . auth()->user()->id) }}" class="modal-option">Pengaturan Profil</a>
      <a href="{{ route('logout') }}" class="modal-option" onclick="event.preventDefault(); confirmLogout();">Logout</a>
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

      // JavaScript untuk menangani Slide-Up Modal pada mobile-bottom-nav
      $('#profileLink').on('click', function(e) {
        e.preventDefault();
        showProfileSlideUpModal();
      });

      $('#profileSlideUpModal').on('click', function(e) {
        if (e.target === this) {
          hideProfileSlideUpModal();
        }
      });

      $('#profileSlideUpModal .modal-option').on('click', function() {
        hideProfileSlideUpModal();
      });
    });

    // Fungsi untuk menampilkan modal
    function showProfileSlideUpModal() {
      const modal = document.getElementById('profileSlideUpModal');
      modal.classList.add('active');
    }

    // Fungsi untuk menyembunyikan modal
    function hideProfileSlideUpModal() {
      const modal = document.getElementById('profileSlideUpModal');
      modal.classList.remove('active');
    }

   function confirmLogout() {
      Swal.fire({
        title: 'Apakah Anda yakin ingin logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, logout',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "{{ route('logout') }}";
        }
      });
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>