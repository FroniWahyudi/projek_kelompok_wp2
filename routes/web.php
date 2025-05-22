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
*/

Route::get('/', function() {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])
         ->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard & Profil
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');
    Route::get('/dashboard_profil', [DashboardController::class, 'profil'])
         ->name('dashboard.profil');
    Route::get('/logout', [AuthController::class, 'logout'])
         ->name('logout');

    // News detail
    Route::get('/whats-new/{id}', [NewsController::class, 'show'])
         ->name('whats_new');

    // HR sections
    Route::get('/admin', [HrDashboardController::class, 'hr_index'])
         ->name('hr.admin');
    Route::get('/leader', [HrDashboardController::class, 'leader_index'])
         ->name('hr.leader');
    Route::get('/manajemen', [HrDashboardController::class, 'manajemen_index'])
         ->name('hr.manajemen');
    Route::post('/karyawan/update_sisa_cuti', [HrDashboardController::class, 'updateSisaCuti'])
         ->name('karyawan.update_sisa_cuti');

    // Profile edit
    Route::get('/edit_profil/{id}', [DashboardController::class, 'edit'])
         ->name('profil.edit');
    Route::put('/edit_profil/{id}', [DashboardController::class, 'update'])
         ->name('profil.update');

    // Shift view
    Route::view('/shift_karyawan', 'index.shift_karyawan')
         ->name('shift.karyawan');

    // === Resi & Laporan Kerja ===

    // 1. Halaman laporan (index)
    Route::get('/laporan_kerja', [ResiController::class, 'index'])
         ->name('laporan.index');
    // 2. Alias /resi → laporan (tanpa name)
    Route::get('/resi', [ResiController::class, 'index']);

    // 3. AJAX: update status
    Route::post('/resi/update-status', [ResiController::class, 'updateStatus'])
         ->name('resi.update_status');

    // 4. Resourceful CRUD untuk Resi, tanpa index/create/store
    Route::resource('resi', ResiController::class)
         ->except(['index', 'create', 'store']);

    // Operator CRUD
    Route::get('/operator', [CrudController::class, 'usersIndex'])
         ->name('operator.index');
    Route::get('/operator/{id}/edit', [CrudController::class, 'usersEdit'])
         ->name('operator.edit');
    Route::put('/operator/{id}', [CrudController::class, 'usersUpdate'])
         ->name('operator.update');
});

// 5. Halaman terpisah: Buat Resi & Proses Simpan
Route::middleware('auth')->group(function () {
    Route::get('/buat-resi', [ResiController::class, 'create'])
         ->name('resi.buat');
    Route::post('/buat-resi', [ResiController::class, 'store'])
         ->name('resi.store');
});
