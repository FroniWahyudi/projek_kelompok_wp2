<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="resetForm" method="POST" action="{{ route('reset.password') }}">
        @csrf

        <label for="id">User ID:</label>
        <input type="text" name="id" id="id" value="{{ old('id') }}" required>
        <br>

        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" required>
        @error('password')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <br>

        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
        @error('password_confirmation')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <br>

        {{-- Tombol biasa untuk manual update --}}
        <button type="submit">Update Password</button>
        {{-- Tombol auto-reset + submit --}}
        <button type="button" id="btn-auto-reset">Reset ke "admin123"</button>
    </form>

    <script>
        document
          .getElementById('btn-auto-reset')
          .addEventListener('click', function() {
              const pwd = 'admin123';
              const form = document.getElementById('resetForm');
              form.querySelector('#password').value = pwd;
              form.querySelector('#password_confirmation').value = pwd;
              // langsung submit setelah diisi
              form.submit();
          });
    </script>
</body>
</html>
