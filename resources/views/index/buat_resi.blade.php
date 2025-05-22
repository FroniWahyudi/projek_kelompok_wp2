<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buat Resi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <h2 class="mb-4">Buat Resi Baru</h2>
  <form method="POST" action="{{ route('resi.store') }}">
    @csrf
    <div class="row g-3">
      <div class="col-md-6">
        <label for="kode" class="form-label">Kode Resi</label>
        <input type="text" name="kode" id="kode" class="form-control" required value="SPXID{{ old('kode', mt_rand(10000000, 99999999)) }}">
      </div>
      <div class="col-md-6">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
      </div>
      <div class="col-md-12">
        <label for="tujuan" class="form-label">Tujuan</label>
        <input type="text" name="tujuan" id="tujuan" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select" required>
          <option value="Pending" selected>Pending</option>
          <option value="Selesai">Selesai</option>
        </select>
      </div>
    </div>

    <hr>
    <h6>Daftar Item</h6>
    <div id="itemsContainer">
      <div class="row g-2 align-items-end mb-2 item-row">
        <div class="col-7">
          <label class="form-label">Nama Item</label>
          <input type="text" name="items[0][nama_item]" class="form-control" required>
        </div>
        <div class="col-3">
          <label class="form-label">Qty</label>
          <input type="number" name="items[0][qty]" class="form-control" min="1" value="1" required>
        </div>
        <div class="col-2 text-end">
          <button type="button" class="btn btn-outline-danger btn-sm remove-item">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      </div>
    </div>

    <button type="button" id="addItem" class="btn btn-outline-primary btn-sm mb-3">
      <i class="bi bi-plus-circle"></i> Tambah Item
    </button>

    <div class="d-flex justify-content-between mt-4">
     <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>

      <button type="submit" class="btn btn-primary">Simpan Resi</button>
    </div>
  </form>
</div>

<script>
let itemIndex = 1;
document.getElementById('addItem').addEventListener('click', () => {
  const container = document.getElementById('itemsContainer');
  const firstRow = container.querySelector('.item-row');
  const newRow = firstRow.cloneNode(true);
  newRow.querySelectorAll('input').forEach((input) => {
    if (input.name.includes('nama_item')) {
      input.name = `items[${itemIndex}][nama_item]`;
      input.value = '';
    } else if (input.name.includes('qty')) {
      input.name = `items[${itemIndex}][qty]`;
      input.value = 1;
    }
  });
  container.appendChild(newRow);
  itemIndex++;
});

document.addEventListener('click', function(e) {
  if (e.target.closest('.remove-item')) {
    const rows = document.querySelectorAll('.item-row');
    if (rows.length > 1) e.target.closest('.item-row').remove();
  }
});
</script>

</body>
</html>
