<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .card-container {
            max-width: 500px;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .card-header {
            background: linear-gradient(135deg, #e3f2fd 0%, #e1f5fe 100%);
            color: #003366;
            padding: 30px;
            text-align: center;
            border-bottom: none;
        }
        
        .card-body {
            padding: 30px;
            background-color: #ffffff;
        }
        
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
        
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }
        
        .text-primary {
            color: #003366 !important;
        }
        
        .text-secondary {
            color: #4a4a4a !important;
        }
        
        .back-btn {
            color: #007bff;
            text-decoration: none;
        }
        
        .back-btn:hover {
            color: #0056b3;
        }
        
        .icon-container {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #007bff;
        }
        
        .footer-note {
            color: #555;
            font-size: 0.9rem;
            margin-top: 20px;
            text-align: center;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
        
        .shake {
            animation: shake 0.5s;
        }
        
        .input-icon {
            position: absolute;
            z-index: 2;
            display: block;
            width: 2.375rem;
            height: 2.375rem;
            line-height: 2.375rem;
            text-align: center;
            pointer-events: none;
            color: #6c757d;
            left: -6px;
            top: 1px;
        }

        /* Float Notification Styles - HANYA UNTUK SUCCESS DAN ERROR */
        #success-message, #error-message {
            position: fixed !important;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            transform: translateX(400px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            margin: 0 !important;
        }

        #success-message.show, #error-message.show {
            transform: translateX(0);
            opacity: 1;
        }

        #success-message {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 1px solid #c3e6cb;
            border-left: 4px solid #28a745;
            color: #155724;
        }

        #error-message {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border: 1px solid #f5c6cb;
            border-left: 4px solid #dc3545;
            color: #721c24;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            #success-message, #error-message {
                top: 10px;
                right: 10px;
                left: 10px;
                min-width: auto;
                max-width: none;
                transform: translateY(-100px);
            }

            #success-message.show, #error-message.show {
                transform: translateY(0);
            }
        }
    </style>
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
                        <label for="keterangan" class="form-label text-secondary">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="3"
                                  class="form-control"
                                  placeholder="Jelaskan mengapa Anda perlu reset password" required>{{ old('keterangan') }}</textarea>
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