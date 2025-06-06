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
    <style>
        :root {
            --primary-bg: #f0f4f8;
            --card-bg: #ffffff;
            --primary-action: #007bff;
            --gradient-start: #e3f2fd;
            --gradient-end: #e1f5fe;
            --primary-text: #003366;
            --secondary-text: #4a4a4a;
            --tertiary-text: #555;
            --minimal-action: #6c757d;
            --home-button-border: #dee2e6;
        }

        body {
            background-color: var(--primary-bg);
            color: var(--primary-text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--primary-text);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: var(--card-bg);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border-bottom: none;
            border-radius: 12px 12px 0 0 !important;
            padding: 1.25rem;
            font-weight: 600;
            color: var(--primary-text);
        }

        .card-body {
            color: var(--tertiary-text);
        }

        .card-body strong {
            color: var(--primary-text);
        }

        .btn-primary {
            background-color: var(--primary-action);
            border-color: var(--primary-action);
            padding: 0.5rem 1.25rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .btn-secondary {
            background-color: var(--minimal-action);
            border-color: var(--minimal-action);
            padding: 0.5rem 1.25rem;
            font-weight: 500;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .badge-status {
            min-width: 80px;
            padding: 0.5rem;
            font-weight: 500;
            font-size: 0.85rem;
            border-radius: 50px;
            background-color: #e3f2fd;
            color: var(--primary-action);
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead {
            background-color: var(--primary-text);
            color: white;
        }

        .table th {
            font-weight: 500;
            padding: 1rem;
        }

        .table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
            color: var(--tertiary-text);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .modal-header {
            background-color: var(--primary-action);
            color: white;
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
        }

        .form-control {
            border-color: #ced4da;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: var(--primary-action);
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        .nav-button {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .empty-state {
            padding: 3rem 0;
            text-align: center;
            color: var(--secondary-text);
        }

        .empty-state-icon {
            font-size: 3rem;
            color: var(--minimal-action);
            margin-bottom: 1rem;
        }

        .home-button {
            background-color: var(--card-bg);
            color: var(--primary-action);
            padding: 8px 12px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border: 2px solid var(--home-button-border);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            animation: slideInUp 0.6s ease-out;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .home-button:hover {
            background-color: var(--primary-action);
            color: var(--card-bg);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.25);
            text-decoration: none;
        }

        .home-button i {
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .home-button:hover i {
            transform: scale(1.1);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
            border-radius: 8px;
            padding: 1rem;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
            border-radius: 8px;
            padding: 1rem;
        }

        .fade-out {
            animation: fadeOut 3s ease-in-out forwards;
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; height: 0; padding: 0; margin: 0; overflow: hidden; }
        }

        @media (max-width: 768px) {
            .home-button {
                padding: 6px 10px;
                font-size: 0.9rem;
            }

            .table-responsive {
                border-radius: 12px;
            }

            .table thead {
                display: none;
            }

            .table tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: right;
                padding: 0.5rem 1rem;
                border-bottom: 1px solid #f0f0f0;
            }

            .table td::before {
                content: attr(data-label);
                font-weight: 500;
                color: var(--primary-text);
                margin-right: auto;
                padding-right: 1rem;
            }
        }

        @media (max-width: 576px) {
            .home-button {
                padding: 5px 8px;
                font-size: 0.85rem;
            }
        }
    </style>
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