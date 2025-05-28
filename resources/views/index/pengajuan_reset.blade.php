<!DOCTYPE html>
<html>
<head>
    <title>Pengajuan Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        .error, .success {
            margin-bottom: 1em;
        }
        .error ul {
            color: red;
            padding-left: 20px;
        }
        .success {
            color: green;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="email"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .nav-link {
            cursor: pointer;
            color: #007bff;
            text-decoration: none;
        }
        .nav-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Pengajuan Reset Password</h1>
        <div class="container">
            <a class="nav-link" onclick="goToLogin()"> 
                <i class="bi bi-house-door me-1"></i> Kembali ke Login
            </a>
        </div>
        <!-- Pesan Sukses -->
        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Pesan Error -->
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pengajuan.reset.password') }}" onsubmit="return validateForm()">
            @csrf

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            
            <label for="keterangan">Keterangan:</label>
            <textarea name="keterangan" id="keterangan" required>{{ old('keterangan') }}</textarea>
            
            <button type="submit">Ajukan Reset Password</button>
        </form>
    </div>

    <script>
        function validateForm() {
            const email = document.getElementById('email').value;
            const keterangan = document.getElementById('keterangan').value;

            if (!email || !keterangan) {
                alert('Email dan Keterangan wajib diisi.');
                return false;
            }

            // Validasi format email sederhana
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Format email tidak valid.');
                return false;
            }

            return true;
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