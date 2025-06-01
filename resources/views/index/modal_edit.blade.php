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
    .photo-upload-edit .photo-preview-edit {
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

    /* Style untuk email input group */
    .input-group {
        display: flex;
        align-items: center;
    }

    .input-group .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: none;
    }

    .input-group-text {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        background-color: #f8f9fa;
        border-left: none;
        color: #6c757d;
        font-weight: 500;
    }

    .email-username {
        flex: 1;
    }
    .input-group {
    display: flex
;
    align-items: center;
    width: 57%;
}
</style>

<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Edit User: {{ $user['name'] }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <form id="formEditUser{{ $user['id'] }}" method="POST" action="{{ route('operator.update', $user['id']) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- PHOTO UPLOAD -->
        <div class="photo-upload-edit">
            <label class="form-label">Photo</label>
            <div class="preview-wrapper-edit text-center">
                <img id="photoPreviewEdit{{ $user['id'] }}" class="photo-preview-edit" src="{{ $user['photo_url'] ?? asset('images/default-user.png') }}" alt="Preview Foto">
            </div>
            <input type="file" name="photo" class="form-control form-control-sm photo-input-edit" data-user-id="{{ $user['id'] }}" accept="image/*">
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
                <div class="input-group">
                    <input 
                        type="text" 
                        name="email_username" 
                        class="form-control email-username" 
                        value="{{ old('email_username', explode('@', $user['email'])[0] ?? '') }}" 
                        placeholder="username"
                        pattern="[a-zA-Z0-9._-]+"
                        title="Hanya boleh menggunakan huruf, angka, titik, underscore, dan dash"
                        required
                        id="emailUsername{{ $user['id'] }}"
                    >
                    <span class="input-group-text">@nagahytam.co.id</span>
                </div>
                <input type="hidden" name="email" id="fullEmail{{ $user['id'] }}" value="{{ old('email', $user['email']) }}">
                <small class="form-text text-muted">Hanya username yang dapat diubah, domain tetap @nagahytam.co.id</small>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                @error('email_username')
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
    // Setup photo preview untuk semua modal edit
    function setupAllPhotoPreview() {
        // Ambil semua input file dengan class photo-input-edit
        const fileInputs = document.querySelectorAll('.photo-input-edit');
        
        fileInputs.forEach(function(fileInput) {
            const userId = fileInput.getAttribute('data-user-id');
            const previewImg = document.getElementById('photoPreviewEdit' + userId);
            
            if (!previewImg) {
                console.error('Preview image tidak ditemukan untuk user ID:', userId);
                return;
            }
            
            // Hapus event listener lama jika ada
            fileInput.removeEventListener('change', handleFileChange);
            
            // Tambah event listener baru
            fileInput.addEventListener('change', function() {
                handleFileChange(this, previewImg, userId);
            });
        });
    }
    
    // Function untuk handle perubahan file
    function handleFileChange(fileInput, previewImg, userId) {
        const file = fileInput.files[0];
        
        if (!file) {
            console.log('Tidak ada file yang dipilih untuk user ID:', userId);
            return;
        }

        if (!file.type.startsWith('image/')) {
            console.error('File yang dipilih bukan gambar untuk user ID:', userId);
            alert('Mohon pilih file gambar yang valid!');
            fileInput.value = ''; // Reset input
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            console.log('Mengatur preview untuk user ID:', userId);
            previewImg.src = e.target.result;
        };
        reader.onerror = function(e) {
            console.error('Gagal membaca file untuk user ID:', userId, e);
            alert('Gagal membaca file gambar!');
        };
        reader.readAsDataURL(file);
    }

    // Setup email username handler untuk semua modal edit
    function setupEmailUsernameHandler() {
        const emailInputs = document.querySelectorAll('input[name="email_username"]');
        
        emailInputs.forEach(function(emailInput) {
            const userId = emailInput.id.replace('emailUsername', '');
            const fullEmailInput = document.getElementById('fullEmail' + userId);
            
            if (!fullEmailInput) {
                console.error('Full email input tidak ditemukan untuk user ID:', userId);
                return;
            }
            
            // Update full email saat username berubah
            emailInput.addEventListener('input', function() {
                const username = this.value.trim();
                // Validasi karakter username
                const validPattern = /^[a-zA-Z0-9._-]*$/;
                
                if (!validPattern.test(username)) {
                    // Hapus karakter yang tidak valid
                    this.value = username.replace(/[^a-zA-Z0-9._-]/g, '');
                }
                
                // Update full email
                const cleanUsername = this.value.trim();
                if (cleanUsername) {
                    fullEmailInput.value = cleanUsername + '@nagahytam.co.id';
                } else {
                    fullEmailInput.value = '@nagahytam.co.id';
                }
            });
            
            // Set initial full email value
            const initialUsername = emailInput.value.trim();
            if (initialUsername) {
                fullEmailInput.value = initialUsername + '@nagahytam.co.id';
            }
        });
    }

    // Setup form submission handler
    function setupFormSubmissionHandler() {
        const forms = document.querySelectorAll('form[id^="formEditUser"]');
        
        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const emailUsernameInput = form.querySelector('input[name="email_username"]');
                const fullEmailInput = form.querySelector('input[name="email"]');
                
                if (emailUsernameInput && fullEmailInput) {
                    const username = emailUsernameInput.value.trim();
                    
                    // Validasi username tidak boleh kosong
                    if (!username) {
                        e.preventDefault();
                        alert('Username email tidak boleh kosong!');
                        emailUsernameInput.focus();
                        return false;
                    }
                    
                    // Validasi format username
                    const validPattern = /^[a-zA-Z0-9._-]+$/;
                    if (!validPattern.test(username)) {
                        e.preventDefault();
                        alert('Username email hanya boleh menggunakan huruf, angka, titik (.), underscore (_), dan dash (-)!');
                        emailUsernameInput.focus();
                        return false;
                    }
                    
                    // Update full email sebelum submit
                    fullEmailInput.value = username + '@nagahytam.co.id';
                }
            });
        });
    }

    // Jalankan semua setup saat DOM dimuat
    setupAllPhotoPreview();
    setupEmailUsernameHandler();
    setupFormSubmissionHandler();

    // Setup ulang ketika modal ditampilkan (untuk modal yang dimuat dinamis)
    document.addEventListener('shown.bs.modal', function(e) {
        if (e.target.id && e.target.id.includes('editModal')) {
            console.log('Modal edit ditampilkan, setup ulang semua handler');
            setTimeout(function() {
                setupAllPhotoPreview();
                setupEmailUsernameHandler();
                setupFormSubmissionHandler();
            }, 100); // Delay sedikit untuk memastikan DOM sudah siap
        }
    });
});
</script>