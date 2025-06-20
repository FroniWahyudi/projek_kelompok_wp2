<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Css Custom -->
    <link rel="stylesheet" href="{{ asset('css/pengajuan_reset.css') }}">
</head>
<body>
    <div class="card-container">
        <div class="card">
            <div class="card-header">
                <div class="icon-container">
                    <i class="fas fa-key"></i>
                </div>
                <h2 class="text-primary">Reset Password</h2>
                <p class="text-secondary mb-0">Masukkan email Anda untuk mengajukan reset password</p>
                <!-- Keterangan tambahan -->
                <div class="alert alert-info mt-3 mb-0" role="alert" style="font-size: 1rem;">
                    <i class="fas fa-info-circle me-2"></i>
                    Setelah pengajuan, <b>password Anda akan direset oleh admin menjadi <code>admin123</code></b>.<br>
                    Silakan tunggu proses reset yang akan dilakukan oleh admin.
                </div>
            </div>
            
            <div class="card-body">
                <!-- Back button -->
                <a href="#" onclick="goToLogin()" class="back-btn mb-3 d-inline-block">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Login
                </a>
                
                <!-- Success message -->
                @if (session('success'))
                    <div id="success-message" class="alert alert-success">
                        <span id="success-text">{{ session('success') }}</span>
                    </div>
                @endif
                
                <!-- Error messages -->
                @if ($errors->any())
                    <div id="error-message" class="alert alert-danger">
                        <strong>Terjadi kesalahan:</strong>
                        <ul id="error-list" class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('pengajuan.reset.password') }}" onsubmit="return validateForm()">
                    @csrf
                    
                    <!-- Email field -->
                    <div class="mb-4">
                        <label for="email" class="form-label text-secondary">Email</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                   class="form-control ps-4" 
                                   placeholder="email@contoh.com" required>
                        </div>
                    </div>
                    
                    <!-- Keterangan field -->
                    <div class="mb-4">
                        <!--<label for="keterangan" class="form-label text-secondary">Keterangan</label> -->
                        <input type="text" name="keterangan" id="keterangan" rows="3"
                                  class="form-control"
                                  placeholder="Jelaskan mengapa Anda perlu reset password" value = "lupa" hidden>
                    </div>
                    
                    <!-- Submit button -->
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i> Ajukan Reset Password
                        </button>
                    </div>
                </form>
                
                <div class="footer-note">
                    Tim support akan menghubungi Anda dalam 1x24 jam
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto show float notifications on page load
        window.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');
            
            if (successMessage) {
                setTimeout(() => {
                    successMessage.classList.add('show');
                }, 100);
                
                // Auto hide after 5 seconds
                setTimeout(() => {
                    successMessage.classList.remove('show');
                }, 5000);
            }
            
            if (errorMessage) {
                setTimeout(() => {
                    errorMessage.classList.add('show');
                }, 100);
                
                // Auto hide after 7 seconds (longer for errors)
                setTimeout(() => {
                    errorMessage.classList.remove('show');
                }, 7000);
            }
        });

        function validateForm() {
            const email = document.getElementById('email').value;
            const keterangan = document.getElementById('keterangan').value;
            const emailInput = document.getElementById('email');
            const keteranganInput = document.getElementById('keterangan');
            let isValid = true;

            // Clear previous error states
            const errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.classList.add('d-none');
                errorMessage.classList.remove('show');
            }
            const errorList = document.getElementById('error-list');
            if (errorList) {
                errorList.innerHTML = '';
            }
            emailInput.classList.remove('is-invalid', 'shake');
            keteranganInput.classList.remove('is-invalid', 'shake');

            if (!email) {
                addError('Email wajib diisi');
                emailInput.classList.add('is-invalid', 'shake');
                isValid = false;
            } else {
                // Email format validation
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    addError('Format email tidak valid');
                    emailInput.classList.add('is-invalid', 'shake');
                    isValid = false;
                }
            }

            if (!keterangan) {
                addError('Keterangan wajib diisi');
                keteranganInput.classList.add('is-invalid', 'shake');
                isValid = false;
            }

            if (!isValid) {
                const errorMessage = document.getElementById('error-message');
                if (errorMessage) {
                    errorMessage.classList.remove('d-none');
                    setTimeout(() => {
                        errorMessage.classList.add('show');
                    }, 100);
                    
                    // Auto hide after 7 seconds
                    setTimeout(() => {
                        errorMessage.classList.remove('show');
                    }, 7000);
                }
                return false;
            }

            return true;
        }

        function addError(message) {
            const errorList = document.getElementById('error-list');
            if (errorList) {
                const li = document.createElement('li');
                li.textContent = message;
                errorList.appendChild(li);
            }
        }

        function goToLogin() {
            // Ganti entri riwayat saat ini dengan URL login
            history.replaceState(null, '', "{{ route('login') }}");
            // Arahkan ke halaman login
            window.location.href = "{{ route('login') }}";
        }
    </script>
</body>
</html>