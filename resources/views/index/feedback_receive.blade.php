<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Feedback Pegawai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .gradient-bg {
      background: #f0f4f8;
    }
    .hover-scale {
      transition: transform 0.2s ease;
    }
    .hover-scale:hover {
      transform: translateY(-2px);
    }
    .feedback-card {
      background: #ffffff;
      border-left: 4px solid #007bff;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    /* Tambahkan class badge role */
    .role-admin {
      background-color: #e3f2fd !important;
      color: #003366 !important;
    }
    .role-manager {
      background-color: #e1f5fe !important;
      color: #003366 !important;
    }
    .role-default {
      background-color: #f0f4f8 !important;
      color: #003366 !important;
    }
  </style>
</head>
<body class="gradient-bg min-vh-100">
  <div class="container py-4 py-md-5">
    <a href="dashboard" class="mt-3 mt-md-0 btn btn-primary hover-scale" style="margin-bottom:10px;">
      <i class="fas fa-home mr-2"></i> Home
    </a>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4">
      <div>
        <h1 class="h2 fw-bold" style="color: #003366;">Feedback</h1>
        <p style="color: #4a4a4a;">Daftar feedback yang diberikan kepada {{ auth()->user()->name }}</p>
      </div>
    </div>

    <div class="feedback-card rounded-3 shadow">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead style="background-color: #e3f2fd;">
            <tr>
              <th scope="col" class="px-3 py-3 text-left text-xs fw-medium text-uppercase" style="color: #003366;">#</th>
              <th scope="col" class="px-3 py-3 text-left text-xs fw-medium text-uppercase" style="color: #003366;">Nama</th>
              <th scope="col" class="px-3 py-3 text-left text-xs fw-medium text-uppercase" style="color: #003366;">Jabatan</th>
              <th scope="col" class="px-3 py-3 text-left text-xs fw-medium text-uppercase" style="color: #003366;">Tanggal Masuk</th>
              <th scope="col" class="px-3 py-3 text-left text-xs fw-medium text-uppercase" style="color: #003366;">Feedback</th>
            </tr>
          </thead>
          <tbody style="background-color: #ffffff;">
            @foreach($feedback as $data)
                @php
                    $filtered = $username->filter(function ($item) use ($data) {
                        return $item['id'] === $data['disetujui_oleh'];
                    })->values()->first();
                @endphp
                <tr>
                  <td class="px-3 py-4 text-sm fw-medium" style="color: #003366;">{{ $loop->iteration }}</td>
                  <td class="px-3 py-4 text-sm" style="color: #003366;">{{ $filtered['name'] }}</td>
                  <td class="px-3 py-4 text-sm">
                    <span class="badge rounded-pill
                      {{ $filtered['role'] === 'admin' ? 'role-admin' : 
                         ($filtered['role'] === 'manager' ? 'role-manager' : 'role-default') }}">
                      {{ $filtered['role'] }}
                    </span>
                  </td>
                  <td class="px-3 py-4 text-sm" style="color: #4a4a4a;">{{ $data['created_at'] }}</td>
                  <td class="px-3 py-4 text-sm" style="color: #003366;">{{ $data['feedback_text'] }}</td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    @if(count($feedback) === 0)
    <div class="mt-5 text-center">
      <div class="mx-auto" style="color: #6c757d; font-size: 6rem;">
        <i class="bi bi-chat-square-text"></i>
      </div>
      <h3 class="mt-4 h4 fw-medium" style="color: #003366;">Belum ada feedback</h3>
      <p class="mt-1 text-muted">Feedback yang diberikan akan muncul di sini.</p>
    </div>
    @endif
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>