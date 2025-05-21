@unless(request()->has('ajax'))
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manajemen Dashboard - Naga Hytam Sejahtera Abadi</title>
    @vite([
        'resources/js/app.js',
        'resources/sass/app.scss',
        'resources/css/app.css'
    ])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            font-size: .9rem;
            color: #6c757d;
            background: #f8f9fa;
        }
        main {
            flex: 1;
            padding-top: 70px;
        }
        .navbar-custom {
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: .5rem 1rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-weight: 600;
            color: #495057;
            text-decoration: none;
        }
        .navbar-brand .dot {
            width: 10px;
            height: 10px;
            background: #00c8c8;
            border-radius: 50%;
            display: inline-block;
        }
        .navbar-nav .nav-link {
            margin-left: 1.5rem;
            color: #6c757d;
        }
        .navbar-nav .nav-link.active {
            color: #0d6efd;
            font-weight: 500;
        }
        .manager-card {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: .5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,.05);
            padding: 1.5rem;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 1.5rem;
            transition: transform .2s;
            min-height: 250px;
        }
        .manager-card:hover {
            transform: translateY(-5px);
        }
        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #dee2e6;
            aspect-ratio: 1 / 1;
            display: block;
        }
        .manager-info h5 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #495057;
        }
        .manager-info .role {
            font-size: .9rem;
            color: #00c8c8;
            font-weight: 500;
        }
        .manager-info p {
            margin: .5rem 0;
            line-height: 1.5;
        }
        .footer {
            background: #fff;
            border-top: 1px solid #dee2e6;
            padding: 1rem 0;
            text-align: center;
        }
        .form-control {
            display: block;
            width: 373px;
            margin-left: 37px;
        }
        .main-container {
            margin-top: 25px;
        }
        .navbar-expand-lg .navbar-collapse {
            margin-right: 21px;
        }
        button.active {
            background-color: #0d6efd;
            color: white;
        }
        #operator-list {
    min-height: 400px; /* atur sesuai kira-kira jumlah card minimal */
    transition: all 0.3s ease; /* animasi halus jika isi berubah */
    margin-top: 0; /* hindari margin tambahan */
}
.mb-3 {
    margin-bottom: 0rem !important;
}
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('dashboard') }}"><span class="dot"></span>Divisi Operator</a>
            <div class="d-flex ms-3">
                <input
                    class="form-control me-2"
                    type="search"
                    placeholder="Cari nama operator..."
                    aria-label="Cari"
                    id="searchInput"
                    value="{{ request('search') }}"
                />
            </div>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navMenu">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ url('dashboard') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('manajemen') }}">Manajer</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin') }}">Admin</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('leader') }}">Leader</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ url('operator') }}">Operator</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container py-5 main-container">

       <div class="mb-3">
    <button id="btnAll" class="btn btn-outline-secondary">Semua</button>
    <button id="btnFilterInbound" class="btn btn-outline-primary">Inbound</button>
    <button id="btnFilterOutbound" class="btn btn-outline-success">Outbound</button>
    <button id="btnFilterStorage" class="btn btn-outline-warning">Storage</button>
</div>

@endunless
        <div class="row g-4" id="operator-list">
            @forelse($Operator as $op)
                <div class="col-md-6">
                    <div class="manager-card" data-divisi="{{ strtolower($op->divisi) }}">
                        <img src="{{ asset($op->photo_url) }}" alt="{{ $op->name }}" class="profile-photo">
                        <div class="manager-info">
                            <h5>{{ $op->name }}</h5>
                            <div class="role">{{ $op->role }} <span class="badge bg-info text-dark ms-2">{{ $op->level }}</span></div>
                            <p>{{ $op->email }}</p>
                            <p>{{ $op->divisi }}</p>
                            <p>{{ Str::limit($op->bio, 100) }}</p>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $op->id }}">Detail</button>
                            @if(Auth::user() && Auth::user()->role === 'Admin')
                                <button
                                    class="btn btn-warning btn-sm btn-edit ms-2"
                                    data-id="{{ $op->id }}"
                                    title="Edit Profil Operator"
                                >
                                    Edit
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Modal Detail -->
                <div class="modal fade" id="detailModal{{ $op->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $op->name }} — Detail Profil</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex align-items-center mb-4">
                                    <img src="{{ asset($op->photo_url) }}" class="profile-photo me-3" alt="">
                                    <div>
                                        <h6>{{ $op->name }}</h6>
                                        <small class="role">
                                            {{ $op->role }}
                                            <span class="badge bg-info text-dark ms-2">{{ $op->level }}</span>
                                        </small>
                                        <p class="mt-2"><i class="bi bi-envelope me-1"></i> {{ $op->email }}</p>
                                        <p><i class="bi bi-telephone me-1"></i> {{ $op->phone }}</p>
                                    </div>
                                </div>
                                <h6>Informasi Pribadi</h6>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <strong>Alamat:</strong><br>
                                        {{ $op->alamat }}
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Joined:</strong><br>
                                        {{ \Carbon\Carbon::parse($op->joined_at)->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-6">
                                        <strong>Pendidikan:</strong><br>
                                        {{ $op->education }}
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Departemen:</strong><br>
                                        {{ $op->department }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Divisi:</strong><br>
                                    {{ $op->divisi }}
                                </div><br>
                                <h6><strong>Bio</strong></h6>
                                <p>{{ $op->bio }}</p>
                                <h6><strong>Deskripsi Pekerjaan</strong></h6>
                                <ul>
                                    @foreach(explode(', ', $op->job_descriptions) as $jd)
                                        <li>{{ $jd }}</li>
                                    @endforeach
                                </ul>
                                <h6><strong>Keahlian</strong></h6>
                                <p>
                                    @foreach(explode(', ', $op->skills) as $s)
                                        <span class="badge bg-secondary me-1">{{ $s }}</span>
                                    @endforeach
                                </p>
                                <h6><strong>Pencapaian</strong></h6>
                                <ul>
                                    @foreach(explode(', ', $op->achievements) as $a)
                                        <li>{{ $a }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">Tidak ada operator ditemukan.</div>
                </div>
            @endforelse
        </div>
@unless(request()->has('ajax'))
    </main>
    <footer class="footer">
        <small>© {{ date('Y') }} PT Naga Hytam Sejahtera Abadi.</small>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('searchInput');
    const list = document.getElementById('operator-list');


    if (!input || !list) return;

    let timeout = null;

    // Fungsi untuk set tombol aktif
    const setActiveButton = (activeBtn) => {
        buttons.forEach(btn => {
            if (btn) btn.classList.remove('active');
        });
        if (activeBtn) activeBtn.classList.add('active');
    };

    // Pencarian input
    input.addEventListener('input', () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            fetch(`{{ url('operator') }}?search=${encodeURIComponent(input.value)}&ajax=1`)
                .then(res => res.text())
                .then(html => {
                    list.innerHTML = html;
                    setActiveButton(null); // Hilangkan highlight tombol saat input
                })
                .catch(err => console.error('Search error:', err));
        }, 300);
    });

    // Filter: All
    const buttons = {
      all: document.getElementById('btnAll'),
      inbound: document.getElementById('btnFilterInbound'),
      outbound: document.getElementById('btnFilterOutbound'),
      storage: document.getElementById('btnFilterStorage'),
    };
    const cards = document.querySelectorAll('#operator-list .manager-card');

    function setActive(btn) {
      // reset all
      Object.values(buttons).forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
    }

    function filterBy(divisi) {
      cards.forEach(card => {
        const d = card.dataset.divisi;
        card.parentElement.style.display =
          (divisi === 'all' || d.includes(divisi))
            ? ''   // show
            : 'none'; // hide
      });
    }

    // wire up
    buttons.all.addEventListener('click', () => {
      setActive(buttons.all);
      filterBy('all');
    });
    buttons.inbound.addEventListener('click', () => {
      setActive(buttons.inbound);
      filterBy('inbound');
    });
    buttons.outbound.addEventListener('click', () => {
      setActive(buttons.outbound);
      filterBy('outbound');
    });
    buttons.storage.addEventListener('click', () => {
      setActive(buttons.storage);
      filterBy('storage');
    });

    // initialize to “All”
    setActive(buttons.all);
  });

        document.addEventListener('click', function(e) {
            if (!e.target.matches('.btn-edit')) return;
            const id = e.target.dataset.id;
            const modalEl = document.getElementById('editModal');
            const modal = new bootstrap.Modal(modalEl);
            fetch(`{{ url('operator') }}/${id}/edit`)
                .then(r => r.text())
                .then(html => {
                    modalEl.querySelector('.modal-dialog').innerHTML = html;
                    modal.show();
                })
                .catch(() => alert('Gagal memuat form edit.'));
        });

        document.addEventListener('submit', function(e) {
            if (e.target.id !== 'formEditUser') return;
            e.preventDefault();
            const form = e.target;
            const data = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: data
            })
            .then(r => {
                if (!r.ok) throw new Error('Gagal');
                return r.json();
            })
            .then(json => {
                if (json.success) {
                    bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                    window.location.href = '{{ url("operator") }}';
                } else {
                    alert('Gagal menyimpan perubahan.');
                }
            })
            .catch(() => alert('Error saat menyimpan'));
        });
    </script>
    <!-- Modal kosong untuk AJAX EDIT -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <!-- konten akan di-overwrite oleh JS -->
        </div>
    </div>
</body>
</html>
@endunless