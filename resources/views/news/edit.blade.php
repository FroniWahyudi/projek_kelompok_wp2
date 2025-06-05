<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Naga Hytam Sejahtera Abadi</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background-color: #f0f4f8; /* Peringkat 1: Latar belakang utama */
      color: #003366; /* Peringkat 5: Teks utama */
      padding-top: 2rem;
      padding-bottom: 2rem;
    }
    
    .card-container {
      max-width: 800px;
      margin: 0 auto;
    }
    
    .form-card {
      background-color: #ffffff; /* Peringkat 2: Latar kartu */
      border: none;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      padding: 2rem;
      position: relative;
      overflow: hidden;
    }
    
    .form-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 8px;
      height: 100%;
      background: linear-gradient(to bottom, #e3f2fd, #e1f5fe); /* Peringkat 4: Gradien sisi kiri */
    }
    
    .form-title {
      color: #003366; /* Peringkat 5: Teks utama */
      font-weight: 600;
      margin-bottom: 1.5rem;
      border-bottom: 2px solid #e3f2fd;
      padding-bottom: 0.75rem;
    }
    
    .form-label {
      color: #003366; /* Peringkat 5: Teks utama */
      font-weight: 500;
      margin-bottom: 0.5rem;
    }
    
    .form-control, .form-control:focus {
      border-color: #e3f2fd;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
      color: #4a4a4a; /* Peringkat 6: Teks sekunder */
    }
    
    .form-control:focus {
      border-color: #007bff; /* Peringkat 3: Fokus input */
    }
    
    .btn-primary {
      background-color: #007bff; /* Peringkat 3: Tombol utama */
      border-color: #007bff;
      font-weight: 500;
      padding: 0.5rem 1.5rem;
    }
    
    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }
    
    .btn-secondary {
      background-color: #6c757d; /* Peringkat 7: Tombol sekunder */
      border-color: #6c757d;
      font-weight: 500;
      padding: 0.5rem 1.5rem;
    }
    
    .btn-secondary:hover {
      background-color: #5a6268;
      border-color: #545b62;
    }
    
    .alert-danger {
      border-left: 4px solid #dc3545;
    }
    
    .img-thumbnail {
      border: 1px solid #e3f2fd;
      border-radius: 5px;
      max-width: 100%;
    }
    
    .form-footer {
      display: flex;
      gap: 0.75rem;
      flex-wrap: wrap;
      margin-top: 1.5rem;
      padding-top: 1rem;
      border-top: 1px solid #f0f4f8;
    }
    
    .form-section {
      margin-bottom: 1.5rem;
    }

    /* Custom styling untuk CKEditor */
    .ck-editor__editable {
      min-height: 200px;
    }
    
    .ck-editor__editable:not(.ck-editor__nested-editable) {
      border-color: #e3f2fd !important;
    }
    
    .ck-editor__editable:not(.ck-editor__nested-editable).ck-focused {
      border-color: #007bff !important;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1) !important;
    }

    /* Tombol Home floating */
    .home-button {
      position: fixed;
      top: 24px;
      left: 24px;
      z-index: 1050;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 12px;
      background-color: #fff;
      color: #007bff;
      border-radius: 50px;
      font-size: 1rem;
      font-weight: 600;
      text-decoration: none;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      border: 2px solid #dee2e6;
      transition: all 0.3s ease;
      animation: slideInUp 0.6s ease-out;
    }

    .home-button:hover {
      background-color: #007bff;
      color: #fff;
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
      .home-button {
        padding: 6px 10px;
        font-size: 0.9rem;
        top: 12px;
        left: 12px;
      }
    }
    @media (max-width: 576px) {
      .home-button {
        padding: 5px 8px;
        font-size: 0.85rem;
        top: 8px;
        left: 8px;
      }
    }
  </style>
</head>
<body>

<!-- Tombol Home floating -->
<a href="{{ url('dashboard') }}" class="home-button d-print-none" style="
  position: fixed;
  top: 24px;
  left: 24px;
  z-index: 1050;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 12px;
  background-color: #fff;
  color: #007bff;
  border-radius: 50px;
  font-size: 1rem;
  font-weight: 600;
  text-decoration: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  border: 2px solid #dee2e6;
  transition: all 0.3s ease;
  animation: slideInUp 0.6s ease-out;
">
  <i class="fas fa-home"></i> Home
</a>

<div class="container">
  <div class="card-container">
    <div class="form-card">
      <h2 class="form-title">
        <i class="bi bi-newspaper me-2"></i>
        Edit News
      </h2>
      
      @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Perhatian!</strong> Terdapat kesalahan pada input data:
          <ul class="mt-2 mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      
      @if ($edit === true)
      <form action="{{ route('whats_new.update', $news->id) }}" method="POST" enctype="multipart/form-data">
      @else
      <form action="{{ route('whats_new.store') }}" method="POST" enctype="multipart/form-data">
      @endif
          @csrf
          @if ($edit === true)
              @method('PUT')
          @endif
          
          <div class="form-section">
            <label for="title" class="form-label">Judul Berita</label>
            <input type="text" class="form-control form-control-lg" id="title" name="title"
            value="@if($edit === true){{ old('title', $news->title) }}@endif" required
            placeholder="Masukkan judul berita">
          </div>
          
          <div class="form-section">
            <label class="form-label">Foto</label>
            <!-- Preview Foto (lama/baru) di atas input file -->
            <div id="previewContainer"
                 class="mb-3{{ !($edit === true && $news->image_url) ? ' d-none' : '' }}">
              <label class="form-label text-muted">Preview Foto</label>
              <img
                id="previewPhoto"
                src="{{ ($edit === true && $news->image_url) ? asset($news->image_url) : '#' }}"
                data-old="{{ ($edit === true && $news->image_url) ? asset($news->image_url) : '#' }}"
                alt="Preview"
                class="img-thumbnail d-block"
                style="max-width: 200px;"
              >
            </div>
            <div class="input-group">
              <input type="file" name="photo" class="form-control" id="photoInput" accept="image/*">
              <button class="btn btn-outline-secondary" type="button" id="resetPhotoBtn">
                <i class="bi bi-x-circle"></i> Reset
              </button>
            </div>
            <div class="form-text text-muted">Unggah foto baru (format: JPG, PNG, maks 2MB)</div>
          </div>
          
          <div class="form-section">
            <label for="description" class="form-label">Deskripsi</label>
            <div id="editor-container">
              <!-- Toolbar container -->
              <div id="toolbar-container" style="border: 1px solid #e3f2fd; border-bottom: none; border-radius: 5px 5px 0 0; background: #f8f9fa;"></div>
              <!-- Editor container -->
              <div id="editor" style="border: 1px solid #e3f2fd; border-top: none; border-radius: 0 0 5px 5px; min-height: 200px; padding: 15px;">@if($edit === true){!! old('description', $news->description) !!}@endif</div>
            </div>
            <!-- Hidden textarea untuk menampung data dari CKEditor -->
            <textarea name="description" id="description" style="display: none;" required></textarea>
          </div>
          
          <div class="form-footer">
            <button type="submit" class="btn btn-primary">
              @if ($edit === true)
              <i class="bi bi-save me-1"></i> Perbarui
              @else
              <i class="bi bi-plus-circle me-1"></i> Buat Baru
              @endif
            </button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
              <i class="bi bi-x-circle me-1"></i> Batal
            </a>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- CKEditor 5 CDN - Build with Alignment -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/decoupled-document/ckeditor.js"></script>

<script>
  let editorInstance;

  // Initialize CKEditor
  DecoupledEditor
    .create(document.querySelector('#editor'), {
      toolbar: [
        'heading',
        '|',
        'bold',
        'italic',
        'underline',
        '|',
        'alignment',
        '|',
        'link',
        'bulletedList',
        'numberedList',
        '|',
        'outdent',
        'indent',
        '|',
        'insertImage',
        'insertTable',
        'blockQuote',
        'mediaEmbed',
        '|',
        'undo',
        'redo',
        '|',
        'fontColor',
        'fontBackgroundColor',
        'fontSize',
        'fontFamily'
      ],
      alignment: {
        options: ['left', 'center', 'right', 'justify']
      },
      language: 'id',
      image: {
        toolbar: [
          'imageTextAlternative',
          'imageStyle:inline',
          'imageStyle:block',
          'imageStyle:side',
          '|',
          'toggleImageCaption',
          'imageResize'
        ]
      },
      table: {
        contentToolbar: [
          'tableColumn',
          'tableRow',
          'mergeTableCells',
          'tableCellProperties',
          'tableProperties'
        ]
      },
      licenseKey: '',
      placeholder: 'Tulis deskripsi lengkap berita di sini...',
      // Konfigurasi upload gambar (opsional)
      ckfinder: {
        uploadUrl: '/path/to/your/upload/script'
      }
    })
    .then(editor => {
      editorInstance = editor;
      
      // Insert toolbar into the page
      document.querySelector('#toolbar-container').appendChild(editor.ui.view.toolbar.element);
      
      // Sync CKEditor content dengan textarea tersembunyi
      editor.model.document.on('change:data', () => {
        document.querySelector('#description').value = editor.getData();
      });
      
      // Set initial value untuk textarea tersembunyi
      document.querySelector('#description').value = editor.getData();
    })
    .catch(error => {
      console.error('Error initializing CKEditor:', error);
    });

  // Preview photo sebelum upload & reset ke foto lama jika reset
  const photoInput = document.getElementById('photoInput');
  const previewPhoto = document.getElementById('previewPhoto');
  const previewContainer = document.getElementById('previewContainer');
  const oldSrc = previewPhoto.getAttribute('data-old');

  photoInput.addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        previewPhoto.src = e.target.result;
        previewContainer.style.display = 'block';
      }
      reader.readAsDataURL(file);
    } else {
      // Jika tidak ada file baru, kembalikan ke foto lama
      if (oldSrc && oldSrc !== '#') {
        previewPhoto.src = oldSrc;
        previewContainer.style.display = 'block';
      } else {
        previewPhoto.src = '#';
        previewContainer.style.display = 'none';
      }
    }
  });

  document.getElementById('resetPhotoBtn').addEventListener('click', function() {
    photoInput.value = '';
    if (oldSrc && oldSrc !== '#') {
      previewPhoto.src = oldSrc;
      previewContainer.style.display = 'block';
    } else {
      previewPhoto.src = '#';
      previewContainer.style.display = 'none';
    }
  });

  // Form submission handler untuk memastikan data CKEditor tersimpan
  document.querySelector('form').addEventListener('submit', function(e) {
    if (editorInstance) {
      document.querySelector('#description').value = editorInstance.getData();
    }
  });
</script>
</body>
</html>