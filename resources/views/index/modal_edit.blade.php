<style>
    /* Container photo upload */
    .photo-upload-edit {
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
    .photo-upload-edit .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #495057;
    }

    /* Wrapper preview */
    .photo-upload-edit .preview-wrapper-edit {
        margin-bottom: 3rem;
    }

    /* Gambar preview */
    .photo-upload-edit #photoPreviewEdit {
        width: 208px;
        height: 200px;
        object-fit: cover;
        border-radius: 10%;
        border: 1px solid #dee2e6;
    }

    /* File input: full-width dalam container dan rata kiri */
    .photo-upload-edit .form-control-sm {
        width: 90%;
        font-size: 0.8rem;
        padding: 0.25rem;
        margin-left: 12px;
    }

    /* Override agar tidak tergulung oleh scroll modal-body */
    .photo-upload-edit {
        position: sticky;
        top: 5rem;
        right: 1.5rem;
        float: right;
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
        @csrf
        @method('PUT')

        <!-- PHOTO UPLOAD -->
        <div class="photo-upload-edit">
            <label class="form-label">Photo</label>
            <div class="preview-wrapper-edit text-center">
                <img id="photoPreviewEdit" src="{{ $user['photo_url'] ?? asset('images/default-user.png') }}" alt="Preview Foto">
            </div>
            <input type="file" name="photo" class="form-control form-control-sm" accept="image/*">
        </div>

        <!-- FORM UTAMA -->
        <div class="modal-body position-relative" style="max-height:70vh; overflow-y:auto; padding-right: 10px;">
            <input type="hidden" name="id" value="{{ $user['id'] }}">

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user['name']) }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control" 
                    value="{{ old('email', $user['email']) }}" 
                    required
                >
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <input type="text" name="role" class="form-control" value="{{ old('role', $user['role']) }}">
                @error('role')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password (kosongkan jika tidak mau diubah)</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user['phone'] ?? '') }}">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-control" rows="3">{{ old('bio', $user['bio'] ?? '') }}</textarea>
                @error('bio')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $user['alamat'] ?? '') }}">
                @error('alamat')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Joined At</label>
                <input type="date" name="joined_at" class="form-control" value="{{ old('joined_at', $user['joined_at'] ?? '') }}">
                @error('joined_at')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Education</label>
                <input type="text" name="education" class="form-control" value="{{ old('education', $user['education'] ?? '') }}">
                @error('education')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <input type="text" name="department" class="form-control" value="{{ old('department', $user['department'] ?? '') }}">
                @error('department')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Level</label>
                <input type="text" name="level" class="form-control" value="{{ old('level', $user['level'] ?? '') }}">
                @error('level')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Job Descriptions</label>
                <textarea name="job_descriptions" class="form-control" rows="2">{{ old('job_descriptions', $user['job_descriptions'] ?? '') }}</textarea>
                @error('job_descriptions')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Skills</label>
                <input type="text" name="skills" class="form-control" value="{{ old('skills', $user['skills'] ?? '') }}">
                @error('skills')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Achievements</label>
                <textarea name="achievements" class="form-control" rows="2">{{ old('achievements', $user['achievements'] ?? '') }}</textarea>
                @error('achievements')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Divisi</label>
                <textarea name="divisi" class="form-control" rows="2">{{ old('divisi', $user['divisi'] ?? '') }}</textarea>
                @error('divisi')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.querySelector('#formEditUser input[name="photo"]');
        const previewImg = document.getElementById('photoPreviewEdit');

        if (fileInput && previewImg) {
            console.log('Edit modal: File input and preview image found:', fileInput, previewImg);
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) {
                    console.log('Edit modal: No file selected');
                    return;
                }
                if (!file.type.startsWith('image/')) {
                    console.error('Edit modal: Selected file is not an image');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    console.log('Edit modal: Setting image src to:', e.target.result);
                    previewImg.src = e.target.result;
                };
                reader.onerror = function(e) {
                    console.error('Edit modal: Error reading file:', e);
                };
                reader.readAsDataURL(file);
            });
        } else {
            console.error('Edit modal: File input or preview image element not found');
        }
    });
</script>