<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Feedback Pegawai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
  >
</head>
<body>
  <div class="container mt-5">
    <!-- Tombol Home -->
    <a href="dashboard" class="btn btn-outline-dark mb-4">
      <i class="bi bi-house-door me-1"></i> Home
    </a>

    <h2 class="mb-4">Daftar Pegawai & Feedback</h2>
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Foto</th>
          <th>Nama</th>
          <th>Jabatan</th>
          <th>Departemen</th>
          <th>Tanggal Masuk</th>
          <th>Feedback</th>
        </tr>
      </thead>
      <tbody id="karyawanBody">
        <?php
        // Contoh data dummy - bisa diganti dengan data dari database
        $pegawai = [
          ["Ahmad Yusuf", "Staf HR", "HR", "2022-01-10"],
          ["Siti Rahma", "Supervisor", "Manajemen", "2021-07-15"],
          ["Budi Santoso", "Operator", "Gudang", "2023-03-01"],
          ["Lina Marlina", "Manager", "Manajemen", "2020-09-25"],
          ["Rudi Hartono", "Staf Gudang", "Gudang", "2022-11-11"]
        ];

        $no = 1;
        foreach ($pegawai as $data) {
          $nama = $data[0];
          $jabatan = $data[1];
          $departemen = $data[2];
          $tanggal = $data[3];
          $foto = "https://ui-avatars.com/api/?name=" . urlencode($nama);
          echo "
          <tr>
            <td>{$no}</td>
            <td><img src='{$foto}' alt='Foto {$nama}' width='50' height='50' class='rounded-circle'></td>
            <td>{$nama}</td>
            <td>{$jabatan}</td>
            <td>{$departemen}</td>
            <td>{$tanggal}</td>
            <td>
              <form method='post' action='proses_feedback.php'>
                <input type='hidden' name='nama' value='{$nama}'>
                <textarea name='feedback' class='form-control mb-2' rows='2' placeholder='Tulis feedback...' required></textarea>
                <button type='submit' class='btn btn-sm btn-primary'>Kirim</button>
              </form>
            </td>
          </tr>";
          $no++;
        }
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
