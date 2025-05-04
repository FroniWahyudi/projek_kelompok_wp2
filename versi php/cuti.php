<?php
session_start();

// Koneksi database
$host   = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'naga_hytam';
$conn = new mysqli($host, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

// Pastikan user sudah login
if (!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];

// PROSES CREATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $tglMulai   = $conn->real_escape_string($_POST['tgl_mulai']);
    $tglSelesai = $conn->real_escape_string($_POST['tgl_selesai']);
    $alasan     = $conn->real_escape_string($_POST['alasan']);

    // Hitung lama cuti (hari kalender)
    $lama = (new DateTime($tglMulai))
        ->diff(new DateTime($tglSelesai))
        ->days + 1;

    // Cek sisa cuti
    $tahun = date('Y', strtotime($tglMulai));
    $sisaQ = $conn->query("
        SELECT cuti_sisa
        FROM sisa_cuti
        WHERE user_id = $user_id
          AND tahun = $tahun
    ");
    $sisa = $sisaQ->num_rows
        ? intval($sisaQ->fetch_assoc()['cuti_sisa'])
        : 0;

    if ($lama <= $sisa) {
        // Insert permohonan cuti
        $conn->query("
            INSERT INTO cuti_requests
                (user_id, tanggal_pengajuan, tanggal_mulai, tanggal_selesai, lama_cuti, alasan)
            VALUES
                ($user_id, CURDATE(), '$tglMulai', '$tglSelesai', $lama, '$alasan')
        ");
        $newId = $conn->insert_id;

        // Catat log
        $conn->query("
            INSERT INTO cuti_logs
                (cuti_request_id, aksi, oleh_user_id, keterangan)
            VALUES
                ($newId, 'Dibuat', $user_id, 'Pengajuan dibuat')
        ");

        // Update cuti_terpakai
        $conn->query("
            INSERT INTO sisa_cuti (user_id, tahun)
            VALUES ($user_id, $tahun)
            ON DUPLICATE KEY UPDATE
                cuti_terpakai = cuti_terpakai + $lama
        ");
    } else {
        $error = "Sisa cuti Anda hanya $sisa hari, permintaan $lama hari.";
    }
}

// PROSES DELETE
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Kurangi cuti_terpakai sebelum hapus
    $r = $conn->query("
        SELECT user_id, lama_cuti, tanggal_mulai
        FROM cuti_requests
        WHERE id = $id
    ");
    if ($row = $r->fetch_assoc()) {
        $yr = date('Y', strtotime($row['tanggal_mulai']));
        $conn->query("
            UPDATE sisa_cuti
            SET cuti_terpakai = cuti_terpakai - {$row['lama_cuti']}
            WHERE user_id = {$row['user_id']}
              AND tahun = $yr
        ");
    }

    // Hapus log dan request
    $conn->query("DELETE FROM cuti_logs WHERE cuti_request_id = $id");
    $conn->query("DELETE FROM cuti_requests WHERE id = $id");

    header("Location: cuti.php");
    exit;
}

// Ambil role dan siapkan query
$qr   = $conn->query("SELECT role FROM users WHERE id = $user_id");
$role = $qr->fetch_assoc()['role'];


// PROSES DELETE
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);

  // Kurangi cuti_terpakai sebelum hapus
  $r = $conn->query("
      SELECT user_id, lama_cuti, tanggal_mulai
      FROM cuti_requests
      WHERE id = $id
  ");
  if ($row = $r->fetch_assoc()) {
      $yr = date('Y', strtotime($row['tanggal_mulai']));
      $conn->query("
          UPDATE sisa_cuti
          SET cuti_terpakai = cuti_terpakai - {$row['lama_cuti']}
          WHERE user_id = {$row['user_id']}
            AND tahun = $yr
      ");
  }

  // Hapus log dan request
  $conn->query("DELETE FROM cuti_logs WHERE cuti_request_id = $id");
  $conn->query("DELETE FROM cuti_requests WHERE id = $id");

  header("Location: cuti.php");
  exit;
}

// PROSES ACCEPT (HR)
if ($role === 'HR' && isset($_GET['accept'])) {
  $id = intval($_GET['accept']);

  // Update status di cuti_requests
  $conn->query("
      UPDATE cuti_requests
      SET status = 'Disetujui',
          disetujui_oleh    = $user_id,
          tanggal_disetujui = CURDATE()
      WHERE id = $id
  ");

  // Catat log
  $conn->query("
      INSERT INTO cuti_logs
          (cuti_request_id, aksi, oleh_user_id, keterangan)
      VALUES
          ($id, 'Disetujui', $user_id, 'Diterima oleh HR')
  ");

  header('Location: cuti.php');
  exit;
}



// === PROSES UPDATE (HR) ===
if ($role === 'HR' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
$id       = intval($_POST['id']);
$status   = $conn->real_escape_string($_POST['status']);
$catatan  = $conn->real_escape_string($_POST['catatan']);

// Update cuti_requests
$conn->query("
    UPDATE cuti_requests
    SET status = '$status',
        disetujui_oleh = $user_id,
        tanggal_disetujui = CURDATE(),
        catatan_hr = '$catatan'
    WHERE id = $id
");

// Simpan log
$conn->query("
    INSERT INTO cuti_logs
        (cuti_request_id, aksi, oleh_user_id, keterangan)
    VALUES
        ($id, '$status', $user_id, '$catatan')
");

header('Location: cuti.php');
exit;
}


// Ambil role dan siapkan query
$qr   = $conn->query("SELECT role FROM users WHERE id = $user_id");
$role = $qr->fetch_assoc()['role'];

if ($role === 'HR') {
  $sql = "
      SELECT r.*, u.name
      FROM cuti_requests r
      JOIN users u ON r.user_id = u.id
      ORDER BY FIELD(r.status,'Menunggu','Disetujui','Ditolak'), r.tanggal_pengajuan DESC
  ";
} else {
  $sql = "
      SELECT r.*, u.name
      FROM cuti_requests r
      JOIN users u ON r.user_id = u.id
      WHERE r.user_id = $user_id
      ORDER BY r.tanggal_pengajuan DESC
  ";
}

$rs = $conn->query($sql);


if ($role === 'HR') {
    $sql = "
        SELECT r.*, u.name
        FROM cuti_requests r
        JOIN users u ON r.user_id = u.id
        ORDER BY FIELD(r.status,'Menunggu','Disetujui','Ditolak'), r.tanggal_pengajuan DESC
    ";
} else {
    $sql = "
        SELECT r.*, u.name
        FROM cuti_requests r
        JOIN users u ON r.user_id = u.id
        WHERE r.user_id = $user_id
        ORDER BY r.tanggal_pengajuan DESC
    ";
}

$rs = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan Cuti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .nav-button { margin-bottom: 1rem; }
        .card { border: none; border-radius: 0.5rem; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .badge-status { min-width: 60px; }
    </style>
</head>
<body>
<div class="container py-4">
    <a href="dashboard.php" class="btn btn-outline-dark nav-button">
        <i class="bi bi-house-door me-1"></i> Home
    </a>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Pengajuan Cuti</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cutiModal">
            <i class="bi bi-plus-circle me-1"></i> Ajukan Cuti
        </button>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <?php if ($role === 'HR'): ?><th>Nama</th><?php endif; ?>
                            <th>Tgl Pengajuan</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Lama</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
$no = 1;
while ($r = $rs->fetch_assoc()):
    $badge = $r['status'] == 'Disetujui'
        ? 'success'
        : ($r['status'] == 'Ditolak' ? 'danger' : 'warning');
?>
<tr>
    <td><?= $no++ ?></td>
    <?php if ($role === 'HR'): ?>
        <td><?= htmlspecialchars($r['name']) ?></td>
    <?php endif; ?>
    <td><?= $r['tanggal_pengajuan'] ?></td>
    <td><?= $r['tanggal_mulai'] ?></td>
    <td><?= $r['tanggal_selesai'] ?></td>
    <td><?= $r['lama_cuti'] ?></td>
    <td><?= htmlspecialchars($r['alasan']) ?></td>
    <td>
        <span class="badge bg-<?= $badge ?> text-dark badge-status">
            <?= $r['status'] ?>
        </span>
    </td>
    <td class="d-flex gap-1">
        <?php if ($role === 'HR' && $r['status'] === 'Menunggu'): ?>
            <!-- Tombol Setujui -->
            <a href="?accept=<?= $r['id'] ?>"
               class="btn btn-sm btn-outline-success"
               onclick="return confirm('Setujui pengajuan ini?')">
                <i class="bi bi-check-circle"></i>
            </a>
        <?php endif; ?>

        <!-- Tombol Hapus -->
        <a href="?delete=<?= $r['id'] ?>"
           class="btn btn-sm btn-outline-danger"
           onclick="return confirm('Hapus pengajuan ini?')">
            <i class="bi bi-trash"></i>
        </a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- Modal Pengajuan -->
    <div class="modal fade" id="cutiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Pengajuan Cuti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" id="tgl_mulai" name="tgl_mulai" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" id="tgl_selesai" name="tgl_selesai" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan</label>
                            <textarea id="alasan" name="alasan" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
