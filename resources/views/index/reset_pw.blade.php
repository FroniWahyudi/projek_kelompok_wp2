<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .fade-out {
            animation: fadeOut 3s ease-in-out forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; height: 0; padding: 0; margin: 0; overflow: hidden; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Password Reset</h1>
            <a href="{{ url('dashboard') }}" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-home mr-2"></i> Back to Home
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div id="success-message" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded fade-out">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
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
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
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
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-700">Daftar Pengajuan Reset Password</h2>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ count($requests) }} pending
                </span>
            </div>

            @forelse ($requests as $request)
                <div class="border border-gray-200 rounded-lg p-4 mb-4 hover:bg-gray-50 transition-colors">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500">User ID</p>
                            <p class="font-semibold">{{ $request->user_id81 }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="font-semibold">{{ $request->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Request Note</p>
                            <p class="font-semibold">{{ $request->keterangan }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('reset.password', ['id' => $request->user_id]) }}" class="mt-2">
                        @csrf
                        <input type="hidden" name="id" value="{{ $request->user_id }}">
                        <input type="hidden" name="password" value="admin123">
                        <input type="hidden" name="password_confirmation" value="admin123">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center">
                            <i class="fas fa-sync-alt mr-2"></i> Reset Password
                        </button>
                    </form>
                </div>
            @empty
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500">Tidak ada pengajuan reset password.</p>
                </div>
            @endforelse
        </div>

        <!-- Manual Password Reset Section -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Reset Password Manual</h2>
            <form id="resetForm" method="POST" action="{{ route('reset.password.manual') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label for="id" class="block text-sm font-medium text-gray-700 mb-1">User ID</label>
                    <input type="text" name="id" id="id" value="{{ old('id') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" name="password" id="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex space-x-3 pt-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center">
                        <i class="fas fa-key mr-2"></i> Update Password
                    </button>
                    <button type="button" id="btn-auto-reset" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center">
                        <i class="fas fa-magic mr-2"></i> Reset ke "admin123"
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('btn-auto-reset').addEventListener('click', function() {
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
    </script>
</body>
</html>