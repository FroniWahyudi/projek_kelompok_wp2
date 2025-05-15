<?php
// Simulasi role user (bisa "HR" atau "Karyawan")
$role = 'HR';

// Data statis pengajuan cuti
$requests = [
    [
        'id' => 1,
        'name' => 'Budi Santoso',
        'tanggal_pengajuan' => '2023-06-12',
        'tanggal_mulai' => '2023-06-15',
        'tanggal_selesai' => '2023-06-17',
        'lama_cuti' => 3,
        'alasan' => 'Perlu menghadiri acara keluarga di luar kota yang sangat penting.',
        'status' => 'Menunggu',
    ],
    [
        'id' => 2,
        'name' => 'Siti Rahayu',
        'tanggal_pengajuan' => '2023-06-10',
        'tanggal_mulai' => '2023-06-14',
        'tanggal_selesai' => '2023-06-14',
        'lama_cuti' => 1,
        'alasan' => 'Keperluan medis.',
        'status' => 'Disetujui',
    ],
    [
        'id' => 3,
        'name' => 'Ahmad Fauzi',
        'tanggal_pengajuan' => '2023-06-08',
        'tanggal_mulai' => '2023-06-10',
        'tanggal_selesai' => '2023-06-14',
        'lama_cuti' => 5,
        'alasan' => 'Liburan keluarga.',
        'status' => 'Ditolak',
    ],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pengajuan Cuti (Statis)</title>

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { 
      background: #f2f4f8; 
      padding-bottom: 60px; 
    }
    .card-request { 
      margin-bottom: 1rem; 
      border-radius: .75rem; 
      box-shadow: 0 2px 6px rgba(0,0,0,0.05); 
    }
    .badge-status { font-size: .75rem; }
    .fab { 
      position: fixed; 
      right: 1rem; 
      bottom: 4.5rem; 
      width: 56px; 
      height: 56px; 
      border-radius: 50%; 
    }
    .header-mobile { 
      padding: .75rem 1rem; 
      background: #fff; 
      box-shadow: 0 1px 4px rgba(0,0,0,0.1); 
      position: sticky; 
      top: 0; 
      z-index: 10;
    }
    .bottom-nav {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      height: 56px;
      background: #fff;
      box-shadow: 0 -1px 4px rgba(0,0,0,0.1);
      display: flex;
    }
    .bottom-nav .nav-item {
      flex: 1;
      text-align: center;
      padding: 6px 0;
      color: #666;
      font-size: .75rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .bottom-nav .nav-item .bi { font-size: 1.25rem; }
    .bottom-nav .nav-item.active { color: #0d6efd; }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="header-mobile d-flex align-items-center">
    <a href="#" class="me-3 text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
    <h5 class="mb-0">Pengajuan Cuti</h5>
  </div>

  <!-- List Requests -->
  <div class="container py-3">
    <?php $no = 1; foreach($requests as $r): 
      $badgeClass = $r['status']=='Disetujui' 
                    ? 'success' 
                    : ($r['status']=='Ditolak' ? 'danger' : 'warning');
    ?>
      <div class="card card-request p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <small class="text-muted">
            #<?= $no++ ?><?php if($role==='HR'):?> – <?= $r['name'] ?><?php endif?>
          </small>
          <span class="badge bg-<?= $badgeClass ?> text-dark badge-status">
            <?= $r['status'] ?>
          </span>
        </div>
        <div class="row small mb-2">
          <div class="col-6"><strong>Pengajuan</strong><br><?= $r['tanggal_pengajuan'] ?></div>
          <div class="col-6"><strong>Lama</strong><br><?= $r['lama_cuti'] ?> hari</div>
          <div class="col-6 mt-2"><strong>Mulai</strong><br><?= $r['tanggal_mulai'] ?></div>
          <div class="col-6 mt-2"><strong>Selesai</strong><br><?= $r['tanggal_selesai'] ?></div>
        </div>
        <p class="small mb-3"><strong>Alasan:</strong><br><?= nl2br($r['alasan']) ?></p>

        <div class="d-flex gap-2">
          <?php if($role==='HR' && $r['status']=='Menunggu'): ?>
            <button class="btn btn-sm btn-outline-success flex-fill">
              <i class="bi bi-check-circle"></i> Setujui
            </button>
            <button class="btn btn-sm btn-outline-danger flex-fill">
              <i class="bi bi-x-circle"></i> Tolak
            </button>
          <?php endif; ?>

          <button class="btn btn-sm btn-outline-secondary flex-fill">
            <i class="bi bi-trash"></i> Hapus
          </button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Floating Add Button -->
  <button class="btn btn-primary fab shadow">
    <i class="bi bi-plus fs-4"></i>
  </button>

  <!-- Modal (kosong, hanya tampilan) -->
  <div class="modal fade" id="cutiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3 p-3 text-center">
        <p>Form pengajuan cuti (statik)</p>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Bottom Navigation -->
<nav class="bottom-nav">
  <a href="mobile_dashboard.php" class="nav-item active text-decoration-none">
    <i class="bi bi-house-fill"></i>
    Home
  </a>
  <a href="explore.php" class="nav-item text-decoration-none">
    <i class="bi bi-search"></i>
    Explore
  </a>
  <a href="profile.php" class="nav-item text-decoration-none">
    <i class="bi bi-person-fill"></i>
    Profile
  </a>
</nav>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
