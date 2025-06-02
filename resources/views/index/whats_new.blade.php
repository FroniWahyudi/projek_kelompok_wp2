<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>{{ $item['title'] }} – What's New</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-color: #f0f4f8;
      color: #555;
      font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
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
      background: #ffffff;
      border: none;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      overflow: hidden;
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
    }
    
    .card-title {
      font-size: 1.8rem;
      margin-bottom: 12px;
      color: #003366;
      font-weight: 600;
    }
    
    .date-text {
      font-size: 0.95rem;
      margin-bottom: 25px;
      color: #6c757d;
      font-weight: 400;
    }
    
    .card-text {
      font-size: 1.05rem;
      margin-bottom: 13px;
      color: #4a4a4a;
      line-height: 1.8;
    }
    
    /* Styling tombol sesuai permintaan */
    .btn {
      padding: 10px 22px;
      font-size: 1rem;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.2s ease;
      border: none;
    }
    
    .btn-primary {
      background-color: #007bff;
      color: white;
    }
    
    .btn-primary:hover, .btn-primary:focus {
      background-color: #0069d9;
      color: white;
    }
    
    .back-btn {
      display: inline-block;
      margin-bottom: 25px;
      padding: 10px 20px;
      background-color: transparent;
      color: #6c757d;
      border: 1px solid #e0e0e0;
      border-radius: 6px;
      font-size: 1rem;
      font-weight: 500;
      text-decoration: none;
      transition: all 0.2s ease;
    }
    
    .back-btn:hover {
      background-color: #f8f9fa;
      color: #003366;
      border-color: #d0d0d0;
    }
    
   .back-text {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1000;
    display: inline-block;
    padding: 9px 10px;
    font-weight: 500;
    color: #007bff;
    text-decoration: none;
    transition: all 0.3s ease;
    background-color: rgba(255, 255, 255, 0.95);
    border: 1px solid #dee2e6;
    border-radius: 25px;
    font-size: 0.95rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}
    
    .back-text:hover {
      color: #0056b3;
      background-color: rgba(255, 255, 255, 1);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      text-decoration: none;
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
      
      .back-text {
        top: 15px;
        left: 15px;
        padding: 10px 16px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <!-- Tombol kembali floating -->
    <a href="/dashboard" class="back-text">&larr; Kembali ke Dashboard</a>
    
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