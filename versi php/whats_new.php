<?php
declare(strict_types=1);
// whats_new.php

define('DB_HOST','localhost');
define('DB_NAME','naga_hytam');
define('DB_USER','root');
define('DB_PASS','');

$mysqli=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if($mysqli->connect_error){die('Connection failed: '.$mysqli->connect_error);}

$id=isset($_GET['id'])?intval($_GET['id']):0;
if($id<=0){die('Invalid ID.');}

$stmt=$mysqli->prepare('SELECT id,title,date,image_url,description,link FROM news WHERE id=?');
$stmt->bind_param('i',$id);
$stmt->execute();
$result=$stmt->get_result();
if($result->num_rows!==1){die('News item not found.');}
$item=$result->fetch_assoc();
$stmt->close();
$mysqli->close();

// prepare preview
$raw=htmlspecialchars($item['description']);
$limit=200;
$isLong=strlen($raw)>$limit;
$fullDesc=nl2br($raw);
$shortDesc=nl2br(htmlspecialchars(substr($item['description'],0,$limit)));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?=htmlspecialchars($item['title'])?> – What's New</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="bootstrap-5.3.5-dist\css\bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    .container-fluid{max-width:900px;margin:2rem auto;padding:0;}
    .card-img-top{width:100%;height:auto;max-height:400px;object-fit:contain;}
    .btn-icon{display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;border-radius:50%;border:none;background:#f0f0f0;font-size:1.25rem;color:#333;}
    .btn-icon:hover{background:#e0e0e0;}
    .back-text{margin-top:1rem;font-size:0.9rem;text-decoration:none;color:#6c757d;}
    .back-text:hover{text-decoration:underline;color:#343a40;}
  </style>
</head>
<body class="bg-light">
  <div class="container-fluid">
    <div class="card shadow mb-4">
      <?php if(!empty($item['image_url'])):?>
      <img src="<?=htmlspecialchars($item['image_url'])?>" class="card-img-top" alt="<?=htmlspecialchars($item['title'])?>">
      <?php endif;?>
      <div class="card-body">
        <h2 class="card-title"><?=htmlspecialchars($item['title'])?></h2>
        <p class="text-muted"><?=htmlspecialchars($item['date'])?></p>
        <p class="card-text">
          <span id="short-text"><?= $shortDesc?><?= $isLong?'...':''?></span>
          <?php if($isLong):?>
            <span id="full-text" style="display:none;"><?= $fullDesc?></span>
          <?php endif;?>
        </p>
        <?php if($isLong):?>
          <button id="read-more" class="btn btn-link p-0">Baca selengkapnya</button>
        <?php elseif(!empty($item['link'])):?>
    <a href="<?=htmlspecialchars($item['link'])?>" class="btn btn-link p-0">Baca selengkapnya</a>

        <?php endif;?>
        <!-- Tombol kembali tepat setelah teks -->
        <div>
          <a href="dashboard.php" class="back-text">&larr; Kembali ke Dashboard</a>
        </div>
      </div>
    </div>
  </div>
  <?php if($isLong):?>
  <script>
    const btn=document.getElementById('read-more'),shortText=document.getElementById('short-text'),fullText=document.getElementById('full-text');
    btn.addEventListener('click',()=>{
      if(fullText.style.display==='none'){
        shortText.style.display='none';fullText.style.display='block';btn.textContent='Lihat lebih sedikit';
      }else{
        shortText.style.display='inline';fullText.style.display='none';btn.textContent='Baca selengkapnya';
      }
    });
  </script>
  <?php endif;?>
</body>
</html>