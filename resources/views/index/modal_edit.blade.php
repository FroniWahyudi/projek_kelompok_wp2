<!-- Internal CSS untuk Photo Upload -->
<style>
    /* Container photo upload */
    .photo-upload {
        position: absolute;
        top: 1rem;
        right: 9.5rem;
        width: 160px;
        padding: 0.75rem;
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        z-index: 1050;
        text-align: center;
    }

    /* Label */
    .photo-upload .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #495057;
    }

    /* Wrapper preview */
    .photo-upload .preview-wrapper {
        margin-bottom: 3rem;
    }

    /* Gambar preview */
    .photo-upload #photoPreview {
        width: 208px;
        height: 200px;
        object-fit: cover;
        border-radius: 10%;
        border: 1px solid #dee2e6;
    }

    /* File input: full-width dalam container dan rata kiri */
    .photo-upload .form-control-sm {
        width: 90%;
        font-size: 0.8rem;
        padding: 0.25rem;
        margin-left: 12px; /* Hilangkan margin top */
    }

    /* Override agar tidak tergulung oleh scroll modal-body */
    .photo-upload {
        position: sticky;
        top: 0rem;
        right: -0.5rem; /* Sesuaikan jika perlu, atau hapus jika sticky sudah cukup */
        float: right; /* Biar tetap berada di sisi kanan konten */
        margin-left: -17rem;
        height: 340px;
        width: 270px;
    }

    .modal-dialog-scrollable .modal-content {
        max-height: 100%;
        overflow: hidden;
        width: 750px;
    }
</style>

<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Edit User: {{ $user['name'] }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <form id="formEditUser" method="POST" action="{{ route('operator.update', $user['id']) }}" enctype="multipart/form-data">
        <div class="modal-body position-relative" style="max-height:70vh; overflow-y:auto; padding-right: 10px;">
            @csrf
            @method('PUT')

            <!-- PHOTO UPLOAD (tanpa inline CSS lagi) -->
            <div class="photo-upload">
                <label class="form-label">Photo</label>
                <div class="preview-wrapper text-center">
                    <img id="photoPreview" src="{{ $user['photo_url'] ?? asset('images/default-user.png') }}" alt="Preview Foto">
                </div>
                <input type="file" name="photo" class="form-control form-control-sm" accept="image/*">
            </div>

            <!-- FORM UTAMA -->
            <input type="hidden" name="id" value="{{ $user['id'] }}">

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user['name']) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user['email']) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <input type="text" name="role" class="form-control" value="{{ old('role', $user['role']) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Password (kosongkan jika tidak mau diubah)</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user['phone'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-control" rows="3">{{ old('bio', $user['bio'] ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $user['alamat'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Joined At</label>
                <input type="date" name="joined_at" class="form-control" value="{{ old('joined_at', $user['joined_at'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Education</label>
                <input type="text" name="education" class="form-control" value="{{ old('education', $user['education'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <input type="text" name="department" class="form-control" value="{{ old('department', $user['department'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Level</label>
                <input type="text" name="level" class="form-control" value="{{ old('level', $user['level'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Job Descriptions</label>
                <textarea name="job_descriptions" class="form-control" rows="2">{{ old('job_descriptions', $user['job_descriptions'] ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Skills</label>
                <input type="text" name="skills" class="form-control" value="{{ old('skills', $user['skills'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Achievements</label>
                <textarea name="achievements" class="form-control" rows="2">{{ old('achievements', $user['achievements'] ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Divisi</label>
                <textarea name="divisi" class="form-control" rows="2">{{ old('divisi', $user['divisi'] ?? '') }}</textarea>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
    </form>
</div>

<script>
    // Preview photo sebelum submit
    const fileInput = document.querySelector('input[name="photo"]');
    const previewImg = document.getElementById('photoPreview');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });

    // AJAX submit tetap bisa; FormData sudah otomatis mendukung file
    document.getElementById('formEditUser').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const data = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: data
        })
        .then(res => res.json())
        .then(json => {
            if (json.success) {
                const modalEl = document.querySelector('.modal.show');
                bootstrap.Modal.getInstance(modalEl).hide();
                location.reload();
            } else {
                alert('Gagal menyimpan perubahan');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error saat menyimpan');
        });
    });
</script>