<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HrDashboardController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\ResiController;

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

Route::get('/', function() {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

// Routes requiring authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard_profil', [DashboardController::class, 'profil']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/whats-new/{id}', [NewsController::class, 'show'])->name('whats_new');
    Route::get('/admin', [HrDashboardController::class, 'hr_index']);
    Route::get('/leader', [HrDashboardController::class, 'leader_index']);
    Route::get('/manajemen', [HrDashboardController::class, 'manajemen_index']);

    Route::post('/karyawan/update_sisa_cuti', [HrDashboardController::class, 'updateSisaCuti'])->name('karyawan.update_sisa_cuti');
    Route::get('/edit_profil/{id}', [DashboardController::class, 'edit'])->name('profil.edit');
    Route::put('/edit_profil/{id}', [DashboardController::class, 'update'])->name('profil.update');

    Route::view('/shift_karyawan', 'index.shift_karyawan');

    // Laporan kerja menggunakan ResiController
    Route::get('/laporan_kerja', [ResiController::class, 'index'])->name('laporan.index');

    // Operator CRUD
    Route::get('operator/{id}/edit',   [CrudController::class,'usersEdit'])->name('operator.edit');
    Route::put('operator/{id}',        [CrudController::class,'usersUpdate'])->name('operator.update');
    Route::get('/operator',            [CrudController::class,'usersIndex'])->name('operator.index');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    // Registration routes (optional)
    // Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // Route::post('/register', [RegisterController::class, 'register']);
});
