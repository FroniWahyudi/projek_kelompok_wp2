<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>{{ $item['title'] }} – What's New</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Css Custom -->
  <link rel="stylesheet" href="{{ asset('css/whats_new.css') }}">
</head>
<body>
  <div class="container-fluid">
    <!-- Tombol kembali floating -->
   <a href="{{ url('dashboard') }}" class="home-button d-print-none">
      <i class="fas fa-home"></i> Home
    </a>
    
    <div class="card">
      <div class="card-img-container">
        <img src="{{ asset($item['image_url']) }}" class="card-img-top" alt="{{ $item['title'] }}">
      </div>
      <div class="card-body">
        <h2 class="card-title">{{ $item['title'] }}</h2>
        <p class="date-text">{{ $item['date'] }}</p>
        
        <div class="divider"></div>
        
        <p class="card-text">
          {!! $fullDesc !!}
        </p>
        

      </div>
    </div>
    
    <!-- Tombol Home di bawah konten -->
    <div class="text-center mt-4">
     
    </div>
  </div>
</body>
</html>