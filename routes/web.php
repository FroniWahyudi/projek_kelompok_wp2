<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HrDashboardController;
use App\Http\Controllers\LaporanKerjaController;

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
    Route::get('/admin', [HrDashboardController::class, 'hr_index']);
    Route::get('/leader', [HrDashboardController::class, 'leader_index']);
    Route::get('/manajemen', [HrDashboardController::class, 'manajemen_index']);
    Route::get('/operator', [HrDashboardController::class, 'karyawan_index']);
    Route::post('/karyawan/update_sisa_cuti', [HrDashboardController::class, 'updateSisaCuti'])->name('karyawan.update_sisa_cuti');
    Route::get('/edit_profil/{id}', [DashboardController::class, 'edit'])->name('profil.edit');
    Route::put('/edit_profil/{id}', [DashboardController::class, 'update'])->name('profil.update');
    route::get('/shift_karyawan', function() {
        return view('index.shift_karyawan');
    });
    Route::get('/laporan_kerja', [LaporanKerjaController::class, 'index'])->name('laporan.index');

    // Add other protected routes here
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Optional: Registration routes
    // Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // Route::post('/register', [RegisterController::class, 'register']);
});
