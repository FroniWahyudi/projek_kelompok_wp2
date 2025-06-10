<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <!-- Css Custom -->
  <link rel="stylesheet" href="{{ asset('css/edit_profil.css') }}">
</head>
<body>
  <!-- Home Button - positioned at top left -->
  <a href="{{ url('/') }}" class="btn btn-secondary home-button">
    <i class="fas fa-home me-1"></i> Home
  </a>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <h2 class="text-center mb-4" style="color: var(--primary-color); font-weight: 700;">
          <i class="fas fa-user-edit me-2"></i>Edit Profil
        </h2>
        <!-- Form 1: Informasi Pribadi -->
        <form action="{{ isset($user) && is_object($user) ? route('profil.update', $user->id) : '#' }}" method="POST" enctype="multipart/form-data" class="fade-in mb-4">
          @csrf
          @if(isset($user) && is_object($user))
            @method('PUT')
          @endif
          <div class="row">
            <!-- Left side: Personal Information Form -->
            <div class="col-lg-8 mb-4 mb-lg-0">
              <div class="profile-card h-100">
                <div class="card-body py-4">
                  <h5 class="section-title"><i class="fas fa-id-card me-2"></i>Informasi Pribadi</h5>
                 
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="name" class="form-label">Nama Lengkap</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" placeholder="Masukkan nama lengkap">
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="phone" class="form-label">Nomor Telepon</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="Masukkan nomor telepon">
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="alamat" class="form-label">Alamat</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $user->alamat ?? '') }}" placeholder="Masukkan alamat lengkap">
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="bio" class="form-label">Bio</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-pen"></i></span>
                        <input type="text" class="form-control" id="bio" name="bio" value="{{ old('bio', $user->bio ?? '') }}" placeholder="Deskripsi singkat tentang diri Anda">
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between mt-4">
                    <div class="d-flex">
                      <button type="reset" class="btn btn-secondary me-3">
                        <i class="fas fa-undo me-1"></i> Reset
                      </button>
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Right side: Profile Card with Photo -->
            <div class="col-lg-4">
              <div class="profile-card h-100">
                <div class="card-body text-center py-4">
                  <div class="user-avatar-wrapper position-relative d-inline-block">
                    <img src="{{ is_object($user) && isset($user->photo_url) ? asset($user->photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode(is_object($user) && isset($user->name) ? $user->name : 'User') . '&background=4e73df&color=fff&size=120' }}" 
                         alt="User Avatar" class="user-avatar mb-3" id="avatar-preview">
                    <div class="file-upload">
                      <label for="photo-upload" class="file-upload-btn">
                        <i class="fas fa-camera me-1"></i> Ganti Foto
                      </label>
                      <input type="file" name="photo" id="photo-upload" class="file-upload-input" accept="image/*">
                      <div class="file-upload-name" id="file-name"></div>
                    </div>
                  </div>
                  <h4 class="user-name">{{ is_object($user) && isset($user->name) ? $user->name : 'Nama Pengguna' }}</h4>
                  <p class="user-email">{{ is_object($user) && isset($user->email) ? $user->email : 'email@example.com' }}</p>
                  <div class="about-section">
                    <h5 class="about-title"><i class="fas fa-info-circle me-2"></i>Tentang Saya</h5>
                    <p class="about-text">{{ is_object($user) && isset($user->bio) ? $user->bio : 'Tidak ada deskripsi' }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        
        <!-- Form 2: Informasi Akun -->
        <form action="{{ isset($user) && is_object($user) ? route('profil.update.account', $user->id) : '#' }}" method="POST" class="fade-in">
          @csrf
          @if(isset($user) && is_object($user))
            @method('PUT')
          @endif
          <div class="row">
            <div class="col-lg-12">
              <div class="profile-card h-100">
                <div class="card-body py-4">
                  <h5 class="section-title"><i class="fas fa-id-card me-2"></i>Informasi Akun</h5>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="email" class="form-label">Email</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" placeholder="Masukkan alamat email">
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="password" class="form-label">Password Lama</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" placeholder="Masukkan password lama">
                        @error('old_password')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="password" class="form-label">Password Baru</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password baru (kosongkan jika tidak ingin mengubah)" minlength="8">
                        @error('password')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                        @enderror
                      </div>
                      <small class="text-muted">Minimal 8 karakter</small>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="password" class="form-label">Konfirmasi Password</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Masukkan password baru (kosongkan jika tidak ingin mengubah)">
                      </div>
                      <small class="text-muted">Minimal 8 karakter</small>
                    </div>
                  </div>
                  
                  <div class="d-flex justify-content-between mt-4">
                    <div class="d-flex">
                      <button type="reset" class="btn btn-secondary me-3">
                        <i class="fas fa-undo me-1"></i> Reset
                      </button>
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
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
@if(session('error'))
<div id="notif-error" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div class="toast align-items-center border-0 show" role="alert" aria-live="assertive" aria-atomic="true"
         style="background-color: #dc3545; color: #fff;">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const photoUpload = document.getElementById('photo-upload');
      const avatarPreview = document.getElementById('avatar-preview');
      const fileName = document.getElementById('file-name');
      
      photoUpload.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
          const file = e.target.files[0];
          const reader = new FileReader();
          
          reader.onload = function(event) {
            avatarPreview.src = event.target.result;
          };
          
          reader.readAsDataURL(file);
          
          fileName.textContent = file.name;
          fileName.style.display = 'block';
        }
      });
      
      setTimeout(() => {
        document.querySelector('.fade-in').classList.add('fade-in');
      }, 50);
      
      const cards = document.querySelectorAll('.profile-card');
      cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
          card.style.transform = 'translateY(-5px)';
          card.style.boxShadow = '0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2)';
        });
        
        card.addEventListener('mouseleave', () => {
          card.style.transform = '';
          card.style.boxShadow = '';
        });
      });

      // Reset avatar preview saat tombol reset diklik
      const originalAvatar = avatarPreview ? avatarPreview.src : null;

      if (form && avatarPreview) {
        form.addEventListener('reset', function() {
          setTimeout(() => {
            if (originalAvatar) avatarPreview.src = originalAvatar;
            if (fileName) {
              fileName.textContent = '';
              fileName.style.display = 'none';
            }
            if (photoUpload) photoUpload.value = '';
          }, 10); // beri jeda agar input lain juga ter-reset
        });
      }
    });
    
    document.addEventListener('DOMContentLoaded', function() {
    const notif = document.getElementById('notif-success');
    if (notif) {
        setTimeout(() => {
            notif.style.display = 'none';
        }, 3500);
    }
    });

    document.addEventListener('DOMContentLoaded', function() {
    const notifError = document.getElementById('notif-error');
    if (notifError) {
        setTimeout(() => {
            notifError.style.display = 'none';
        }, 3500);
    }
    });
  </script>
</body>
</html>