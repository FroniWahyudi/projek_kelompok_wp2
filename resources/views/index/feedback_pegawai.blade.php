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
    .feedback-card {
      transition: all 0.3s ease;
    }
    .feedback-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body class="gradient-bg min-h-screen">
  <div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
      <a href="dashboard" class="flex items-center text-indigo-600 hover:text-indigo-800 transition-colors">
        <i class="bi bi-house-door text-xl mr-2"></i>
        <span class="font-medium">Home</span>
      </a>
      <div class="bg-white rounded-lg shadow-md px-4 py-2">
        <h1 class="text-2xl font-bold text-gray-800">
          <span class="text-indigo-600">Daftar Pegawai</span> & Feedback
        </h1>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
      <form method="get" action="{{ url()->current() }}">
        <div class="flex flex-col md:flex-row gap-4">
          <div class="w-full md:w-1/3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Filter Divisi</label>
            <select name="divisi" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" onchange="this.form.submit()">
              <option value="">-- Semua Divisi --</option>
              @php
                $listdivisi = ['inbound', 'outbound', 'storage'];
              @endphp
              @foreach($listdivisi as $divisi)
                <option value="{{ $divisi }}" {{ request('divisi') == $divisi ? 'selected' : '' }}>
                  {{ ucfirst($divisi) }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
      </form>
    </div>

    <!-- Employee List -->
    <div class="grid gap-6">
      @foreach($pegawai as $data)
        @if(!request('divisi') || request('divisi') == $data['divisi'])
          <div class="feedback-card bg-white rounded-xl shadow-md overflow-hidden">
            <div class="md:flex">
              <!-- Employee Photo -->
              <div class="md:w-1/6 p-4 flex justify-center">
                <img src="{{ $data['photo_url'] }}" alt="Foto" class="rounded-full h-24 w-24 object-cover border-4 border-indigo-100">
              </div>
              
              <!-- Employee Details -->
              <div class="md:w-3/6 p-4">
                <div class="flex flex-col space-y-2">
                  <h3 class="text-xl font-semibold text-gray-800">{{ $data['name'] }}</h3>
                  <div class="flex items-center">
                    <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                      {{ $data['role'] }}
                    </span>
                    <span class="mx-2 text-gray-400">|</span>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                      {{ ucfirst($data['divisi']) }}
                    </span>
                  </div>
                  <div class="flex items-center text-gray-600">
                    <i class="bi bi-calendar-event mr-2"></i>
                    <span>Bergabung: {{ $data['joined_at'] }}</span>
                  </div>
                </div>
              </div>
              
              <!-- Feedback Form -->
              <div class="md:w-2/6 p-4 bg-gray-50">
                <form method="post" action="{{ url('feedback') }}">
                  @csrf
                  <input type="hidden" name="user_id" value="{{ $data['id'] }}">
                  <div class="mb-3">
                    <textarea name="feedback_text" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" rows="2" placeholder="Tulis feedback..." required></textarea>
                  </div>
                  <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Kirim Feedback
                  </button>
                </form>
              </div>
            </div>
          </div>
        @endif
      @endforeach
    </div>
  </div>
</body>
</html>