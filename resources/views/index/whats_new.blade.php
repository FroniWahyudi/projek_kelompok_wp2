<?php
// whats_new.php
/*
define('DB_HOST', 'localhost');
define('DB_NAME', 'naga_hytam');
define('DB_USER', 'root');
define('DB_PASS', '');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("Invalid ID.");
}

$stmt = $mysqli->prepare("SELECT id, title, date, image_url, description, link FROM news WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    die("News item not found.");
}
$item = $result->fetch_assoc();

$stmt->close();
$mysqli->close();

// Prepare description preview
$fullDesc = nl2br(htmlspecialchars($item['description']));
$previewLimit = 200;
$rawDesc = htmlspecialchars($item['description']);
if (strlen($rawDesc) > $previewLimit) {
    $shortDesc = nl2br(htmlspecialchars(substr($item['description'], 0, $previewLimit)));
    $isLong = true;
} else {
    $shortDesc = $fullDesc;
    $isLong = false;
}*/
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>{{ $item['title'] }} – What's New</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <style>
    .container-fluid { width: 85%; max-width: 1200px; margin: 2% auto; padding: 0; }
    .card { width: 100%; margin-bottom: 2%; background: #fff; border: 1px solid #ddd; border-radius: .25rem; }
    .card-img-top { display: block; width: 80%; margin: 0 auto 1.5%; height: auto; max-height: 400px; object-fit: contain; background: #fff; padding: 1% 0; }
    .card-body { padding: 2%; }
    .card-title { font-size: 2em; margin-bottom: 1%; }
    .text-muted { font-size: 1em; margin-bottom: 1.5%; }
    .card-text { font-size: 1em; margin-bottom: 1.5%; }
    .btn { padding: 1% 2%; font-size: 1em; }
    .back-btn { display: inline-block; margin-bottom: 2%; padding: 1% 2%; }
  </style>
</head>
<body>
  <div class="container-fluid">
    <a href="/dashboard" class="btn btn-secondary back-btn">&larr; Kembali ke daftar</a>
    <div class="card">
      <img src="{{ asset($item['image_url']) }}" class="card-img-top" alt="{{ $item['title'] }}">
      <div class="card-body">
        <h2 class="card-title">{{ $item['title'] }}</h2>
        <p class="text-muted">{{ $item['date'] }}</p>
        <p class="card-text">
          <span id="short-text">{!! $shortDesc !!}{{ $isLong ? '...' : '' }}</span>
          @if ($isLong)
            <span id="full-text" style="display:none;">{!! $fullDesc !!}</span>
          @endif
        </p>
        @if ($isLong)
          <button id="read-more" class="btn btn-primary">Baca selengkapnya</button>
        @elseif (!empty($item['link']))
          <a href="{{ $item['link'] }}" class="btn btn-primary">Baca selengkapnya</a>
        @endif
      </div>
    </div>
    
    <!-- Tombol Home di bawah konten -->
    <div class="text-center mt-4">
      <a href="/dashboard" class="btn btn-secondary">
        <i class="bi bi-house-door-fill"></i> Home
      </a>
    </div>
  </div>

  @if ($isLong)
  <script>
    document.getElementById('read-more').addEventListener('click', function() {
      const shortText = document.getElementById('short-text');
      const fullText = document.getElementById('full-text');
      if (fullText.style.display === 'none') {
        shortText.style.display = 'none';
        fullText.style.display = 'block';
        this.textContent = 'Lihat lebih sedikit';
      } else {
        shortText.style.display = 'inline';
        fullText.style.display = 'none';
        this.textContent = 'Baca selengkapnya';
      }
    });
  </script>
  @endif
</body>
</html>
