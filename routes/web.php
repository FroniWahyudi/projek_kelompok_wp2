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

// Redirect root based on auth status
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/pengajuan-reset', [PasswordResetController::class, 'showRequestForm'])->name('pengajuan.reset.password');
    Route::post('/pengajuan-reset', [PasswordResetController::class, 'storeRequest'])->name('pengajuan.reset.form');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard & Profil
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard_profil', [DashboardController::class, 'profil'])->name('dashboard.profil');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // News routes
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

    // Admin CRUD Routes
    Route::prefix('admin')->name('admin.')->group(function () { 
        Route::get('/', [CrudController::class, 'adminIndex'])->name('index');
        Route::get('/create', [CrudController::class, 'showCreateForm'])->name('create');
        Route::post('/store', [CrudController::class, 'createAdmin'])->name('store');
        Route::get('/{id}/edit', [CrudController::class, 'adminEdit'])->name('edit');
        Route::put('/{id}', [CrudController::class, 'adminUpdate'])->name('update');
        Route::delete('/{id}', [CrudController::class, 'adminDestroy'])->name('destroy');
    });

    // Profile edit
    Route::get('/edit_profil/{id}', [DashboardController::class, 'edit'])->name('profil.edit');
    Route::put('/edit_profil/{id}', [DashboardController::class, 'update'])->name('profil.update');
    Route::put('/edit_profil/account/{id}', [PasswordResetController::class, 'resetPasswordManual'])->name('profil.update.account');

    // Shift view
    Route::get('/shift_karyawan', [ShiftController::class, 'index'])->name('shift.karyawan');

    // Resi & Laporan Kerja
    Route::get('/laporan_kerja', [ResiController::class, 'index'])->name('laporan.index');
    Route::get('/resi', [ResiController::class, 'index']);
    Route::post('/resi/update-status', [ResiController::class, 'updateStatus'])->name('resi.update_status');
    Route::resource('resi', ResiController::class)->except(['index', 'create', 'store']);
    Route::get('/buat-resi', [ResiController::class, 'create'])->name('resi.buat');
    Route::post('/buat-resi', [ResiController::class, 'store'])->name('resi.store');

    // Operator CRUD Routes
    Route::get('/operator', [CrudController::class, 'usersIndex'])->name('operator.index');
    Route::get('/operator/create', [CrudController::class, 'showCreateForm'])->name('operator.create');
    Route::post('/operator', [CrudController::class, 'createOperatorBaru'])->name('operator.store');
    Route::get('/operator/{id}/edit', [CrudController::class, 'usersEdit'])->name('operator.edit');
    Route::put('/operator/{id}', [CrudController::class, 'usersUpdate'])->name('operator.update');
    Route::delete('/operator/{id}', [CrudController::class, 'usersDestroy'])->name('operator.destroy');

    // Leader Routes
    Route::prefix('leader')->name('leader.')->group(function () {
        Route::get('/', [CrudController::class, 'leaderIndex'])->name('index');
        Route::get('/create', [CrudController::class, 'showCreateForm'])->name('create');
        Route::post('/store', [CrudController::class, 'createLeader'])->name('store');
        Route::get('/{id}/edit', [CrudController::class, 'leaderEdit'])->name('edit');
        Route::put('/{id}', [CrudController::class, 'leaderUpdate'])->name('update');
        Route::delete('/{id}', [CrudController::class, 'leaderDestroy'])->name('destroy');
    });

    // Slips routes
    Route::resource('slips', SlipController::class)->except(['show']);
    Route::get('/slip-create', [SlipController::class, 'create'])->name('slip_create');
    Route::get('/slips/{slip}', [SlipController::class, 'show'])->name('slips.show');
    Route::get('/slips/{slip}/pdf', [SlipController::class, 'downloadPdf'])->name('slips.pdf');
    Route::get('/slips/check', [SlipController::class, 'showCheckSlipForm'])->name('slips.check.form');
    Route::post('/slips/check', [SlipController::class, 'checkSlip'])->name('slips.check');
    Route::post('/slips/check-ajax', [SlipController::class, 'checkSlipAjax'])->name('slips.check.ajax');

    // Slip notification routes
    Route::prefix('slips/notifications')->name('slips.')->group(function () {
        Route::get('/check-latest', [SlipController::class, 'checkLatestPeriodSlip'])->name('checkLatestPeriodSlip');
        Route::post('/mark-as-read', [SlipController::class, 'markAsRead'])->name('markAsRead');
        Route::post('/status', [SlipController::class, 'getNotificationStatus'])->name('notifications.status');
        Route::get('/count', [SlipController::class, 'getNotificationCount'])->name('notifications.count');
        Route::get('/unread', [SlipController::class, 'getUnreadSlips'])->name('notifications.unread');
    });

    // Cuti routes
    Route::resource('cuti', CutiController::class);
    Route::post('cuti/{cuti}/accept', [CutiController::class, 'accept'])->name('cuti.accept');
    Route::post('cuti/{id}/reject', [CutiController::class, 'reject'])->name('cuti.reject');
    Route::post('cuti/reset', [CutiController::class, 'resetTahunan'])->name('cuti.reset');
    Route::get('cuti/sisa', [CutiController::class, 'sisaIndex'])->name('cuti.sisa.index');
    Route::put('cuti/sisa/{sisa}', [CutiController::class, 'sisaUpdate'])->name('cuti.sisa.update');
    Route::delete('cuti/{id}/batal', [CutiController::class, 'batal'])->name('cuti.batal');
    Route::post('/cuti/mark-as-read', [CutiController::class, 'markAsRead'])->name('cuti.markAsRead');

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

    // General user management by role (must be last to avoid conflicts)
    Route::get('/{role}', [CrudController::class, 'usersByRole'])->name('users.by.role');
    Route::get('/{role}/{id}/edit', [CrudController::class, 'editUser'])->name('users.edit');
    Route::put('/{role}/{id}', [CrudController::class, 'updateUser'])->name('users.update');
    Route::delete('/{role}/{id}', [CrudController::class, 'destroyUser'])->name('users.destroy');
    Route::post('/users', [CrudController::class, 'createUser'])->name('users.store');
});