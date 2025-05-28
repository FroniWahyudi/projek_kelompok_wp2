<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>

    {{-- Notifikasi via query param --}}
    @if(request('success'))
    <div id="success-msg" style="color: green; margin-bottom:1em;">
        {{ request('success') }}
    </div>
    <script>
        setTimeout(() => {
            // Redirect ke URL tanpa query string:
            window.location.replace(window.location.pathname);
        }, 2000);
    </script>
@endif


    @if ($errors->any())
        <div style="color: red; margin-bottom:1em;">
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
</body>
</html>
