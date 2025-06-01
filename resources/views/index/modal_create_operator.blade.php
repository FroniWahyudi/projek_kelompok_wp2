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

    /* Gambar preview - Gunakan class bukan ID */
    .photo-upload-create .photo-preview-create {
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
        <h5 class="modal-title">Tambah Pengguna Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <form id="formCreateUser" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- PHOTO UPLOAD -->
        <div class="photo-upload-create">
            <label class="form-label">Photo <span class="text-danger">*</span></label>
            <div class="preview-wrapper-create text-center">
                <img class="photo-preview-create" src="{{ asset('images/default-user.png') }}" alt="Preview Foto">
            </div>
            <input type="file" name="photo" class="form-control form-control-sm photo-input-create @error('photo') is-invalid @enderror" accept="image/*" required>
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
                        class="email-prefix-input form-control @error('email') is-invalid @enderror @error('email_prefix') is-invalid @enderror"
                        value="{{ old('email') ? explode('@', old('email'))[0] : '' }}"
                        required
                        autocomplete="off"
                        placeholder="username"
                    >
                    <span class="input-group-text">@nagahytam.co.id</span>
                </div>
                <input type="hidden" name="email" class="email-full-input" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                @error('email_prefix')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- ROLE SELECTION -->
            <div class="mb-3">
                <label class="form-label">Role <span class="text-danger">*</span></label>
                <select name="role" class="form-control role-select @error('role') is-invalid @enderror" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Manager" {{ old('role') == 'Manager' ? 'selected' : '' }}>Manager</option>
                    <option value="Leader" {{ old('role') == 'Leader' ? 'selected' : '' }}>Leader</option>
                    <option value="Operator" {{ old('role') == 'Operator' ? 'selected' : '' }}>Operator</option>
                </select>
                @error('role')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

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
                <input 
                    type="date" 
                    name="joined_at" 
                    class="form-control @error('joined_at') is-invalid @enderror" 
                    value="{{ old('joined_at', \Carbon\Carbon::now()->format('Y-m-d')) }}" 
                    required
                >
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
                <select name="department" class="form-control @error('department') is-invalid @enderror" required>
                    <option value="">-- Pilih Department --</option>
                    <option value="Gudang" {{ old('department') == 'Gudang' ? 'selected' : '' }}>Gudang</option>
                    <option value="Operasional" {{ old('department') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                </select>
                @error('department')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- LEVEL FIELD - DINAMIS BERDASARKAN ROLE -->
            <div class="mb-3">
                <label class="form-label">Level</label>
                <select name="level" class="form-control level-select @error('level') is-invalid @enderror" required>
                    <option value="">-- Pilih Level --</option>
                    <!-- Options akan diisi dinamis berdasarkan role -->
                </select>
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
    // Menggunakan Event Delegation untuk mengatasi masalah ID tidak unik
    
    // Photo Preview Handler
    document.addEventListener('change', function(e) {
        if (e.target.matches('.photo-input-create')) {
            console.log('Photo input changed in create modal');
            
            const file = e.target.files[0];
            if (!file) {
                console.log('No file selected');
                return;
            }
            
            if (!file.type.startsWith('image/')) {
                console.error('Selected file is not an image');
                alert('Please select a valid image file');
                return;
            }
            
            const modal = e.target.closest('.modal-content');
            const previewImg = modal.querySelector('.photo-preview-create');
            
            if (!previewImg) {
                console.error('Preview image not found in modal');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(event) {
                console.log('Setting image preview');
                previewImg.src = event.target.result;
            };
            reader.onerror = function(error) {
                console.error('Error reading file:', error);
            };
            reader.readAsDataURL(file);
        }

        // ROLE CHANGE HANDLER
        if (e.target.matches('.role-select')) {
            const modal = e.target.closest('.modal-content');
            const levelSelect = modal.querySelector('.level-select');
            const selectedRole = e.target.value;
            
            console.log('Role changed to:', selectedRole);
            
            // Clear existing options
            levelSelect.innerHTML = '<option value="">-- Pilih Level --</option>';
            
            // Add options based on role
            if (selectedRole === 'Admin') {
                levelSelect.innerHTML += `
                    <option value="super_admin">Super Admin</option>
                    <option value="admin">Admin</option>
                `;
            } else if (selectedRole === 'Manager') {
                levelSelect.innerHTML += `
                    <option value="senior_manager">Senior Manager</option>
                    <option value="manager">Manager</option>
                `;
            } else if (selectedRole === 'Leader') {
                levelSelect.innerHTML += `
                    <option value="senior">Senior</option>
                    <option value="lead">Lead</option>
                    <option value="supervisor">Supervisor</option>
                `;
            } else if (selectedRole === 'Operator') {
                levelSelect.innerHTML += `
                    <option value="junior">Junior</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="senior">Senior</option>
                `;
            }
            
            // Set old value if exists
            const oldLevel = '{{ old("level") }}';
            if (oldLevel) {
                const option = levelSelect.querySelector(`option[value="${oldLevel}"]`);
                if (option) {
                    option.selected = true;
                }
            }
        }
    });

    // Email Handler
    document.addEventListener('input', function(e) {
        if (e.target.matches('.email-prefix-input')) {
            const modal = e.target.closest('.modal-content');
            const fullInput = modal.querySelector('.email-full-input');
            const domain = '@nagahytam.co.id';
            
            if (fullInput) {
                fullInput.value = e.target.value ? e.target.value + domain : '';
                console.log('Updated email_full:', fullInput.value);
            }
        }
    });

    // Form Submit Handler
    document.addEventListener('submit', function(e) {
        if (e.target.matches('#formCreateUser')) {
            const modal = e.target.closest('.modal-content');
            const prefixInput = modal.querySelector('.email-prefix-input');
            const fullInput = modal.querySelector('.email-full-input');
            const roleSelect = modal.querySelector('.role-select');
            const levelSelect = modal.querySelector('.level-select');
            
            // Validasi email prefix
            if (!prefixInput.value.trim()) {
                e.preventDefault();
                alert('Email prefix is required.');
                prefixInput.classList.add('is-invalid');
                prefixInput.focus();
                return false;
            }
            
            // Validasi full email
            if (!fullInput.value) {
                e.preventDefault();
                alert('Email is required.');
                return false;
            }
            
            // Validasi role
            if (!roleSelect.value) {
                e.preventDefault();
                alert('Role is required.');
                roleSelect.classList.add('is-invalid');
                roleSelect.focus();
                return false;
            }
            
            // Validasi level
            if (!levelSelect.value) {
                e.preventDefault();
                alert('Level is required.');
                levelSelect.classList.add('is-invalid');
                levelSelect.focus();
                return false;
            }
            
            console.log('Form submitted with:', {
                email: fullInput.value,
                role: roleSelect.value,
                level: levelSelect.value
            });
        }
    });

    // Initialization ketika modal dibuka
    $(document).on('shown.bs.modal', '.modal', function() {
        console.log('Modal opened, initializing...');
        
        const modal = this;
        const prefixInput = modal.querySelector('.email-prefix-input');
        const fullInput = modal.querySelector('.email-full-input');
        const roleSelect = modal.querySelector('.role-select');
        const levelSelect = modal.querySelector('.level-select');
        
        // Update email field jika ada value lama
        if (prefixInput && fullInput && prefixInput.value) {
            const domain = '@nagahytam.co.id';
            fullInput.value = prefixInput.value + domain;
            console.log('Initialized email:', fullInput.value);
        }
        
        // Initialize level options based on role
        if (roleSelect && levelSelect && roleSelect.value) {
            const changeEvent = new Event('change', { bubbles: true });
            roleSelect.dispatchEvent(changeEvent);
        }
    });

    // Initialize level options on page load if old values exist
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelects = document.querySelectorAll('.role-select');
        roleSelects.forEach(function(roleSelect) {
            if (roleSelect.value) {
                const changeEvent = new Event('change', { bubbles: true });
                roleSelect.dispatchEvent(changeEvent);
            }
        });
    });

    // Debug function - untuk testing (hapus di production)
    function debugCreateModal() {
        console.log('=== Debug Create Modal ===');
        console.log('Photo inputs found:', document.querySelectorAll('.photo-input-create').length);
        console.log('Photo previews found:', document.querySelectorAll('.photo-preview-create').length);
        console.log('Email prefix inputs found:', document.querySelectorAll('.email-prefix-input').length);
        console.log('Email full inputs found:', document.querySelectorAll('.email-full-input').length);
        console.log('Role selects found:', document.querySelectorAll('.role-select').length);
        console.log('Level selects found:', document.querySelectorAll('.level-select').length);
    }
    
    // Uncomment untuk debugging
    // debugCreateModal();
</script>