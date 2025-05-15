<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Profil</title>
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
        <a class="nav-link" href="{{ url('dashboard') }}"> <i class="fas fa-home"></i> Home</a>
        <a class="nav-link active" href="{{ url('dashboard_profil') }}"><i class="fas fa-user"></i>Profil Saya</a>
        <a class="nav-link" href="{{ url('ganti_password') }}"><i class="fas fa-key"></i>Ganti Password</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="content">
      <div class="content-header">
        <h1>Profil Saya</h1>
      </div>
      <section>
        <div class="bg-white p-4 rounded shadow-sm text-center">
          <img src="{{ asset($user->photo_url) }}" alt="Foto Profil" style="width:120px; height:120px; object-fit:cover; border-radius:50%; margin-bottom:1rem;">
          <h3>{{ $user->name }}</h3>
          <hr>
          <div class="text-start">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Telepon:</strong> {{ $user->phone }}</p>
            <p><strong>Jabatan:</strong> {{ $user->role }}</p>
            <p><strong>Bio:</strong> {{ $user->bio }}</p>
          </div>
          <div class="text-end mt-3">
            <a href="{{ url('edit_profil/' . $user->id) }}" class="btn btn-primary">
              <i class="fas fa-pen"></i> Edit Profil
            </a>
          </div>
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
