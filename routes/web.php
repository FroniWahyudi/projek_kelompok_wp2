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
use App\Http\Controllers\PasswordResetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard & Profil
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard_profil', [DashboardController::class, 'profil'])->name('dashboard.profil');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // News detail
    Route::get('/whats-new/create', [NewsController::class, 'create'])->name('whats_new.create');
    Route::post('/whats-new/store', [NewsController::class, 'store'])->name('whats_new.store');
    Route::get('/whats-new/edit/{id}', [NewsController::class, 'edit'])->name('whats_new.edit');
    Route::put('/whats-new/update/{id}', [NewsController::class, 'update'])->name('whats_new.update');
    Route::delete('/whats-new/delete/{id}', [NewsController::class, 'destroy'])->name('whats_new.delete');
    Route::get('/whats-new/{id}', [NewsController::class, 'show'])->name('whats_new');

    // HR sections
    Route::get('/admin', [HrDashboardController::class, 'hr_index'])->name('hr.admin');
    Route::get('/leader', [HrDashboardController::class, 'leader_index'])->name('hr.leader');
    Route::get('/manajemen', [HrDashboardController::class, 'manajemen_index'])->name('hr.manajemen');
    Route::post('/karyawan/update_sisa_cuti', [HrDashboardController::class, 'updateSisaCuti'])->name('karyawan.update_sisa_cuti');

    // Profile edit
    Route::get('/edit_profil/{id}', [DashboardController::class, 'edit'])->name('profil.edit');
    Route::put('/edit_profil/{id}', [DashboardController::class, 'update'])->name('profil.update');

    // Shift view
    Route::get('/shift_karyawan', [ShiftController::class, 'index'])->name('shift.karyawan');

    // Resi & Laporan Kerja
    Route::get('/laporan_kerja', [ResiController::class, 'index'])->name('laporan.index');
    Route::get('/resi', [ResiController::class, 'index']);
    Route::post('/resi/update-status', [ResiController::class, 'updateStatus'])->name('resi.update_status');
    Route::resource('resi', ResiController::class)->except(['index', 'create', 'store']);
    Route::get('/buat-resi', [ResiController::class, 'create'])->name('resi.buat');
    Route::post('/buat-resi', [ResiController::class, 'store'])->name('resi.store');

    // Operator CRUD
    Route::get('/operator', [CrudController::class, 'usersIndex'])->name('operator.index');
    Route::get('/operator/{id}/edit', [CrudController::class, 'usersEdit'])->name('operator.edit');
    Route::put('/operator/{id}', [CrudController::class, 'usersUpdate'])->name('operator.update');

    // Slips routes
    Route::resource('slips', SlipController::class)->except(['show']);
    Route::get('/slip-create', [SlipController::class, 'create'])->name('slip_create');
    Route::get('/slips/{slip}', [SlipController::class, 'show'])->name('slips.show');
    Route::get('/slips/{slip}/pdf', [SlipController::class, 'downloadPdf'])->name('slips.pdf');
    Route::get('/slips/check', [SlipController::class, 'showCheckSlipForm'])->name('slips.check.form');
    Route::post('/slips/check', [SlipController::class, 'checkSlip'])->name('slips.check');
    Route::post('/slips/check-ajax', [SlipController::class, 'checkSlipAjax'])->name('slips.check.ajax');

    // Cuti routes
    Route::resource('cuti', CutiController::class);
    Route::post('cuti/{cuti}/accept', [CutiController::class, 'accept'])->name('cuti.accept');
    Route::post('cuti/{id}/reject', [CutiController::class, 'reject'])->name('cuti.reject');
    Route::post('cuti/reset', [CutiController::class, 'resetTahunan'])->name('cuti.reset');
    Route::get('cuti/sisa', [CutiController::class, 'sisaIndex'])->name('cuti.sisa.index');
    Route::put('cuti/sisa/{sisa}', [CutiController::class, 'sisaUpdate'])->name('cuti.sisa.update');
    Route::delete('cuti/{id}/batal', [CutiController::class, 'batal'])->name('cuti.batal');

    // Shift routes
    Route::resource('shifts', ShiftController::class)->except(['create', 'show', 'edit']);

    // Feedback routes
    Route::get('/feedback', [CrudController::class, 'feedbackIndex'])->name('feedback.index');
    Route::post('/feedback', [CrudController::class, 'feedbackStore'])->name('feedback.store');
    Route::get('/feedback/{id}/edit', [CrudController::class, 'feedbackEdit'])->name('feedback.edit');
    Route::put('/feedback/{id}', [CrudController::class, 'feedbackUpdate'])->name('feedback.update');

    // Reset Password routes
    Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('reset.password.form');
    Route::post('/reset-password/{id}', [PasswordResetController::class, 'resetPassword'])->name('reset.password');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPasswordManual'])->name('reset.password.manual');
    Route::get('/check-reset-requests', [PasswordResetController::class, 'checkRequests'])->name('check.reset.requests');
});

//biar bisa akses form pengajuan reset password tanpa login
Route::get('/pengajuan-reset', [PasswordResetController::class, 'showRequestForm'])->name('pengajuan.reset.password');
Route::post('/pengajuan-reset', [PasswordResetController::class, 'storeRequest'])->name('pengajuan.reset.form');

