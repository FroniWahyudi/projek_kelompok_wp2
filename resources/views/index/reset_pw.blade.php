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
    <form method="POST" action="{{ route('reset.password') }}">
        @csrf
        <label for="id">User ID:</label>
        <input type="text" name="id" id="id" required>
        <br>
        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
        <br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>