<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body { opacity: 0; transition: opacity 0.5s ease; }
    body.fade-in { opacity: 1; }
    :root { --sidebar-width: 260px; --primary-color: #0d6efd; --hover-bg: #f8f9fa; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f3f5; margin: 0; padding: 0; }
    .wrapper { display: flex; min-height: 100vh; }
    .sidebar { width: var(--sidebar-width); background-color: #fff; box-shadow: 2px 0 10px rgba(0,0,0,0.05); padding: 2rem 1rem; }
    .sidebar h2 { font-size: 1.5rem; color: var(--primary-color); margin-bottom: 1.5rem; }
    .sidebar .nav-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.375rem; color: #495057; text-decoration: none; }
    .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: var(--hover-bg); color: var(--primary-color); }
    .content { flex: 1; padding: 2rem; }
    .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .content-header h1 { font-size: 1.75rem; margin: 0; }
  </style>
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2>Profil</h2>
      <nav class="nav flex-column">
        <a class="nav-link" href="{{ url('dashboard_profil') }}"><i class="fas fa-user"></i> Profil Saya</a>
        <a class="nav-link active" href="#"><i class="fas fa-pen"></i> Edit Profil</a>
        <a class="nav-link" href="{{ url('ganti_password') }}"><i class="fas fa-key"></i> Ganti Password</a>
        <a class="nav-link" href="{{ url('dashboard') }}"><i class="fas fa-right-from-bracket"></i> Keluar</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="content">
      <div class="content-header">
        <h1>Edit Profil Saya</h1>
      </div>
      <section>
        <div class="bg-white p-4 rounded shadow-sm">
          <form method="POST" action="{{ route('profil.update', is_object($user) ? $user->id : '') }}" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="text-center mb-4">
              <img src="{{ asset(is_object($user) && isset($user->photo_url) ? $user->photo_url : 'img/default.jpg') }}" alt="Foto Profil" style="width:120px; height:120px; object-fit:cover; border-radius:50%;">
            </div>

            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Nama</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
              </div>
            </div>           
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-10">
                <input type="password" name="password" class="form-control" placeholder="Password">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Telepon</label>
              <div class="col-sm-10">
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Jabatan</label>
              <div class="col-sm-10">
                <input type="text" name="role" class="form-control" value="{{ old('role', $user->role) }}" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Bio</label>
              <div class="col-sm-10">
                <textarea name="bio" class="form-control" rows="4" required>{{ old('bio', $user->bio) }}</textarea>
              </div>
            </div>
            <div class="row mb-4">
              <label class="col-sm-2 col-form-label">URL Foto</label>
              <div class="col-sm-10">
                <input type="text" name="photo_url" class="form-control" value="{{ old('photo_url', $user->photo_url) }}">
                <small class="text-muted">Masukkan path gambar (contoh: img/user.jpg)</small>
              </div>
            </div>
            <div class="text-end">
              <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Perubahan</button>
              <a href="{{ url('dashboard_profil') }}" class="btn btn-secondary ms-2"><i class="fas fa-arrow-left"></i> Batal</a>
            </div>
          </form>
        </div>
      </section>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => document.body.classList.add('fade-in'), 50);
    });
  </script>
</body>
</html>
