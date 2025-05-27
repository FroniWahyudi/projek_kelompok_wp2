<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HrDashboardController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\ResiController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\SlipController;

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
     Route::get('/whats-new/edit/{id}', [NewsController::class, 'edit'])
         ->name('whats_new.edit');
     Route::put('/whats-new/update/{id}', [NewsController::class, 'update'])
         ->name('whats_new.update'); 
     Route::get('/whats-new/create', [NewsController::class, 'create'])
         ->name('whats_new.create');
     Route::post('/whats-new/store', [NewsController::class, 'store'])
         ->name('whats_new.store');

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

    // Slips routes
    Route::resource('slips', SlipController::class)
         ->except(['show']);  // Mengecualikan show karena akan ditambahkan secara manual
    Route::get('/slip-create', [SlipController::class, 'create'])->name('slip_create');
    // Tambahkan rute untuk slips.show
    Route::get('/slips/{slip}', [SlipController::class, 'show'])->name('slips.show');
    // Tambahkan rute untuk download PDF
    Route::get('/slips/{slip}/pdf', [SlipController::class, 'downloadPdf'])->name('slips.pdf');
});

// 5. Halaman terpisah: Buat Resi & Proses Simpan
Route::middleware('auth')->group(function () {
    Route::get('/buat-resi', [ResiController::class, 'create'])
         ->name('resi.buat');
    Route::post('/buat-resi', [ResiController::class, 'store'])
         ->name('resi.store');
});

// Grup route untuk Cuti
Route::middleware('auth')->group(function() {
    Route::resource('cuti', CutiController::class);
    Route::post('cuti/{cuti}/accept', [CutiController::class, 'accept'])
         ->name('cuti.accept');

    // Route reset tahunan
    Route::post('cuti/reset', [CutiController::class, 'resetTahunan'])
         ->name('cuti.reset');
});

// Grup lain untuk sisa cuti
Route::middleware('auth')->group(function () {
    // Tampilkan halaman rekap sisa cuti
    Route::get('cuti/sisa', [CutiController::class, 'sisaIndex'])
         ->name('cuti.sisa.index');

    // Proses update sisa cuti
    Route::put('cuti/sisa/{sisa}', [CutiController::class, 'sisaUpdate'])
         ->name('cuti.sisa.update');

    Route::post('/cuti/{id}/reject', [CutiController::class, 'reject'])->name('cuti.reject');
});

// Shift view
Route::middleware('auth')->group(function () {
    Route::get('/shift_karyawan', [ShiftController::class, 'index'])->name('shift.karyawan');

    // Resource route untuk shifts (index, store, update, destroy)
    Route::resource('shifts', ShiftController::class)->except(['create', 'show', 'edit']);
});

// Feedback pegawai
Route::middleware('auth')->group(function () {
    Route::get('/feedback', [CrudController::class, 'feedbackIndex'])->name('feedback.index');
    Route::post('/feedback', [CrudController::class, 'feedbackStore'])->name('feedback.store');
    Route::get('/feedback/{id}/edit', [CrudController::class, 'feedbackEdit'])->name('feedback.edit');
    Route::put('/feedback/{id}', [CrudController::class, 'feedbackUpdate'])->name('feedback.update');
});