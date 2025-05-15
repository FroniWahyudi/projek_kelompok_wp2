<?php
// Data statis
$users = [
  ['id'=>1,'name'=>'Alice Putri','role'=>'HR','email'=>'alice.putri@nagahtam.co.id','phone'=>'+6281234567890','photo_url'=>'img/nami.jpeg','bio'=>'Mengelola administrasi karyawan.','alamat'=>'Jl. Merdeka No. 10, Jakarta Pusat','created_at'=>'2025-05-01 19:15:16'],
  ['id'=>2,'name'=>'Budi Santoso','role'=>'Leader','email'=>'budi.santoso@nagahtam.co.id','phone'=>'+6281398765432','photo_url'=>'img/zoro.jpeg','bio'=>'Memantau operator lapangan.','alamat'=>'Jl. Sudirman Kav. 12, Jakarta Selatan','created_at'=>'2025-05-01 19:15:16'],
  ['id'=>3,'name'=>'Sanji','role'=>'Leader','email'=>'sanji@nagahtam.co.id','phone'=>'+6281398765432','photo_url'=>'img/sanji.jpeg','bio'=>'Memantau operator lapangan.','alamat'=>'Jl. Pahlawan No. 3, Surabaya','created_at'=>'2025-05-01 19:15:16'],
  ['id'=>4,'name'=>'Sutoyo dono','role'=>'Manajer','email'=>'sutoyo@nagahtam.co.id','phone'=>'+6281212345678','photo_url'=>'img/sutoyo.jpg','bio'=>'Pengambilan keputusan strategis.','alamat'=>'Jl. Diponegoro No. 20, Semarang','created_at'=>'2025-05-02 05:41:16'],
  ['id'=>6,'name'=>'Ahmad Yusuf','role'=>'Karyawan','email'=>'ahmad.yusuf@nagahtam.co.id','phone'=>'+6281234567890','photo_url'=>'img/ahmad_yusuf.jpg','bio'=>'Administrasi karyawan.','alamat'=>'Jl. Gajah Mada No. 15, Yogyakarta','created_at'=>'2025-05-02 06:20:02'],
  ['id'=>7,'name'=>'Wanda','role'=>'Karyawan','email'=>'wanda@nagahtam.co.id','phone'=>'+6281398765432','photo_url'=>'img/wanda.jpg','bio'=>'Supervisor operasional.','alamat'=>'Jl. Pemuda No. 7, Bekasi','created_at'=>'2025-05-02 06:20:02'],
  ['id'=>8,'name'=>'Agus','role'=>'Karyawan','email'=>'agus@nagahtam.co.id','phone'=>'+6281398765432','photo_url'=>'img/budi.jpg','bio'=>'Operator produksi.','alamat'=>'Jl. Raya Bogor No. 45, Depok','created_at'=>'2025-05-02 06:20:02'],
  ['id'=>9,'name'=>'Lina Marlina','role'=>'Karyawan','email'=>'lina.marlina@nagahtam.co.id','phone'=>'+6281212345678','photo_url'=>'img/lina.jpg','bio'=>'Manager divisi.','alamat'=>'Jl. Sultan Iskandar Muda No. 8, Medan','created_at'=>'2025-05-02 06:20:02'],
  ['id'=>10,'name'=>'Rudi Hartanto','role'=>'Karyawan','email'=>'rudi.hartono@nagahtam.co.id','phone'=>'+6281356789012','photo_url'=>'img/rudi.jpg','bio'=>'Staf gudang.','alamat'=>'Jl. Bumi Raya No. 9, Palembang','created_at'=>'2025-05-02 06:20:02'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Daftar Karyawan</title>
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background: #f2f4f8; padding-bottom: 60px; }
    .header { position: sticky; top:0; background:#fff; z-index:10;
      padding:.75rem 1rem; box-shadow:0 1px 4px rgba(0,0,0,0.1);
    }
    .card-user { margin-bottom:1rem; border-radius:.75rem;
      box-shadow:0 2px 6px rgba(0,0,0,0.05);
    }
    .fab { position:fixed; right:1rem; bottom:4.5rem;
      width:56px;height:56px;border-radius:50%;
    }
    .bottom-nav { position:fixed; bottom:0; left:0; right:0;
      height:56px; background:#fff; box-shadow:0 -1px 4px rgba(0,0,0,0.1);
      display:flex;
    }
    .bottom-nav .nav-item { flex:1; text-align:center;
      padding:6px 0; color:#666; font-size:.75rem;
      display:flex; flex-direction:column; align-items:center;
      justify-content:center;
    }
    .bottom-nav .nav-item.active { color:#0d6efd; }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="header d-flex align-items-center">
    <a href="#" class="me-3 text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
    <h5 class="mb-0">Daftar Karyawan</h5>
  </div>

  <!-- Search Bar -->
  <div class="container py-2">
    <div class="input-group mb-3">
      <span class="input-group-text"><i class="bi bi-search"></i></span>
      <input id="searchInput" type="text" class="form-control" placeholder="Cari nama atau jabatan…">
    </div>
  </div>

  <!-- User Cards -->
  <div class="container" id="userList">
    <?php foreach($users as $u): ?>
      <div class="card card-user p-3" data-name="<?= strtolower($u['name']) ?>" data-role="<?= strtolower($u['role']) ?>">
        <div class="d-flex">
          <img src="<?= $u['photo_url'] ?>" class="rounded-circle me-3" width="48" height="48" alt="">
          <div class="flex-fill">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="mb-0"><?= $u['name'] ?></h6>
              <span class="badge bg-light text-dark"><?= $u['role'] ?></span>
            </div>
            <div class="small text-primary">
              <i class="bi bi-envelope"></i>
              <a href="mailto:<?= $u['email'] ?>"><?= $u['email'] ?></a>
            </div>
            <div class="small text-primary">
              <i class="bi bi-telephone"></i>
              <a href="tel:<?= $u['phone'] ?>"><?= $u['phone'] ?></a>
            </div>
            <p class="small mb-1"><?= $u['bio'] ?></p>
            <p class="small text-muted mb-1"><?= $u['alamat'] ?></p>
            <p class="small text-muted">Joined <?= date("F j, Y", strtotime($u['created_at'])) ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Floating Add Button -->
  <button class="btn btn-primary fab shadow">
    <i class="bi bi-plus fs-4"></i>
  </button>

  <!-- Bottom Navigation -->
  <nav class="bottom-nav">
    <a href="mobile_dashboard.php" class="nav-item"><i class="bi bi-house-fill"></i><span>Home</span></a>
    <a href="#" class="nav-item active"><i class="bi bi-list-ul"></i><span>Directory</span></a>
    <a href="#" class="nav-item"><i class="bi bi-person-fill"></i><span>Profile</span></a>
  </nav>

  <!-- Bootstrap JS & simple filter script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('searchInput').addEventListener('input', function(){
      const q = this.value.toLowerCase();
      document.querySelectorAll('#userList .card-user').forEach(card=>{
        const name = card.getAttribute('data-name');
        const role = card.getAttribute('data-role');
        card.style.display = (name.includes(q)||role.includes(q)) ? 'block' : 'none';
      });
    });
  </script>
</body>
</html>
