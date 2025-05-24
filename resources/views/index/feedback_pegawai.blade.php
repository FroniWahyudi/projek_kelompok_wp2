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

    <div class="mb-4">
      <form method="get" action="{{ url()->current() }}">
        <div class="row">
          <div class="col-md-4">
            <select name="divisi" class="form-select" onchange="this.form.submit()">
              <option value="">-- Pilih Divisi --</option>
              @php
                $listdivisi = ['inbound', 'outbound', 'storage'];
              @endphp
              @foreach($listdivisi as $divisi)
                <option value="{{ $divisi }}" {{ request('divisi') == $divisi ? 'selected' : '' }}>{{ $divisi }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </form>
    </div>

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
        @foreach($pegawai as $data)
          @if(!request('divisi') || request('divisi') == $data['divisi'])
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td><img src={{ $data['photo_url'] }} alt='Foto' width='50' height='50' class='rounded-circle'></td>
              <td>{{ $data['name'] }}</td>
              <td>{{ $data['role'] }}</td>
              <td>{{ $data['divisi'] }}</td>
              <td>{{ $data['joined_at'] }}</td>
              <td>
                <form method='post' action='proses_feedback'>
                  <input type='hidden' name='nama' value={{ $data['name'] }}>
                  <textarea name='feedback' class='form-control mb-2' rows='2' placeholder='Tulis feedback...' required></textarea>
                  <button type='submit' class='btn btn-sm btn-primary'>Kirim</button>
                </form>
              </td>
            </tr>
          @endif
        @endforeach
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
