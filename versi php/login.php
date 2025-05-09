<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'naga_hytam');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $mysqli->prepare('SELECT id, name, role, photo_url, password FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password === $user['password']) { // Ganti dengan password_verify jika pakai hash
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Email atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Naga Hytam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f4f8;
    }
    .login-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      border: none;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
      max-width: 1000px;
      width: 100%;
    }
    .login-left {
      background: linear-gradient(to right, #e3f2fd, #e1f5fe);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      padding: 40px;
    }
    .login-left img {
      max-width: 100%;
      height: auto;
      margin-bottom: 30px;
    }
    .login-left h4 {
      font-weight: bold;
      color: #003366;
    }
    .login-left p {
      color: #4a4a4a;
      font-size: 0.95rem;
    }
    .form-label {
      font-weight: 500;
    }
    .logo-text {
      font-size: 1.5rem;
      font-weight: bold;
      color: #003366;
    }
    .logo-sub {
      font-size: 0.95rem;
      color: #555;
    }
    .form-control:focus {
      border-color: #007bff;
      box-shadow: none;
    }
    .password-wrapper {
      position: relative;
    }
    .toggle-password {
      position: absolute;
      top: 50%;
      right: 0.75rem;
      transform: translateY(-50%);
      border: none;
      background: transparent;
      cursor: pointer;
      color: #6c757d;
      padding: 0;
    }
  </style>
</head>
<body>
  <div class="container login-container">
    <div class="row login-card bg-white">
      <div class="col-md-6 login-left">
        <img src="img/ilustrasi_gudang.png" alt="Ilustrasi Gudang">
        <h4>Sistem Manajemen Perusahaan</h4>
        <p>Tingkatkan efisiensi dan produktivitas bisnis Anda</p>
      </div>
      <div class="col-md-6 p-5">
        <div class="mb-4 text-center">
          <img src="img/logo_naga_aja.png" alt="Logo" style="height: 60px;">
          <div class="logo-text mt-2">Naga Hytam</div>
          <div class="logo-sub">Sejahtera Abadi</div>
        </div>

        <?php if ($error): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
              type="email" 
              name="email" 
              id="email" 
              class="form-control" 
              placeholder="Masukkan email" 
              required 
              autofocus>
          </div>
          <div class="mb-3 d-flex justify-content-between align-items-center">
            <label for="password" class="form-label">Password</label>
            <a href="#" class="text-decoration-none small">Lupa password?</a>
          </div>
          <div class="mb-3 password-wrapper">
            <input 
              type="password" 
              name="password" 
              id="password" 
              class="form-control" 
              placeholder="Masukkan password" 
              required>
          </div>
          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" value="" id="remember">
            <label class="form-check-label" for="remember">Tampilkan password</label>
          </div>
          <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>

        <p class="text-center text-muted mt-4 mb-0" style="font-size: 0.85rem;">
          © <?= date('Y') ?> Naga Hytam Sejahtera Abadi. All rights reserved.
        </p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
  <script>
    function togglePassword() {
      const pwd = document.getElementById('password');
      const icon = document.getElementById('eye-icon');
      if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        pwd.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
    // Sync checkbox to toggle password visibility too
    document.getElementById('remember').addEventListener('change', function() {
      if (this.checked) {
        document.getElementById('password').type = 'text';
        document.getElementById('eye-icon').classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        document.getElementById('password').type = 'password';
        document.getElementById('eye-icon').classList.replace('fa-eye-slash', 'fa-eye');
      }
    });
  </script>
</body>
</html>
