<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Feedback Pegawai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <!-- Css Custom -->
    <link rel="stylesheet" href="{{ asset('css/feedback_receive.css') }}">
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
              <th scope="col" class="px-3 py-3 text-left text-xs fw-medium text-uppercase" style="color: #003366;">Rating</th>
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
                  @php
                    $key = strtolower(trim($data['feedback_text'] ?? ''));
                    $ratingMap = [
                      'sangat baik' => 5,
                      'baik' => 4,
                      'cukup' => 3,
                      'kurang' => 2,
                      'perlu perhatian khusus' => 1,
                    ];
                    $bintang = $ratingMap[$key] ?? 0;
                  @endphp
                  <td>
                    @for ($i = 1; $i <= 5; $i++)
                      @if ($i <= $bintang)
                        <span style="color:gold;">&#9733;</span>
                      @else
                        <span style="color:#ccc;">&#9733;</span>
                      @endif
                    @endfor
                  </td>
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