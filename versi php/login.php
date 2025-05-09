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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="bootstrap-5.3.5-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="package/font/bootstrap-icons.css">
  <style>
    body { background-color: #f4f4f4; }
    .login-box {
      max-width: 400px;
      margin: 100px auto;
      padding: 2rem;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .password-wrapper {
      position: relative;
    }
    .password-wrapper .toggle-password {
      position: absolute;
      top: 50%;
      right: 0.5rem;
      transform: translateY(10%);
      border: none;
      background: transparent;
      cursor: pointer;
      color: #6c757d;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h4 class="mb-4 text-center">Login Naga Hytam</h4>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="text" name="email" id="email" class="form-control" required autofocus>
    </div>
    <div class="mb-3 password-wrapper">
      <label for="password" class="form-label">Password</label>
      <input type="password" name="password" id="password" class="form-control" required>
      <button type="button" class="toggle-password" onclick="togglePassword()">
        <i id="eye-icon" class="fas fa-eye"></i>
      </button>
    </div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
  </form>
</div>

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
</script>

</body>
</html>
