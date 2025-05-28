<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    :root {
      --primary-color: #4e73df;
      --secondary-color: #f8f9fc;
      --accent-color: #2e59d9;
      --text-color: #5a5c69;
      --light-gray: #dddfeb;
    }
    
    body {
      background-color: var(--secondary-color);
      color: var(--text-color);
      font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      min-height: 100vh;
      padding-top: 2rem;
      background-image: linear-gradient(180deg, var(--secondary-color) 10%, #d2d6de 100%);
      background-size: cover;
    }
    
    .profile-card {
      border-radius: 15px;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
      transition: all 0.3s;
      border: none;
      overflow: hidden;
      padding: 4%;
    }
    
    .profile-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
    }
    
    .user-avatar {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 5px solid white;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
      transition: all 0.3s;
    }
    
    .user-avatar:hover {
      transform: scale(1.05);
    }
    
    .user-name {
      font-weight: 600;
      color: var(--primary-color);
      margin-top: 1rem;
    }
    
    .user-email {
      color: var(--text-color);
      font-size: 0.9rem;
    }
    
    .about-section {
      background-color: rgba(78, 115, 223, 0.05);
      border-radius: 10px;
      padding: 1rem;
      margin-top: 1.5rem;
    }
    
    .about-title {
      color: var(--primary-color);
      font-weight: 600;
      font-size: 1rem;
    }
    
    .about-text {
      font-size: 0.85rem;
      color: var(--text-color);
    }
    
    .form-label {
      font-weight: 600;
      color: var(--text-color);
      font-size: 0.9rem;
    }
    
    .form-control {
      border-radius: 8px;
      border: 1px solid var(--light-gray);
      padding: 0.6rem 0.75rem;
      font-size: 0.9rem;
      transition: all 0.3s;
    }
    
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }
    
    .section-title {
      color: var(--primary-color);
      font-weight: 700;
      font-size: 1.1rem;
      margin-bottom: 1.5rem;
      position: relative;
      padding-bottom: 0.5rem;
    }
    
    .section-title::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: 0;
      width: 50px;
      height: 3px;
      background-color: var(--primary-color);
      border-radius: 3px;
    }
    
    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      border-radius: 8px;
      padding: 0.5rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s;
    }
    
    .btn-primary:hover {
      background-color: var(--accent-color);
      border-color: var(--accent-color);
      transform: translateY(-2px);
    }
    
    .btn-secondary {
      border-radius: 8px;
      padding: 0.5rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s;
    }
    
    .btn-secondary:hover {
      transform: translateY(-2px);
    }
    
    .file-upload {
      position: relative;
      overflow: hidden;
      margin-top: 1rem;
    }
    
    .file-upload-input {
      position: absolute;
      font-size: 100px;
      opacity: 0;
      right: 0;
      top: 0;
    }
    
    .file-upload-btn {
      display: inline-block;
      background-color: white;
      color: var(--primary-color);
      border: 1px solid var(--primary-color);
      border-radius: 8px;
      padding: 0.5rem 1rem;
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .file-upload-btn:hover {
      background-color: var(--primary-color);
      color: white;
    }
    
    .file-upload-name {
      font-size: 0.8rem;
      color: var(--text-color);
      margin-top: 0.5rem;
      display: none;
    }
    
    .social-links {
      margin-top: 1.5rem;
    }
    
    .social-link {
      display: inline-block;
      width: 35px;
      height: 35px;
      border-radius: 50%;
      background-color: rgba(78, 115, 223, 0.1);
      color: var(--primary-color);
      text-align: center;
      line-height: 35px;
      margin-right: 0.5rem;
      transition: all 0.3s;
    }
    
    .social-link:hover {
      background-color: var(--primary-color);
      color: white;
      transform: translateY(-3px);
    }
    
    @media (max-width: 768px) {
      .profile-card {
        margin-bottom: 1.5rem;
      }
      
      .user-avatar {
        width: 100px;
        height: 100px;
      }
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in {
      animation: fadeIn 0.6s ease-out forwards;
    }
    
    ::-webkit-scrollbar {
      width: 8px;
    }
    
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }
    
    ::-webkit-scrollbar-thumb {
      background: var(--primary-color);
      border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
      background: var(--accent-color);
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <h2 class="text-center mb-4" style="color: var(--primary-color); font-weight: 700;">
          <i class="fas fa-user-edit me-2"></i>Edit Profil
        </h2>
        
        <form action="{{ isset($user) && is_object($user) ? route('profil.update', $user->id) : '#' }}" method="POST" enctype="multipart/form-data" class="fade-in">
          @csrf
          @if(isset($user) && is_object($user))
            @method('PUT')
          @endif
          
          <div class="row">
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
                  
                  <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-8 mt-4 mt-lg-0">
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
                      <label for="email" class="form-label">Email</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" placeholder="Masukkan alamat email">
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
                      <label for="password" class="form-label">Password</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru (kosongkan jika tidak ingin mengubah)">
                      </div>
                      <small class="text-muted">Minimal 8 karakter</small>
                    </div>
                    
                    <div class="col-12 mb-3">
                      <label for="bio" class="form-label">Bio</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-pen"></i></span>
                        <input type="text" class="form-control" id="bio" name="bio" value="{{ old('bio', $user->bio ?? '') }}" placeholder="Deskripsi singkat tentang diri Anda">
                      </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                      <label for="role" class="form-label">Peran</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                        <input type="text" class="form-control" id="role" name="role" value="{{ old('role', $user->role ?? '') }}" placeholder="Masukkan peran Anda">
                      </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                      <label for="alamat" class="form-label">Alamat</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $user->alamat ?? '') }}" placeholder="Masukkan alamat lengkap">
                      </div>
                    </div>
                  </div>
                  
                  <div class="d-flex justify-content-between mt-4">
                    <a href="{{ url('/') }}" class="btn btn-secondary"><i class="fas fa-home me-1"></i> Home</a>
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
      
      const form = document.querySelector('form');
      form.addEventListener('submit', function(e) {
        const password = document.getElementById('password');
        if (password.value && password.value.length < 8) {
          e.preventDefault();
          alert('Password harus minimal 8 karakter');
          password.focus();
        }
      });
    });
  </script>
</body>
</html>