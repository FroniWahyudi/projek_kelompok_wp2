<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Feedback Pegawai</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --background-main: #f0f4f8;
      --card-background: #ffffff;
      --button-focus: #007bff;
      --gradient-start: #e3f2fd;
      --gradient-end: #e1f5fe;
      --primary-text: #003366;
      --secondary-text: #4a4a4a;
      --muted-text: #6c757d;
      --home-button-bg: #ffffff;
      --home-button-hover: #f8f9fa;
      --home-button-border: #dee2e6;
      --notification-bg: #d4edda;
      --notification-text: #155724;
    }

    body {
      background-color: var(--background-main);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: var(--primary-text);
      position: relative;
      padding-top: 80px;
    }

    /* Home Button Styling */
    .home-button {
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 1050;
      background-color: var(--home-button-bg);
      color: var(--button-focus);
      padding: 12px 15px;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      border: 2px solid var(--home-button-border);
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      min-width: 100px;
      justify-content: center;
    }

    .home-button:hover {
      background-color: var(--button-focus);
      color: var(--card-background);
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

    /* Main Container */
    .main-container {
      margin-top: 20px;
      padding: 0 20px;
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
      color: var(--primary-text);
      margin: 0;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
      background-color: var(--card-background);
      padding: 20px 40px;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
      border: 1px solid var(--gradient-start);
    }

    .page-header h1 i {
      color: var(--button-focus);
      font-size: 2.2rem;
    }

    /* Filter Section */
    .filter-section {
      background-color: var(--card-background);
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
      border: 1px solid var(--gradient-start);
      padding: 30px;
      margin-bottom: 30px;
      transition: all 0.3s ease;
    }

    .filter-section:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    }

    .filter-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--primary-text);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .filter-title i {
      color: var(--button-focus);
    }

    /* Form Controls */
    .form-label {
      color: var(--secondary-text);
      font-weight: 600;
      font-size: 0.9rem;
      margin-bottom: 8px;
      display: block;
    }

    .form-control, .form-select {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid var(--gradient-start);
      border-radius: 10px;
      color: var(--secondary-text);
      font-size: 0.95rem;
      transition: all 0.3s ease;
      background-color: var(--card-background);
    }

    .form-control:focus, .form-select:focus {
      outline: none;
      border-color: var(--button-focus);
      box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
    }

    .form-control::placeholder {
      color: var(--muted-text);
      opacity: 0.7;
    }

    /* Employee Cards */
    .employee-card {
      background-color: var(--card-background);
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
      border: 1px solid var(--gradient-start);
      overflow: hidden;
      transition: all 0.3s ease;
      margin-bottom: 20px;
    }

    .employee-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(0, 123, 255, 0.15);
      border-color: var(--button-focus);
    }

    .employee-photo {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid var(--gradient-start);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .employee-card:hover .employee-photo {
      border-color: var(--button-focus);
      transform: scale(1.05);
    }

    .employee-name {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--primary-text);
      margin-bottom: 8px;
    }

    .badge-custom {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .badge-role {
      background-color: var(--gradient-start);
      color: var(--primary-text);
    }

    .badge-divisi {
      background-color: var(--gradient-end);
      color: var(--primary-text);
    }

    .employee-info {
      color: var(--muted-text);
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 10px;
    }

    .employee-info i {
      color: var(--button-focus);
    }

    /* Feedback Section */
    .feedback-section {
      background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
      padding: 25px;
      border-radius: 0 0 15px 15px;
    }

    .feedback-textarea {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid rgba(0, 123, 255, 0.2);
      border-radius: 10px;
      color: var(--secondary-text);
      font-size: 0.95rem;
      resize: vertical;
      min-height: 80px;
      background-color: var(--card-background);
      transition: all 0.3s ease;
    }

    .feedback-textarea:focus {
      outline: none;
      border-color: var(--button-focus);
      box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
    }

    .feedback-textarea::placeholder {
      color: var(--muted-text);
      opacity: 0.7;
    }

    .submit-button {
      width: 100%;
      background-color: var(--button-focus);
      color: var(--card-background);
      padding: 12px 20px;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.95rem;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .submit-button:hover:not(:disabled) {
      background-color: #0056b3;
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }

    .submit-button:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    .submit-button i {
      font-size: 1rem;
    }

    /* Notification */
    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1100;
      background-color: var(--notification-bg);
      color: var(--notification-text);
      padding: 15px 20px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      display: flex;
      align-items: center;
      gap: 10px;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease;
    }

    .notification.show {
      opacity: 1;
      visibility: visible;
    }

    .notification .close-btn {
      cursor: pointer;
      font-size: 1.2rem;
      color: var(--notification-text);
    }

    /* Grid Layout */
    .employee-grid {
      display: grid;
      gap: 25px;
      margin-top: 20px;
    }

    .employee-content {
      display: grid;
      grid-template-columns: auto 1fr auto;
      gap: 25px;
      align-items: center;
      padding: 25px;
    }

    .employee-details {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .badges-container {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .divider {
      color: var(--muted-text);
      font-weight: 300;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .page-header h1 {
        font-size: 2rem;
        padding: 15px 30px;
      }
      
      .filter-section {
        padding: 25px;
      }
    }

    @media (max-width: 768px) {
      body {
        padding-top: 90px;
      }
      
      .home-button {
        top: 15px;
        left: 15px;
        padding: 10px 16px;
        font-size: 13px;
        min-width: 90px;
      }
      
      .main-container {
        padding: 0 15px;
      }
      
      .page-header h1 {
        font-size: 1.8rem;
        padding: 15px 25px;
        flex-direction: column;
        gap: 10px;
      }
      
      .filter-section {
        padding: 20px;
      }
      
      .employee-content {
        grid-template-columns: 1fr;
        gap: 20px;
        text-align: center;
      }
      
      .employee-photo {
        width: 80px;
        height: 80px;
        margin: 0 auto;
      }
      
      .badges-container {
        justify-content: center;
      }
    }

    @media (max-width: 640px) {
      .home-button {
        padding: 8px 12px;
        font-size: 12px;
        min-width: 80px;
      }
      
      .page-header {
        margin-bottom: 25px;
        padding: 15px 0;
      }
      
      .page-header h1 {
        font-size: 1.5rem;
        padding: 12px 20px;
      }
      
      .filter-section {
        padding: 15px;
      }
      
      .employee-content {
        padding: 20px;
      }
      
      .employee-photo {
        width: 70px;
        height: 70px;
      }
      
      .employee-name {
        font-size: 1.1rem;
      }
      
      .feedback-section {
        padding: 20px;
      }
    }

    @media (max-width: 480px) {
      .page-header h1 {
        font-size: 1.25rem;
        padding: 10px 15px;
      }
      
      .badges-container {
        flex-direction: column;
        align-items: center;
        gap: 5px;
      }
      
      .divider {
        display: none;
      }
      
      .employee-photo {
        width: 60px;
        height: 60px;
      }
    }

    /* Animation Enhancements */
    .employee-card, .filter-section, .home-button {
      animation: slideInUp 0.6s ease-out;
    }

    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .employee-card:nth-child(1) { animation-delay: 0.1s; }
    .employee-card:nth-child(2) { animation-delay: 0.2s; }
    .employee-card:nth-child(3) { animation-delay: 0.3s; }
    .employee-card:nth-child(4) { animation-delay: 0.4s; }
    .employee-card:nth-child(5) { animation-delay: 0.5s; }
  </style>
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
    <span>Feedback berhasil dikirim!</span>
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
                <textarea name="feedback_text" class="feedback-textarea" rows="2" placeholder="Tulis feedback..." required></textarea>
                <button type="submit" class="submit-button">
                  <i class="bi bi-send"></i>
                  <span>Kirim Feedback</span>
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

    // Feedback form submission with notification
    document.querySelectorAll('.feedback-form').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const button = this.querySelector('.submit-button');
        const icon = button.querySelector('i');
        const text = button.querySelector('span');
        const textarea = this.querySelector('.feedback-textarea');
        
        if (!textarea.value.trim()) {
          textarea.focus();
          textarea.style.borderColor = '#dc3545';
          setTimeout(() => {
            textarea.style.borderColor = '';
          }, 3000);
          return;
        }
        
        button.disabled = true;
        icon.className = 'bi bi-arrow-repeat animate-spin';
        text.textContent = 'Mengirim...';
        
        // Create form data and send it
        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            button.disabled = false;
            icon.className = 'bi bi-check-circle';
            text.textContent = 'Terkirim!';
            
            // Show notification
            const notification = document.getElementById('notification');
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 5000);
            
            textarea.value = '';
            
            setTimeout(() => {
                icon.className = 'bi bi-send';
                text.textContent = 'Kirim Feedback';
            }, 2000);
        })
        .catch(error => {
            console.error('Error:', error);
            button.disabled = false;
            icon.className = 'bi bi-x-circle';
            text.textContent = 'Gagal! Coba lagi';
            
            setTimeout(() => {
                icon.className = 'bi bi-send';
                text.textContent = 'Kirim Feedback';
            }, 2000);
        });
      });
    });

    // Close notification manually
    document.querySelector('.notification .close-btn').addEventListener('click', function() {
      this.parentElement.classList.remove('show');
    });
  </script>
</body>
</html>