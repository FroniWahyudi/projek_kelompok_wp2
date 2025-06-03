<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiKaryawanController;
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
    Route::get('/manajemen', [DivisiKaryawanController::class, 'manajemen_index'])->name('hr.manajemen');
    
    // Admin CRUD Routes
    Route::prefix('admin')->name('admin.')->group(function () { 
        Route::get('/', [DivisiKaryawanController::class, 'adminIndex'])->name('index');
        Route::get('/create', [DivisiKaryawanController::class, 'showCreateForm'])->name('create');
        Route::post('/store', [DivisiKaryawanController::class, 'createAdmin'])->name('store');
        Route::get('/{id}/edit', [DivisiKaryawanController::class, 'adminEdit'])->name('edit');
        Route::put('/{id}', [DivisiKaryawanController::class, 'adminUpdate'])->name('update');
        Route::delete('/{id}', [DivisiKaryawanController::class, 'adminDestroy'])->name('destroy');
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
    Route::resource('resi', ResiController::class)->except(['index']);
    Route::get('/buat-resi', [ResiController::class, 'create'])->name('resi.buat');
    Route::post('/buat-resi', [ResiController::class, 'store'])->name('resi.store');
    Route::delete('/resi/{id}', [ResiController::class, 'destroy'])->name('resi.destroy');

    // Operator CRUD Routes
    Route::prefix('operator')->name('operator.')->group(function () {
        Route::get('/', [DivisiKaryawanController::class, 'usersIndex'])->name('index');
        Route::get('/create', [DivisiKaryawanController::class, 'showCreateForm'])->name('create');
        Route::post('/', [DivisiKaryawanController::class, 'createOperator'])->name('store');
        Route::get('/{id}/edit', [DivisiKaryawanController::class, 'usersEdit'])->name('edit');
        Route::put('/{id}', [DivisiKaryawanController::class, 'usersUpdate'])->name('update');
        Route::delete('/{id}', [DivisiKaryawanController::class, 'usersDestroy'])->name('destroy');
    });
    // Leader Routes
    Route::prefix('leader')->name('leader.')->group(function () {
        Route::get('/', [DivisiKaryawanController::class, 'leaderIndex'])->name('index');
        Route::get('/create', [DivisiKaryawanController::class, 'showCreateForm'])->name('create');
        Route::post('/store', [DivisiKaryawanController::class, 'createLeader'])->name('store');
        Route::get('/{id}/edit', [DivisiKaryawanController::class, 'leaderEdit'])->name('edit');
        Route::put('/{id}', [DivisiKaryawanController::class, 'leaderUpdate'])->name('update');
        Route::delete('/{id}', [DivisiKaryawanController::class, 'leaderDestroy'])->name('destroy');
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
    Route::get('/{role}', [DivisiKaryawanController::class, 'usersByRole'])->name('users.by.role');
    Route::get('/{role}/{id}/edit', [DivisiKaryawanController::class, 'editUser'])->name('users.edit');
    Route::put('/{role}/{id}', [DivisiKaryawanController::class, 'updateUser'])->name('users.update');
    Route::delete('/{role}/{id}', [DivisiKaryawanController::class, 'destroyUser'])->name('users.destroy');
    Route::post('/users', [DivisiKaryawanController::class, 'createUser'])->name('users.store');
});