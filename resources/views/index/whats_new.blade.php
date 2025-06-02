<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>{{ $item['title'] }} – What's New</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
   :root {
  --primary-bg: #f0f4f8;
  --card-bg: #ffffff;
  --primary-action: #007bff;
  --gradient-start: #e3f2fd;
  --gradient-end: #e1f5fe;
  --primary-text: #003366;
  --secondary-text: #4a4a4a;
  --tertiary-text: #555;
  --minimal-action: #6c757d;
  --home-button-border: #dee2e6;
}

body {
  background-color: var(--primary-bg);
  color: var(--tertiary-text);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  line-height: 1.6;
}

.container-fluid {
  width: 85%;
  max-width: 900px;
  margin: 3% auto;
  padding: 0;
}

.card {
  width: 100%;
  margin-bottom: 2%;
  background: var(--card-bg);
  border: none;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  overflow: hidden;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
}

.card-img-container {
  background: #f8f9fa;
  padding: 25px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.card-img-top {
  display: block;
  width: 80%;
  max-width: 600px;
  height: auto;
  max-height: 350px;
  object-fit: contain;
  border-radius: 4px;
}

.card-body {
  padding: 30px;
  color: var(--tertiary-text);
}

.card-title {
  font-size: 1.8rem;
  margin-bottom: 12px;
  color: var(--primary-text);
  font-weight: 600;
}

.date-text {
  font-size: 0.95rem;
  margin-bottom: 25px;
  color: var(--minimal-action);
  font-weight: 400;
}

.card-text {
  font-size: 1.05rem;
  margin-bottom: 13px;
  color: var(--secondary-text);
  line-height: 1.8;
}

.btn {
  padding: 10px 22px;
  font-size: 1rem;
  border-radius: 6px;
  font-weight: 500;
  transition: all 0.2s ease;
  border: none;
}

.btn-primary {
  background-color: var(--primary-action);
  color: white;
  border-color: var(--primary-action);
}

.btn-primary:hover, .btn-primary:focus {
  background-color: #0069d9;
  border-color: #0062cc;
  color: white;
}

.back-btn {
  display: inline-block;
  margin-bottom: 25px;
  padding: 10px 20px;
  background-color: transparent;
  color: var(--minimal-action);
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  font-size: 1rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.2s ease;
}

.back-btn:hover {
  background-color: #f8f9fa;
  color: var(--primary-text);
  border-color: #d0d0d0;
}

.home-button {
  position: fixed;
  top: 24px;
  left: 24px;
  z-index: 1050;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 12px;
  background-color: var(--card-bg);
  color: var(--primary-action);
  border-radius: 50px;
  font-size: 1rem;
  font-weight: 600;
  text-decoration: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  border: 2px solid var(--home-button-border);
  transition: all 0.3s ease;
  animation: slideInUp 0.6s ease-out;
}

.home-button:hover {
  background-color: var(--primary-action);
  color: var(--card-bg);
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

.divider {
  height: 1px;
  background-color: #eaeaea;
  margin: 30px 0;
}

.action-container {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  margin-top: 15px;
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

@media (max-width: 768px) {
  .container-fluid {
    width: 92%;
    margin: 5% auto;
  }

  .card-img-container {
    padding: 15px;
  }

  .card-img-top {
    width: 95%;
  }

  .card-body {
    padding: 20px;
  }

  .card-title {
    font-size: 1.6rem;
  }

  .action-container {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }

  .home-button {
    padding: 6px 10px;
    font-size: 0.9rem;
  }
}

@media (max-width: 576px) {
  .home-button {
    padding: 5px 8px;
    font-size: 0.85rem;
  }
}
  </style>
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