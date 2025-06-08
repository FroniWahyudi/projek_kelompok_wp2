<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Feedback Pegawai</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Css Custom -->
  <link rel="stylesheet" href="{{ asset('css/feedback_pegawai.css') }}">
</head>
<body>
  <!-- Fixed Home Button -->
  <a href="dashboard" class="home-button">
    <i class="fas fa-home"></i>
    <span>Home</span>
  </a>

  <!-- Notification -->
  <div id="notification" class="notification">
    <i class="bi bi-check-circle"></i>
    <span id="notif-text">Feedback berhasil dikirim!</span>
    <span class="close-btn">&times;</span>
  </div>

  <div class="main-container max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="page-header">
      <h1>
        <i class="bi bi-people-fill"></i>
        <span>Daftar Pegawai & Feedback</span>
      </h1>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
      <div class="filter-title">
        <i class="bi bi-funnel"></i>
        <span>Filter & Pencarian</span>
      </div>
      
      <form method="get" action="{{ url()->current() }}">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="form-label">
              <i class="bi bi-building mr-1"></i>
              Filter Divisi
            </label>
            <select name="divisi" class="form-select" onchange="this.form.submit()">
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
          
          <div>
            <label class="form-label">
              <i class="bi bi-search mr-1"></i>
              Cari Nama Pegawai
            </label>
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nama..." 
                   class="form-control" 
                   id="live-search-input" 
                   autofocus>
          </div>
        </div>
      </form>
    </div>

    <!-- Employee List -->
 <div class="employee-grid">
  @php
    $search = request('search');
  @endphp
  @foreach($pegawai as $data)
    @php
      $matchDivisi = !request('divisi') || request('divisi') == $data['divisi'];
      $matchSearch = !$search || stripos($data['name'], $search) !== false;
    @endphp
    @if($matchDivisi && $matchSearch)
      <div class="employee-card">
        <div class="employee-content">
          <div class="flex justify-center">
            <img src="{{ $data['photo_url'] }}" alt="Foto {{ $data['name'] }}" class="employee-photo">
          </div>
          <div class="employee-details">
            <h3 class="employee-name">{{ $data['name'] }}</h3>
            <div class="badges-container">
              <span class="badge-custom badge-role">{{ $data['role'] }}</span>
              <span class="divider">|</span>
              <span class="badge-custom badge-divisi">{{ ucfirst($data['divisi']) }}</span>
            </div>
            <div class="employee-info">
              <i class="bi bi-calendar-event"></i>
              <span>Bergabung: {{ $data['joined_at'] }}</span>
            </div>
          </div>
          <div class="w-full md:w-80">
            <div class="feedback-section">
              <form method="post" action="{{ url('feedback') }}" class="feedback-form" data-employee-id="{{ $data['id'] }}" data-employee-name="{{ $data['name'] }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ $data['id'] }}">
                <select name="feedback_rating" class="feedback-select w-full mb-2" required>
      <option value="">-- Pilih Penilaian Kinerja --</option>
      <option value="Sangat Baik">Sangat Baik (Sangat disiplin, teliti, dan proaktif)</option>
      <option value="Baik">Baik (Bekerja dengan baik dan bertanggung jawab)</option>
      <option value="Cukup">Cukup (Perlu peningkatan konsistensi dan inisiatif)</option>
      <option value="Kurang">Kurang (Kurang teliti, sering terlambat, atau kurang inisiatif)</option>
      <option value="Perlu Perhatian Khusus">Perlu Perhatian Khusus (Sering lalai, kurang rajin, atau tidak mematuhi SOP)</option>
    </select>
                <button type="submit" class="submit-button">
                  <i class="bi bi-send"></i>
                  <span>Kirim Penilaian</span>
                </button>
              </form>
            </div>
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
      }, 400));
    }

    document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.feedback-form').forEach(form => {
    form.addEventListener('submit', async function(e) {
      e.preventDefault();
      const button = this.querySelector('.submit-button');
      const icon = button.querySelector('i');
      const text = button.querySelector('span');
      const select = this.querySelector('.feedback-select');
      const employeeName = this.dataset.employeeName;
      if (!select.value) {
        select.focus();
        select.style.borderColor = '#dc3545';
        setTimeout(() => { select.style.borderColor = ''; }, 3000);
        return;
      }
      button.disabled = true;
      icon.className = 'bi bi-arrow-repeat animate-spin';
      text.textContent = 'Mengirim...';
      const formData = new FormData(this);
      try {
        const response = await fetch(this.action, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          },
          body: formData
        });
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        // Don't require data.success, just try to parse JSON if available
        try { await response.json(); } catch (e) {}
        button.disabled = false;
        icon.className = 'bi bi-check-circle';
        text.textContent = 'Terkirim!';
        const notification = document.getElementById('notification');
        const notifText = document.getElementById('notif-text');
        notifText.textContent = `Feedback untuk ${employeeName} berhasil dikirim!`;
        notification.style.display = 'flex';
        notification.classList.add('show');
        setTimeout(() => {
          notification.classList.remove('show');
          setTimeout(() => { notification.style.display = 'none'; }, 300);
        }, 5000);
        select.value = '';
        setTimeout(() => {
          icon.className = 'bi bi-send';
          text.textContent = 'Kirim Penilaian';
        }, 2000);
      } catch (error) {
        console.error('Error:', error);
        button.disabled = false;
        icon.className = 'bi bi-x-circle';
        text.textContent = 'Gagal! Coba lagi';
        const notification = document.getElementById('notification');
        const notifText = document.getElementById('notif-text');
        notifText.textContent = 'Gagal mengirim feedback. Silakan coba lagi.';
        notification.style.display = 'flex';
        notification.classList.add('show');
        setTimeout(() => {
          notification.classList.remove('show');
          setTimeout(() => { notification.style.display = 'none'; }, 300);
        }, 5000);
        setTimeout(() => {
          icon.className = 'bi bi-send';
          text.textContent = 'Kirim Penilaian';
        }, 2000);
      }
    });
  });
  // Close notification manually
  const notifCloseBtn = document.querySelector('.notification .close-btn');
  if (notifCloseBtn) {
    notifCloseBtn.addEventListener('click', function() {
      const notification = document.getElementById('notification');
      notification.classList.remove('show');
      setTimeout(() => { notification.style.display = 'none'; }, 300);
    });
  }
});
  </script>
</body>
</html>