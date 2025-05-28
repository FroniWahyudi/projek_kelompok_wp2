<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Feedback Pegawai</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    .gradient-bg {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }
    .hover-scale {
      transition: transform 0.2s ease;
    }
    .hover-scale:hover {
      transform: translateY(-2px);
    }
    .feedback-card {
      background: white;
      border-left: 4px solid #4f46e5;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
  </style>
</head>
<body class="gradient-bg min-h-screen">
  <div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Daftar Pegawai & Feedback</h1>
        <p class="text-gray-600">Daftar feedback yang diberikan kepada pegawai</p>
      </div>
      <a href="dashboard" class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors hover-scale">
        <i class="bi bi-house-door mr-2"></i> Home
      </a>
    </div>

    <!-- Feedback Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-indigo-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">#</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Nama</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Jabatan</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Tanggal Masuk</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Feedback</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200" id="karyawanBody">
            @foreach($feedback as $data)
                @php
                    $filtered = $username->filter(function ($item) use ($data) {
                        return $item['id'] === $data['disetujui_oleh'];
                    })->values()->first();
                @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $filtered['name'] }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                      {{ $filtered['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 
                         ($filtered['role'] === 'manager' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                      {{ $filtered['role'] }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $data['created_at'] }}</td>
                  <td class="px-6 py-4 text-sm text-gray-700">{{ $data['feedback_text'] }}</td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- Empty State (conditional) -->
    @if(count($feedback) === 0)
    <div class="mt-12 text-center">
      <div class="mx-auto h-24 w-24 text-gray-400">
        <i class="bi bi-chat-square-text" style="font-size: 6rem;"></i>
      </div>
      <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada feedback</h3>
      <p class="mt-1 text-gray-500">Feedback yang diberikan akan muncul di sini.</p>
    </div>
    @endif
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>