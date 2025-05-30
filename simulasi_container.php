<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Flex Container Saja</title>
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #fafafa;
    }

    /* ===== PARENT CONTAINER ===== */
    .container-parent {
      width: 100%;
      margin: 0 auto;
      padding: 20px 0;
    }

    /* ===== FLEX CONTAINER ===== */
    .flex-container {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      padding: 20px;
      background-color: #e0e0e0;
      border-radius: 8px;
      margin-bottom: 20px;
    }

    .flex-box-blue {
      flex: 1 1 calc(33.333% - 10px); /* Maks 3 per baris */
      min-width: 140px;
      background-color: #2196F3;
      color: white;
      padding: 20px;
      text-align: center;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .flex-box-green {
      flex: 1 1 calc(25% - 10px);
      min-width: 150px;
      background-color: #4CAF50;
      color: white;
      padding: 20px;
      text-align: center;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
      .flex-box-blue,
      .flex-box-green {
        flex: 1 1 calc(50% - 10px);
      }
    }

    @media (max-width: 480px) {
      .flex-box-blue,
      .flex-box-green {
        flex: 1 1 100%;
      }
    }
  </style>
</head>
<body>

<div class="container-parent">
  <!-- Flex Container (Hijau) -->
  <div class="flex-container">
    <?php
    for ($i = 1; $i <= 5; $i++) {
      echo "<div class='flex-box-green'>Flex Hijau $i</div>";
    }
    ?>
  </div>

</div>

</body>
</html>
