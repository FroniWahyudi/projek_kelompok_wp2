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
      background: #f0f4f8;
    }
    .feedback-card {
      transition: all 0.3s ease;
      background: #ffffff;
      border: 1px solid #e3f2fd;
    }
    .feedback-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0,123,255,0.1);
      border-color: #007bff;
    }
    .card-gradient-section {
      background: linear-gradient(135deg, #e3f2fd 0%, #e1f5fe 100%);
    }
    .text-primary {
      color: #003366 !important;
    }
    .text-secondary {
      color: #4a4a4a !important;
    }
    .text-muted {
      color: #6c757d !important;
    }
    .bg-primary {
      background-color: #007bff !important;
    }
    .bg-primary:hover {
      background-color: #0056b3 !important;
    }
    .border-primary {
      border-color: #007bff !important;
    }
    .focus-ring-primary:focus {
      outline: none;
      border-color: #007bff;
    }
    .badge-primary {
      background-color: #e3f2fd;
      color: #003366;
    }
    .badge-secondary {
      background-color: #e1f5fe;
      color: #003366;
    }
    .home-link {
      color: #007bff;
    }
    .home-link:hover {
      color: #0056b3;
    }
    .header-card {
      background: #ffffff;
      border: 1px solid #e3f2fd;
    }
    .filter-card {
      background: #ffffff;
      border: 1px solid #e3f2fd;
    }
    .select-input {
      border-color: #e3f2fd;
      color: #4a4a4a;
    }
    .select-input:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 2px rgba(0,123,255,0.1);
    }
  </style>
</head>
<body class="gradient-bg min-h-screen">
  <div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
      <a href="dashboard" class="flex items-center home-link hover:text-blue-800 transition-colors">
        <i class="bi bi-house-door text-xl mr-2"></i>
        <span class="font-medium">Home</span>
      </a>
      <div class="header-card rounded-lg shadow-md px-4 py-2">
        <h1 class="text-2xl font-bold text-primary">
          <span class="text-primary">Daftar Pegawai</span> & Feedback
        </h1>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card rounded-xl shadow-md p-6 mb-8">
      <form method="get" action="{{ url()->current() }}">
        <div class="flex flex-col md:flex-row gap-4">
          <div class="w-full md:w-1/3">
            <label class="block text-sm font-medium text-secondary mb-1">Filter Divisi</label>
            <select name="divisi" class="select-input w-full px-4 py-2 rounded-lg border focus-ring-primary transition-all" onchange="this.form.submit()">
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
          <!-- Search Input -->
          <div class="w-full md:w-1/3">
            <label class="block text-sm font-medium text-secondary mb-1">Cari Nama Pegawai</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." class="select-input w-full px-4 py-2 rounded-lg border focus-ring-primary transition-all" id="live-search-input" autofocus>
          </div>
        </div>
      </form>
    </div>

    <!-- Employee List -->
    <div class="grid gap-6">
      @php
        $search = request('search');
      @endphp
      @foreach($pegawai as $data)
        @php
          $matchDivisi = !request('divisi') || request('divisi') == $data['divisi'];
          $matchSearch = !$search || stripos($data['name'], $search) !== false;
        @endphp
        @if($matchDivisi && $matchSearch)
          <div class="feedback-card rounded-xl shadow-md overflow-hidden">
            <div class="md:flex">
              <!-- Employee Photo -->
              <div class="md:w-1/6 p-4 flex justify-center">
                <img src="{{ $data['photo_url'] }}" alt="Foto" class="rounded-full h-24 w-24 object-cover border-4" style="border-color: #e3f2fd;">
              </div>
              
              <!-- Employee Details -->
              <div class="md:w-3/6 p-4">
                <div class="flex flex-col space-y-2">
                  <h3 class="text-xl font-semibold text-primary">{{ $data['name'] }}</h3>
                  <div class="flex items-center">
                    <span class="badge-primary text-xs font-medium px-2.5 py-0.5 rounded-full">
                      {{ $data['role'] }}
                    </span>
                    <span class="mx-2 text-muted">|</span>
                    <span class="badge-secondary text-xs font-medium px-2.5 py-0.5 rounded-full">
                      {{ ucfirst($data['divisi']) }}
                    </span>
                  </div>
                  <div class="flex items-center text-muted">
                    <i class="bi bi-calendar-event mr-2"></i>
                    <span>Bergabung: {{ $data['joined_at'] }}</span>
                  </div>
                </div>
              </div>
              
              <!-- Feedback Form -->
              <div class="md:w-2/6 p-4 card-gradient-section">
                <form method="post" action="{{ url('feedback') }}">
                  @csrf
                  <input type="hidden" name="user_id" value="{{ $data['id'] }}">
                  <div class="mb-3">
                    <textarea name="feedback_text" class="w-full px-3 py-2 text-secondary border rounded-lg focus-ring-primary" style="border-color: #e3f2fd;" rows="2" placeholder="Tulis feedback..." required></textarea>
                  </div>
                  <button type="submit" class="w-full bg-primary hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
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

  <script>
    // Debounce function to limit how often the form submits
    function debounce(func, wait) {
      let timeout;
      return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
      };
    }

    const searchInput = document.getElementById('live-search-input');
    if (searchInput) {
      const form = searchInput.form;
      searchInput.addEventListener('input', debounce(function() {
        form.submit();
      }, 400)); // 400ms debounce
    }
  </script>
</body>
</html>