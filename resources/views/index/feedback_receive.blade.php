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
    /* Home Button Styling */
    .home-button {
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 1050;
      background-color: #ffffff;
      color: #007bff;
      padding: 12px 15px;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      border: 2px solid #dee2e6;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      min-width: 100px;
      justify-content: center;
    }

    .home-button:hover {
      background-color: #007bff;
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 123, 255, 0.25);
      text-decoration: none;
    }

    .home-button i {
      font-size: 16px;
      transition: transform 0.3s ease;
    }

    .home-button:hover i {
      transform: scale(1.1);
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
    /* Page Header */
    .page-header {
      text-align: center;
      margin-bottom: 40px;
      padding: 30px 0;
    }

    .page-header h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #003366;
      margin: 0;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
      background-color: #ffffff;
      padding: 20px 40px;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
      border: 1px solid #e3f2fd;
    }

    .page-header h1 i {
      color: #007bff;
      font-size: 2.2rem;
    }

    @media (max-width: 768px) {
      .page-header h1 {
        font-size: 1.8rem;
        padding: 15px 25px;
        flex-direction: column;
        gap: 10px;
      }
    }

    @media (max-width: 640px) {
      .page-header {
        margin-bottom: 25px;
        padding: 15px 0;
      }
      
      .page-header h1 {
        font-size: 1.5rem;
        padding: 12px 20px;
      }
    }
  </style>
</head>
<body class="gradient-bg min-vh-100">
  <!-- Fixed Home Button -->
  <a href="dashboard" class="home-button">
    <i class="fas fa-home"></i>
    <span>Home</span>
  </a>

  <div class="container py-4 py-md-5">
    <!-- Page Header -->
    <div class="page-header">
      <h1>
        <i class="bi bi-chat-square-text"></i>
        <span>Feedback {{ auth()->user()->name }}</span>
      </h1>
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
                  <td class="px-3 py-4 text-sm" style="color: #4a4a4a;">
                    {{ \Illuminate\Support\Str::of($data['created_at'])->before(' ') }}
                  </td>
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