<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .form-container { background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 600px; margin: auto; }
        .error, .success { margin-bottom: 1em; }
        .error ul { color: red; padding-left: 20px; }
        .success { color: green; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"], textarea { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .card { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Reset Password</h1>
 <a class="nav-link" href="{{ url('dashboard') }}"> <i class="fas fa-home"></i> Home</a>
        <!-- Pesan Sukses -->
        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    window.location.replace(window.location.pathname);
                }, 2000);
            </script>
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

        <!-- Daftar Pengajuan Reset Password -->
        <h2>Daftar Pengajuan Reset Password</h2>
        @forelse ($requests as $request)
            <div class="card">
                <p><strong>User ID:</strong> {{ $request->user_id }}</p>
                <p><strong>Email:</strong> {{ $request->user->email }}</p>
                <p><strong>Keterangan:</strong> {{ $request->keterangan }}</p>
                <form method="POST" action="{{ route('reset.password', ['id' => $request->user_id]) }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $request->user_id }}">
                    <input type="hidden" name="password" value="admin123">
                    <input type="hidden" name="password_confirmation" value="admin123">
                    <button type="submit">Reset Password</button>
                </form>
            </div>
        @empty
            <p>Tidak ada pengajuan reset password.</p>
        @endforelse

        <!-- Form untuk reset password manual -->
        <h2>Reset Password Manual</h2>
        <form id="resetForm" method="POST" action="{{ route('reset.password.manual') }}">
            @csrf
            <label for="id">User ID:</label>
            <input type="text" name="id" id="id" value="{{ old('id') }}" required>
            <br><br>
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <div style="color: red">{{ $message }}</div>
            @enderror
            <br><br>
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
            @error('password_confirmation')
                <div style="color: red">{{ $message }}</div>
            @enderror
            <br><br>
            <button type="submit">Update Password</button>
            <button type="button" id="btn-auto-reset">Reset ke "admin123"</button>
        </form>

        <script>
            document.getElementById('btn-auto-reset').addEventListener('click', function() {
                const pwd = 'admin123';
                const form = document.getElementById('resetForm');
                form.password.value = pwd;
                form.password_confirmation.value = pwd;
                form.submit();
            });
        </script>
    </div>
</body>
</html>