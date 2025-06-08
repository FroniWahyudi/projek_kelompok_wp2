<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <!-- Css Custom -->
    <link rel="stylesheet" href="{{ asset('css/reset_pw.css') }}">
</head>
<body>
    <div class="container py-4">
        <!-- Home Button -->
        <a href="{{ url('dashboard') }}" class="home-button">
            <i class="fas fa-home"></i> Home
        </a>

        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
            <h2 class="mb-0 fw-bold">Password Reset</h2>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div id="success-message" class="alert alert-success fade-out">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    window.location.replace(window.location.pathname);
                }, 2000);
            </script>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Error:</strong>
                </div>
                <ul class="mt-2 ml-6 list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Password Reset Requests Section -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Pengajuan Reset Password</h5>
                    <span class="badge badge-status">
                        {{ count($requests) }} pending
                    </span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($requests as $request)
                                <tr>
                                    <td data-label="User ID">{{ $request->user->id }}</td>
                                    <td data-label="Email">{{ $request->user->email }}</td>
                                    <td data-label="Aksi" class="action-buttons">
                                        <form method="POST" action="{{ route('reset.password', ['id' => $request->user_id]) }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $request->user_id }}">
                                            <input type="hidden" name="password" value="admin123">
                                            <input type="hidden" name="password_confirmation" value="admin123">
                                            <button type="submit" class="btn btn-primary nav-button">
                                                <i class="bi bi-arrow-repeat me-1"></i> Reset Password
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-state">
                                        <i class="bi bi-inbox empty-state-icon"></i>
                                        <h5>Tidak ada pengajuan reset password</h5>
                                        <p class="text-muted">Belum ada pengajuan yang tersedia</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Manual Password Reset Section (Commented Out) -->
        <!--
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Reset Password Manual</h5>
            </div>
            <div class="card-body">
                <form id="resetForm" method="POST" action="{{ route('reset.password.manual') }}" class="space-y-4">
                    @csrf
                    <div class="mb-3">
                        <label for="id" class="form-label">User ID</label>
                        <input type="text" name="id" id="id" value="{{ old('id') }}" 
                               class="form-control @error('id') is-invalid @enderror" required>
                        @error('id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="form-control @error('password_confirmation') is-invalid @enderror" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary nav-button">
                            <i class="bi bi-key me-1"></i> Update Password
                        </button>
                        <button type="button" id="btn-auto-reset" class="btn btn-secondary nav-button">
                            <i class="bi bi-magic me-1"></i> Reset ke "admin123"
                        </button>
                    </div>
                </form>
            </div>
        </div>
        -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('btn-auto-reset')?.addEventListener('click', function() {
            const pwd = 'admin123';
            const form = document.getElementById('resetForm');
            form.password.value = pwd;
            form.password_confirmation.value = pwd;
            form.submit();
        });

        // Auto fade out success message
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.classList.add('fade-out');
            }, 2500);
        }

        // Responsive table labels
        if (window.innerWidth <= 768) {
            const headers = ['User ID', 'Email', 'Request Note', 'Aksi'];
            document.querySelectorAll('tbody td').forEach((td, index) => {
                const colIndex = index % headers.length;
                td.setAttribute('data-label', headers[colIndex]);
            });
        }
    </script>
</body>
</html>