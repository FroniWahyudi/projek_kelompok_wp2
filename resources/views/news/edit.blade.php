<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Naga Hytam Sejahtera Abadi</title>
  @vite([
      'resources/js/app.js',
      'resources/sass/app.scss',
      'resources/css/app.css'
      ])
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

<div class="container">
    <h2>Edit News</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title"
            value="@if($edit === true){{ old('title', $news->title) }}@endif" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Photo</label>
            @if($edit === true)
            <img src="{{ asset($news->image_url) }}" alt="Current Photo" class="img-thumbnail mb-2" style="max-width: 200px;">
            @endif
            <input type="file" name="photo" class="form-control mt-2">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required>@if($edit === true){{ old('description', $news->description) }}@endif</textarea>
        </div>
        <button type="submit" class="btn btn-primary">
            @if ($edit === true)
            Update
            @else
            Create
            @endif
        </button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>