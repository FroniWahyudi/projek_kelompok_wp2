<style>
    /* Container photo upload */
    .photo-upload-create {
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
    .photo-upload-create .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #495057;
    }

    /* Wrapper preview */
    .photo-upload-create .preview-wrapper-create {
        margin-bottom: 3rem;
    }

    /* Gambar preview */
    .photo-upload-create #photoPreviewCreate {
        width: 208px;
        height: 200px;
        object-fit: cover;
        border-radius: 10%;
        border: 1px solid #dee2e6;
    }

    /* File input: full-width dalam container dan rata kiri */
    .photo-upload-create .form-control-sm {
        width: 90%;
        font-size: 0.8rem;
        padding: 0.25rem;
        margin-left: 12px;
    }

    /* Override agar tidak tergulung oleh scroll modal-body */
    .photo-upload-create {
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
        <h5 class="modal-title">Tambah Operator Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <form id="formCreateOperator" method="POST" action="{{ route('operator.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- PHOTO UPLOAD -->
        <div class="photo-upload-create">
            <label class="form-label">Photo <span class="text-danger">*</span></label>
            <div class="preview-wrapper-create text-center">
            <img id="photoPreviewCreate" src="{{ asset('images/default-user.png') }}" alt="Preview Foto">
            </div>
            <input type="file" name="photo" class="form-control form-control-sm @error('photo') is-invalid @enderror" accept="image/*" required>
            @error('photo')
            <div class="text-danger">{{ $message }}</div>
            @enderror
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
                        class="form-control @error('email') is-invalid @enderror @error('email_prefix') is-invalid @enderror"
                        value="{{ old('email') ? explode('@', old('email'))[0] : '' }}"
                        required
                        autocomplete="off"
                        placeholder="username"
                    >
                    <span class="input-group-text">@nagahytam.co.id</span>
                </div>
                <input type="hidden" name="email" id="email_full" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                @error('email_prefix')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <input type="hidden" name="role" value="Operator">

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="3" required>{{ old('bio') }}</textarea>
                @error('bio')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}" required>
                @error('alamat')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Joined At</label>
                <input type="date" name="joined_at" class="form-control @error('joined_at') is-invalid @enderror" value="{{ old('joined_at') }}" required>
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
                <select name="department" class="form-control @error('department') is-invalid @enderror" readonly disabled>
                    <option value="Gudang" selected>Gudang</option>
                </select>
                <input type="hidden" name="department" value="Gudang">
                @error('department')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Level</label>
                <input type="text" name="level" class="form-control @error('level') is-invalid @enderror" value="junior" readonly>
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
                <input name="skills" class="form-control @error('skills') is-invalid @enderror" value="{{ old('skills') }}">
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
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formCreateOperator');
        const prefixInput = document.getElementById('email_prefix');
        const fullInput = document.getElementById('email_full');
        const fileInput = document.querySelector('#formCreateOperator input[name="photo"]');
        const previewImg = document.getElementById('photoPreviewCreate');
        const domain = '@nagahytam.co.id';

        // Email handling
        if (prefixInput && fullInput) {
            function updateFullEmail() {
                fullInput.value = prefixInput.value ? prefixInput.value + domain : '';
                console.log('Updated email_full:', fullInput.value);
            }

            prefixInput.addEventListener('input', updateFullEmail);
            updateFullEmail();

            form.addEventListener('submit', function(event) {
                if (!prefixInput.value.trim()) {
                    event.preventDefault();
                    alert('Email prefix is required.');
                    prefixInput.classList.add('is-invalid');
                    return false;
                }
                if (!fullInput.value) {
                    event.preventDefault();
                    alert('Email is required.');
                    fullInput.classList.add('is-invalid');
                    return false;
                }
            });
        } else {
            console.error('Email prefix or full input not found');
        }

        // Photo preview
        if (fileInput && previewImg) {
            console.log('Create modal: File input and preview image found:', fileInput, previewImg);
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) {
                    console.log('Create modal: No file selected');
                    return;
                }
                if (!file.type.startsWith('image/')) {
                    console.error('Create modal: Selected file is not an image');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    console.log('Create modal: Setting image src to:', e.target.result);
                    previewImg.src = e.target.result;
                };
                reader.onerror = function(e) {
                    console.error('Create modal: Error reading file:', e);
                };
                reader.readAsDataURL(file);
            });
        } else {
            console.error('Create modal: File input or preview image element not found');
        }
    });
</script>