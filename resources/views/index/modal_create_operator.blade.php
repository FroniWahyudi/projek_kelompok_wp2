<!-- resources/views/index/operator_create.blade.php -->
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
        margin-left: 12px;
    }

    /* Override agar tidak tergulung oleh scroll modal-body */
    .photo-upload {
        position: sticky;
        top: 0rem;
        right: -0.5rem;
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
        <h5 class="modal-title">Tambah Operator Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <form id="formCreateOperator" method="POST" action="{{ route('operator.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- PHOTO UPLOAD -->
        <div class="photo-upload">
            <label class="form-label">Photo</label>
            <div class="preview-wrapper text-center">
                <img id="photoPreview" src="{{ asset('images/default-user.png') }}" alt="Preview Foto">
            </div>
            <input type="file" name="photo" class="form-control form-control-sm" accept="image/*">
        </div>

        <!-- FORM UTAMA -->
        <div class="modal-body position-relative" style="max-height:70vh; overflow-y:auto; padding-right: 10px;">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group" style="width: 57%;">
                    <input 
                        type="text" 
                        name="email_prefix" 
                        id="email_prefix"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') ? explode('@', old('email'))[0] : '' }}"
                        required
                        autocomplete="off"
                        placeholder="username"
                    >
                    <span class="input-group-text">@nagahytam.co.id</span>
                </div>
                <input type="hidden" name="email" id="email_full" value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <script>
                // Email auto append domain
                document.addEventListener('DOMContentLoaded', function() {
                    const prefixInput = document.getElementById('email_prefix');
                    const fullInput = document.getElementById('email_full');
                    const domain = '@nagahytam.co.id';

                    function updateFullEmail() {
                        fullInput.value = prefixInput.value ? prefixInput.value + domain : '';
                    }

                    prefixInput.addEventListener('input', updateFullEmail);
                    updateFullEmail();
                });
            </script>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="3">{{ old('bio') }}</textarea>
                @error('bio')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}">
                @error('alamat')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Joined At</label>
                <input type="date" name="joined_at" class="form-control @error('joined_at') is-invalid @enderror" value="{{ old('joined_at') }}">
                @error('joined_at')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Education</label>
                <input type="text" name="education" class="form-control @error('education') is-invalid @enderror" value="{{ old('education') }}">
                @error('education')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department" class="form-control @error('department') is-invalid @enderror">
                    <option value="">-- Pilih Department --</option>
                    <option value="HR" {{ old('department') == 'HR' ? 'selected' : '' }}>HR</option>
                    <option value="Manajemen" {{ old('department') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                    <option value="Administasi" {{ old('department') == 'Administasi' ? 'selected' : '' }}>Administasi</option>
                    <option value="Gudang" {{ old('department') == 'Gudang' ? 'selected' : '' }}>Gudang</option>
                    <option value="Operasional" {{ old('department') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                </select>
                @error('department')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Level</label>
                <input type="text" name="level" class="form-control @error('level') is-invalid @enderror" value="{{ old('level') }}">
                @error('level')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Job Descriptions</label>
                <textarea name="job_descriptions" class="form-control @error('job_descriptions') is-invalid @enderror" rows="2">{{ old('job_descriptions') }}</textarea>
                @error('job_descriptions')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Skills</label>
                <input type="text" name="skills" class="form-control @error('skills') is-invalid @enderror" value="{{ old('skills') }}">
                @error('skills')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Achievements</label>
                <textarea name="achievements" class="form-control @error('achievements') is-invalid @enderror" rows="2">{{ old('achievements') }}</textarea>
                @error('achievements')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Divisi</label>
                <select name="divisi" class="form-control @error('divisi') is-invalid @enderror" required>
                    <option value="">-- Pilih Divisi --</option>
                    <option value="inbound" {{ old('divisi') == 'inbound' ? 'selected' : '' }}>Inbound</option>
                    <option value="outbound" {{ old('divisi') == 'outbound' ? 'selected' : '' }}>Outbound</option>
                    <option value="storage" {{ old('divisi') == 'storage' ? 'selected' : '' }}>Storage</option>
                </select>
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
</script>