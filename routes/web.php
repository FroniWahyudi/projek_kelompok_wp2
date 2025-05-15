<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HrDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
route::get('/', function() {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    else {
        return redirect('/login');
    }
});

Route::middleware(['auth'])->group(function () {
    // All routes that require authentication
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard_profil', [DashboardController::class, 'profil']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/whats-new/{id}', [NewsController::class, 'show'])->name('whats_new');
    Route::get('/hr', [HrDashboardController::class, 'hr_index']);
    Route::get('/manajemen', [HrDashboardController::class, 'manajemen_index']);
    Route::get('/edit_profil/{id}', [DashboardController::class, 'edit'])->name('profil.edit');
    Route::put('/edit_profil/{id}', [DashboardController::class, 'update'])->name('profil.update');

    // Add other protected routes here
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Optional: Registration routes
    // Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // Route::post('/register', [RegisterController::class, 'register']);
});
