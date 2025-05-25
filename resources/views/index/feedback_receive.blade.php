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
          <th>Nama</th>
          <th>Jabatan</th>
          <th>Tanggal Masuk</th>
          <th>Feedback</th>
        </tr>
      </thead>
      <tbody id="karyawanBody">
        @foreach($feedback as $data)
            @php
                $filtered = $username->filter(function ($item) use ($data) {
                    return $item['id'] === $data['disetujui_oleh'];
                    })->values()->first();
            @endphp
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $filtered['name'] }}</td>
              <td>{{ $filtered['role'] }}</td>
              <td>{{ $data['created_at'] }}</td>
              <td>{{ $data['feedback_text'] }}</td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
