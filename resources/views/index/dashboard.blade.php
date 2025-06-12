<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Naga Hytam Sejahtera Abadi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar-custom">
    <div class="dropdown d-lg-none nav-item">
      <button class="btn btn-outline-secondary mobile-menu-btn" type="button" id="mobileMenu" data-bs-toggle="dropdown">
        <i class="bi bi-list"></i> <span class="text-menu"> Menu</span>
      </button>
      <ul class="dropdown-menu mobile-dropdown-menu animate__animated animate-slide-down nyoba" aria-labelledby="mobileMenu">
        <li><h6 class="dropdown-header">Divisi Karyawan</h6></li>
        <li><a class="dropdown-item" href="{{ route('hr.manajemen') }}"><i class="bi bi-people-fill me-1"></i> Manajemen</a></li>
        <li><a class="dropdown-item" href="{{ route('admin.index') }}"><i class="bi bi-person-circle me-1"></i> Administrasi</a></li>
        <li><a class="dropdown-item" href="{{ route('leader.index') }}"><i class="bi bi-people-fill me-1"></i> Leader</a></li>
        <li><a class="dropdown-item" href="{{ route('operator.index') }}"><i class="bi bi-people-fill me-1"></i> Operator Gudang</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><h6 class="dropdown-header">Menu Lainnya</h6></li>
        @if(auth()->user()->role === 'Manajer' || auth()->user()->role === 'Admin')
          <li><a class="dropdown-item" href="{{ route('laporan.index') }}"><i class="bi bi-journal-text me-1"></i> Daftar Resi</a></li>
          <li><a class="dropdown-item" href="{{ route('reset.password.form') }}"><i class="bi bi-key me-1"></i> Reset Password</a></li>
        @endif
        @if(auth()->user()->role === 'Leader' || (auth()->user()->role === 'Operator' && str_contains(auth()->user()->job_descriptions, 'Inventory checker')))
          <li><a class="dropdown-item" href="{{ route('laporan.index') }}"><i class="bi bi-journal-text me-1"></i> Resi hari ini</a></li>
        @endif
        @if(auth()->user()->role === 'Manajer')
          <li>
            <a class="dropdown-item" href="{{ route('cuti.index') }}">
              <i class="bi bi-check-square me-1"></i> Daftar Pengajuan Cuti
              @if(app('App\Http\Controllers\CutiController')->hasPendingRequests())
                <span class="notification-dot"></span>
              @endif
            </a>
          </li>
        @endif
        @if(auth()->user()->role === 'Operator' || auth()->user()->role === 'Admin' || auth()->user()->role === 'Leader')
          <li><a class="dropdown-item" href="{{ route('cuti.index') }}"><i class="bi bi-file-earmark-text me-1"></i> Pengajuan Cuti</a></li>
          <li>
            <a class="dropdown-item position-relative" href="{{ route('slips.index') }}">
              <i class="bi bi-receipt me-1"></i> Slip Gaji
              <span id="slipNotificationDotMobile" class="notification-dot-slip"></span>
            </a>
          </li>
        @endif
        <li>
          <a class="dropdown-item" href="{{ route('feedback.index') }}">
            <i class="bi bi-chat-dots me-1"></i>
            @if(auth()->user()->role === 'Operator')
              Evaluasi Kinerja
            @else
              Feedback Pegawai
            @endif
          </a>
        </li>
        <li><a class="dropdown-item" href="{{ route('shift.karyawan') }}"><i class="bi bi-clock-history me-1"></i> Shift & Jadwal</a></li>
      </ul>
    </div>
    <div id="profileDropdownToggle" class="profile-dropdown-toggle nav-item" data-bs-toggle="modal" data-bs-target="#profileModal">
      <img src="<?= htmlspecialchars($user['photo_url'] ?: 'img/default_profile.png') ?>" 
           class="profile-img-sm" alt="Foto Profil">
      <div class="profile-info d-none d-md-block">
        <strong><?= htmlspecialchars($user['name']) ?></strong>
        <small><?= htmlspecialchars($user['role']) ?></small>
      </div>
    </div>
    <div class="logo-brand">
      <img src="img/logo_brand.png" alt="Logo Brand" class="transition">
    </div>
    <div class="ms-auto nav-item d-none d-lg-block">
      <a href="/logout" class="btn btn-outline-dark">
        <i class="bi bi-box-arrow-right me-1"></i>
        Logout
      </a>
    </div>
  </nav>

  <!-- Sidebar -->
  <nav class="sidebar">
    <h6 class="fw-bold text-uppercase">Divisi Karyawan</h6>
    <a href="{{ route('hr.manajemen') }}" class="btn btn-outline-primary">
      <i class="bi bi-people-fill me-1"></i> Manajemen
    </a>
    <a href="{{ route('admin.index') }}" class="btn btn-outline-primary">
      <i class="bi bi-person-circle me-1"></i> Administrasi
    </a>
    <a href="{{ route('leader.index') }}" class="btn btn-outline-primary">
      <i class="bi bi-people-fill me-1"></i> Leader
    </a>
    <a href="{{ route('operator.index') }}" class="btn btn-outline-primary">
      <i class="bi bi-people-fill me-1"></i> Operator Gudang
    </a>
    <hr>
    <h6 class="fw-bold">Menu Lainnya</h6>
    @if(auth()->user()->role === 'Admin')
      <a class="btn btn-outline-dark" href="{{ route('reset.password.form') }}">
        <span id="resetNotification" class="badge bg-danger rounded-pill">!</span>
        <i class="bi bi-key me-1"></i> Reset Password
      </a>
    @endif
    @if(auth()->user()->role === 'Manajer' || auth()->user()->role === 'Admin')
      <a href="{{ route('laporan.index') }}" class="btn btn-outline-dark">
        <i class="bi bi-journal-text me-1"></i> Daftar Resi
      </a>
    @endif
    @if(auth()->user()->role === 'Leader' || (auth()->user()->role === 'Operator' && str_contains(auth()->user()->job_descriptions, 'Inventory checker')))
      <a href="{{ route('laporan.index') }}" class="btn btn-outline-dark">
        <i class="bi bi-journal-text me-1"></i> Resi hari ini
      </a>
    @endif
    @if(auth()->user()->role === 'Manajer')
      <a class="btn btn-outline-dark position-relative" href="{{ route('cuti.index') }}">
        @if(app('App\Http\Controllers\CutiController')->hasPendingRequests())
          <span class="notification-dot"></span>
        @endif
        <i class="bi bi-check-square me-1"></i> Daftar Cuti
      </a>
    @endif
    @if(auth()->user()->role === 'Operator' || auth()->user()->role === 'Admin' || auth()->user()->role === 'Leader')
      <a href="{{ route('cuti.index') }}" 
         class="btn btn-outline-dark position-relative"
         id="cutiButton">
        <i class="bi bi-check-square me-1"></i> Pengajuan Cuti
        <span id="cutiNotificationDot" class="notification-dot-cuti
        @if(app('App\Http\Controllers\CutiController')->hasNonPendingRequests())
        active
        @endif
        "></span>
      </a>
      <a href="{{ route('slips.index') }}" class="btn btn-outline-dark position-relative" id="slipButton">
        <i class="bi bi-receipt me-1"></i> Slip Gaji
        @if(auth()->user()->role === 'Operator' || auth()->user()->role === 'Admin' || auth()->user()->role === 'Leader')
          <span id="slipNotificationDot" class="notification-dot-slip"></span>
        @endif
      </a>
    @endif
    <a href="{{ route('feedback.index') }}" class="btn btn-outline-dark">
      <span class="notification-dot-feedback
      @if(app('App\Http\Controllers\CrudController')->feedbackhasUnread())
        active
      @endif
      "></span>
      <i class="bi bi-chat-dots me-1"></i>
      @if(auth()->user()->role === 'Operator')
        Evaluasi Kinerja
      @else
        Feedback Pegawai
      @endif
    </a>
    <a href="{{ route('shift.karyawan') }}" class="btn btn-outline-dark">
      <i class="bi bi-clock-history me-1"></i> Shift & Jadwal
    </a>
  </nav>

  <!-- Main Content -->
  <main>
    <div class="page-header animate__animated animate__fadeIn">
      <h3>What's New</h3>
      @if(auth()->user()->role === 'Manajer' || auth()->user()->role === 'Admin')
        <a href="{{ route('whats_new.create') }}" class="btn btn-primary">
          <i class="bi bi-plus-lg me-1"></i> New Post
        </a>
      @endif
    </div>
    <div class="news-grid">
      @foreach($newsItems as $idx => $item)
        <div class="animate-fade-in delay-{{ ($idx % 4) + 1 }}">
          <div class="card card-news">
            <div class="position-relative">
              <a href="{{ route('whats_new', ['id' => $item['id']]) }}">
                <img src="{{ htmlspecialchars($item['image_url']) }}" 
                     class="card-img-top" 
                     alt="{{ htmlspecialchars($item['title']) }}">
              </a>
              @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manajer')
                <a href="{{ route('whats_new.edit', ['id' => $item['id']]) }}" 
                   class="edit-btn" 
                   title="Edit" style="height: 40px; width: 40px;">
                  <i class="bi bi-pencil-square text-primary"></i>
                </a>
                <form action="{{ route('whats_new.delete', ['id' => $item['id']]) }}" 
                      method="POST" 
                      class="delete-form">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="delete-btn" title="Delete">
                    <i class="bi bi-trash text-danger"></i>
                  </button>
                </form>
              @endif
            </div>
            <div class="card-body">
              <a href="{{ route('whats_new', ['id' => $item['id']]) }}">
                <h5 class="card-title">{{ htmlspecialchars($item['title']) }}</h5>
                <p class="card-text">{!! Str::limit($item['description'], 120) !!}</p>
                <div class="card-date">
                  <i class="bi bi-calendar me-1"></i> {{ htmlspecialchars($item['date']) }}
                </div>
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    @if(session('success'))
      <div id="notif-success" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        <div class="toast align-items-center border-0 show" role="alert" aria-live="assertive" aria-atomic="true"
            style="background-color: #007bff; color: #fff;">
          <div class="d-flex">
            <div class="toast-body">
              <i class="bi bi-check-circle-fill me-2"></i>
              {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
    @endif
  </main>

  <!-- Profile Modal (Bootstrap) -->
  @include('components.profile-modal')

  <!-- Mobile Bottom Navbar -->
  <nav class="mobile-bottom-nav">
@if (auth()->user()->role === 'Leader' || (auth()->user()->role === 'Operator' && str_contains(auth()->user()->job_descriptions, 'Inventory checker')))
    <a href="{{ route('laporan.index') }}" class="nav-link">
        <i class="bi bi-journal-text me-1"></i>
        <span>Resi Harian</span>
    </a>
@else
    <a href="{{ route('slips.index') }}" class="nav-link">
        <i class="fas fa-file-invoice-dollar"></i>
        <span>Slip Gaji</span>
    </a>
@endif
    <a href="#" class="nav-link active">
      <i class="fas fa-home"></i>
      <span>Home</span>
    </a>
    <a href="#" class="nav-link profile-link" id="profileLink">
      <img src="{{ htmlspecialchars($user['photo_url'] ?? '/default.jpg') }}" 
           class="profile-img-mobile" 
           alt="Profile Image">
      <span>Profil</span>
    </a>
  </nav>

 <!-- Slide-up Modal -->
<div id="profileSlideUpModal" class="profile-slide-modal">
  <div class="profile-slide-modal-content">
    <a href="#" class="modal-option" data-bs-toggle="modal" data-bs-target="#profileModal">Detail Profil</a>
    <a href="{{ url('edit_profil/' . $user['id']) }}" class="modal-option">Pengaturan Profil</a>
    <a href="{{ route('logout') }}" class="modal-option" onclick="event.preventDefault(); confirmLogout();">Logout</a>
  </div>
</div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      // Navbar scroll effect
      $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
          $('.navbar-custom').addClass('scrolled');
        } else {
          $('.navbar-custom').removeClass('scrolled');
        }
      });

      // Animate elements on scroll
      function animateOnScroll() {
        $('.animate-fade-in').each(function() {
          var elementPosition = $(this).offset().top;
          var scrollPosition = $(window).scrollTop() + $(window).height();
          if (elementPosition < scrollPosition - 100) {
            $(this).css('opacity', '1');
          }
        });
      }

      animateOnScroll();
      $(window).scroll(animateOnScroll);

      // Mobile menu toggle for sidebar
      $('#mobileMenu').click(function() {
        $('.sidebar').toggleClass('active');
      });

      // Close sidebar when clicking outside
      $(document).click(function(e) {
        if (!$(e.target).closest('.sidebar, #mobileMenu').length) {
          $('.sidebar').removeClass('active');
        }
      });

      $('.sidebar').click(function(e) {
        e.stopPropagation();
      });

      // Smooth hover effects
      $('.card-news').hover(
        function() {
          $(this).find('.card-title').css('color', 'var(--primary-color)');
        },
        function() {
          $(this).find('.card-title').css('color', 'var(--dark-color)');
        }
      );

      // Profile modal (Bootstrap) animation
      $('#profileModal').on('show.bs.modal', function() {
        $(this).find('.modal-content').addClass('animate__animated animate__zoomIn');
      });

      $('#profileModal').on('hidden.bs.modal', function() {
        $(this).find('.modal-content').removeClass('animate__animated animate__zoomIn');
      });

      // Konfirmasi untuk tombol delete dengan SweetAlert2
      document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
          e.preventDefault();
          Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit();
            }
          });
        });
      });

      // Slide-up modal click handler
      $('#profileLink').on('click', function(e) {
        e.preventDefault();
        showProfileSlideUpModal();
      });

      // Close slide-up modal when clicking outside
      $('#profileSlideUpModal').on('click', function(e) {
        if (e.target === this) {
          hideProfileSlideUpModal();
        }
      });

      // Close slide-up modal when clicking an option
      $('#profileSlideUpModal .modal-option').on('click', function() {
        hideProfileSlideUpModal();
      });
    });

    // Slide-up modal functions
    function showProfileSlideUpModal() {
      const modal = document.getElementById('profileSlideUpModal');
      modal.classList.add('active');
    }

    function hideProfileSlideUpModal() {
      const modal = document.getElementById('profileSlideUpModal');
      modal.classList.remove('active');
    }

    // Logout confirmation with SweetAlert2
    function confirmLogout() {
      Swal.fire({
        title: 'Apakah Anda yakin ingin logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, logout',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "{{ route('logout') }}";
        }
      });
    }

    // Existing notification logic
    document.addEventListener('DOMContentLoaded', function() {
      fetch("{{ route('check.reset.requests') }}")
        .then(response => response.json())
        .then(data => {
          const notification = document.getElementById('resetNotification');
          if (data.exists) {
            notification.style.display = 'inline-block';
          } else {
            notification.style.display = 'none';
          }
        })
        .catch(error => console.error('Error:', error));
    });

    document.addEventListener('DOMContentLoaded', function() {
      const cutiButton = document.getElementById('cutiButton');
      const notificationDot = document.getElementById('cutiNotificationDot');
      if (cutiButton) {
        cutiButton.addEventListener('click', function() {
          fetch("{{ route('cuti.markAsRead') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success && notificationDot) {
              notificationDot.classList.remove('active');
            }
          })
          .catch(error => console.error('Error marking cuti as read:', error));
        });
      }
    });

    $('#cutiButton').on('click', function(e) {
      e.preventDefault();
      var self = this;
      setTimeout(function() {
        window.location.href = self.href;
      }, 50);
    });

    document.addEventListener('DOMContentLoaded', function() {
      const slipButton = document.querySelector('a[href="<?php echo route('slips.index'); ?>"]');
      const slipNotificationDot = document.getElementById('slipNotificationDot');
      const slipNotificationDotMobile = document.getElementById('slipNotificationDotMobile');
      if (slipButton) {
        slipButton.addEventListener('click', function() {
          fetch("{{ route('slips.markAsRead') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success && slipNotificationDot) {
              slipNotificationDot.classList.remove('active');
            }
            if (data.success && slipNotificationDotMobile) {
              slipNotificationDotMobile.classList.remove('active');
            }
          })
          .catch(error => console.error('Error marking slip as read:', error));
        });
      }
    });

    window.appConfig = {
      slipsMarkAsReadUrl: "{{ route('slips.markAsRead') }}",
      slipsCheckLatestPeriodUrl: "{{ route('slips.checkLatestPeriodSlip') }}",
      csrfToken: "{{ csrf_token() }}",
      userRole: "{{ auth()->user()->role ?? '' }}"
    };

    const slipButton = document.getElementById('slipButton');
    const slipNotificationDot = document.getElementById('slipNotificationDot');
    const slipNotificationDotMobile = document.getElementById('slipNotificationDotMobile');
    if (slipButton) {
      slipButton.addEventListener('click', function() {
        fetch(window.appConfig.slipsMarkAsReadUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.appConfig.csrfToken
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success && slipNotificationDot) {
            slipNotificationDot.classList.remove('active');
          }
          if (data.success && slipNotificationDotMobile) {
            slipNotificationDotMobile.classList.remove('active');
          }
        })
        .catch(error => console.error('Gagal menandai slip sebagai dibaca:', error));
      });
    }

    const allowedRoles = ['Operator', 'Admin', 'Leader'];
    if (allowedRoles.includes(window.appConfig.userRole)) {
      fetch(window.appConfig.slipsCheckLatestPeriodUrl)
        .then(response => response.json())
        .then(data => {
          if (data.has_unread_slip && slipNotificationDot) {
            slipNotificationDot.classList.add('active');
          } else if (slipNotificationDot) {
            slipNotificationDot.classList.remove('active');
          }
          if (data.has_unread_slip && slipNotificationDotMobile) {
            slipNotificationDotMobile.classList.add('active');
          } else if (slipNotificationDotMobile) {
            slipNotificationDotMobile.classList.remove('active');
          }
        })
        .catch(error => console.error('Gagal memeriksa notifikasi slip:', error));
    }

    function toggleMobileNav() {
      const mobileNav = document.querySelector('.mobile-bottom-nav');
      if (window.innerWidth > 500) {
        mobileNav.style.display = 'none';
      } else {
        mobileNav.style.display = 'flex';
      }
    }

    window.addEventListener('load', toggleMobileNav);
    window.addEventListener('resize', toggleMobileNav);

    document.addEventListener('DOMContentLoaded', function() {
      const notif = document.getElementById('notif-success');
      if (notif) {
        setTimeout(() => {
          notif.style.display = 'none';
        }, 3500);
      }
    });
  </script>
</body>
</html>