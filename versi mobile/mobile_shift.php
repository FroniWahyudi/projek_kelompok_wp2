<?php
// dashboard_shift.php
// Static data karyawan
$employees = [
    ['ini'=>'AR','name'=>'Ahmad Rizky','date'=>'Minggu, 15 Oktober 2023','shift'=>'pagi'],
    ['ini'=>'BS','name'=>'Budi Santoso','date'=>'Minggu, 15 Oktober 2023','shift'=>'sore'],
    ['ini'=>'CD','name'=>'Citra Dewi','date'=>'Senin, 16 Oktober 2023','shift'=>'sore'],
    ['ini'=>'DP','name'=>'Dian Purnama','date'=>'Senin, 16 Oktober 2023','shift'=>'pagi'],
    ['ini'=>'EY','name'=>'Eko Yulianto','date'=>'Selasa, 17 Oktober 2023','shift'=>'sore'],
    ['ini'=>'FA','name'=>'Farah Aulia','date'=>'Selasa, 17 Oktober 2023','shift'=>'pagi'],
    ['ini'=>'GN','name'=>'Gita Nabila','date'=>'Rabu, 18 Oktober 2023','shift'=>'sore'],
    ['ini'=>'HW','name'=>'Hendra Wijaya','date'=>'Rabu, 18 Oktober 2023','shift'=>'pagi'],
    ['ini'=>'IM','name'=>'Intan Maharani','date'=>'Kamis, 19 Oktober 2023','shift'=>'sore'],
    ['ini'=>'JP','name'=>'Joko Prabowo','date'=>'Kamis, 19 Oktober 2023','shift'=>'pagi'],
];
$filter = $_GET['filter'] ?? 'all';
function btnClass($type,$filter){return $type===$filter?'btn btn-primary btn-sm':'btn btn-outline-primary btn-sm';}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Shift & Jadwal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body{background:#f8f9fa;padding-bottom:80px;}
    .shift-badge{padding:5px 10px;border-radius:15px;font-size:.8rem;color:#fff;}
    .shift-pagi{background:#0dcaf0;}.shift-sore{background:#ffc107;}.shift-malam{background:#212529;}
    .bottom-nav{position:fixed;bottom:0;left:0;right:0;background:#fff;border-top:1px solid #dee2e6;display:flex;justify-content:space-around;padding:10px 0;z-index:1000;}
    .bottom-nav .nav-item{text-align:center;font-size:.9rem;color:#6c757d;}
    .bottom-nav .nav-item.active{color:#0d6efd;}
    .bottom-nav .nav-item i{font-size:1.2rem;display:block;}
    .filter-btns .btn{border-radius:20px;}
    .card{border-radius:15px;}
    .avatar-circle{width:40px;height:40px;border-radius:50%;background:#e9ecef;display:flex;align-items:center;justify-content:center;font-weight:bold;color:#333;margin-right:10px;}
  </style>
</head>
<body>
  <div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5>Shift & Jadwal Karyawan</h5>
      <a href="#" class="btn btn-primary btn-sm">+ Jadwal Baru</a>
    </div>

    <div class="filter-btns mb-3 d-flex gap-2">
      <a href="?filter=all" class="<?=btnClass('all',$filter)?>">Semua</a>
      <a href="?filter=pagi" class="<?=btnClass('pagi',$filter)?>">Pagi</a>
      <a href="?filter=sore" class="<?=btnClass('sore',$filter)?>">Sore</a>
    </div>

    <div id="list" class="row g-3">
      <?php foreach($employees as $e): if($filter==='all'||$e['shift']===$filter): ?>
      <div class="col-12 card p-3 d-flex flex-row align-items-center justify-content-between" data-shift="<?=$e['shift']?>">
        <div class="d-flex align-items-center">
          <div class="avatar-circle"><?=htmlspecialchars($e['ini'])?></div>
          <div>
            <div class="fw-bold"><?=htmlspecialchars($e['name'])?></div>
            <small class="text-muted"><?=htmlspecialchars($e['date'])?></small>
          </div>
        </div>
        <div class="text-end">
          <span class="shift-badge shift-<?=$e['shift']?>">Shift <?=ucfirst($e['shift'])?></span>
          <div class="mt-2 d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm">Edit</button>
            <button class="btn btn-outline-danger btn-sm">Hapus</button>
          </div>
        </div>
      </div>
      <?php endif; endforeach; ?>
    </div>
  </div>

  <nav class="bottom-nav">
    <a href="mobile_dashboard.php" class="nav-item active text-decoration-none"><i class="bi bi-house-fill"></i>Home</a>
    <a href="#" class="nav-item text-decoration-none"><i class="bi bi-search"></i>Explore</a>
    <a href="#" class="nav-item text-decoration-none"><i class="bi bi-person-fill"></i>Profile</a>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
