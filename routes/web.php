<?php

use Illuminate\Support\Facades\Route;

// AUTH (Siswa & Admin)
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AdminAuthController;

// SISWA
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScanQrController;

// ADMIN
use App\Http\Controllers\AdminController;

// PROFILE
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| DEFAULT → Redirect ke Login Siswa
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('login.siswa.show'));


/*
| LOGIN SISWA
*/
Route::get('/login-siswa', [AuthController::class, 'showLoginSiswa'])
    ->name('login.siswa.show');

Route::post('/login-siswa', [AuthController::class, 'processLoginSiswa'])
    ->name('login.siswa.process');


/*
| SCAN QR (PUBLIC, TAPI DICEK DI CONTROLLER)
*/
Route::get('/scan', [ScanQrController::class, 'showScan'])
    ->name('user.scan');

Route::post('/scan', [ScanQrController::class, 'processScan'])
    ->name('user.scan.process');


/*
| FITUR SISWA (WAJIB LOGIN)
*/
Route::middleware('siswa.auth')->group(function () {

    Route::get('/dashboard-siswa', [AbsensiController::class, 'dashboard'])
        ->name('user.dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::post('/update-foto', [UserController::class, 'updateFoto'])
        ->name('user.updateFoto');

    Route::get('/success', [UserController::class, 'success'])
        ->name('user.success');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});


/*
|--------------------------------------------------------------------------
| LOGIN ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminAuthController::class, 'showLoginAdmin'])
    ->name('login.admin.show');

Route::post('/admin/login', [AdminAuthController::class, 'processLoginAdmin'])
    ->name('login.admin.process');


/*
|--------------------------------------------------------------------------
| FITUR ADMIN (HARUS LOGIN)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('admin.auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Grafik dengan filter dinamis
    Route::get('/graph/filter', [AdminController::class, 'graphFilter'])
        ->name('admin.graph.filter');

    // QR
    Route::get('/qr', [AdminController::class, 'generateQR'])
        ->name('admin.qr');

    Route::get('/qr/json', [AdminController::class, 'qrJson'])
        ->name('admin.qr.json');

    // Rekap Absensi
    Route::get('/rekap', [AdminController::class, 'rekap'])
        ->name('admin.rekap');

    // Export CSV
    Route::get('/rekap/export', [AdminController::class, 'rekapExport'])
        ->name('admin.rekap.export');

    // Absensi Manual
    Route::get('/absensi-manual', [AdminController::class, 'showAbsensiManual'])
        ->name('admin.absensi.manual');

    Route::post('/absensi-manual', [AdminController::class, 'storeAbsensiManual'])
        ->name('admin.absensi.manual.store');

    Route::patch('/absensi/{id}/status', [AdminController::class, 'updateAbsensiStatus'])
        ->name('admin.absensi.update');

    Route::delete('/absensi-manual/{id}', [AdminController::class, 'deleteAbsensiManual'])
        ->name('admin.absensi.manual.delete');

    // Tambah User
    Route::get('/create-user', [AdminController::class, 'showCreateUser'])
        ->name('admin.user.create');

    Route::post('/create-user', [AdminController::class, 'storeUser'])
        ->name('admin.user.store');

    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])
        ->name('admin.settings');

    Route::post('/settings', [AdminController::class, 'updateSettings'])
        ->name('admin.settings.update');

    // Kalender
    Route::get('/calendar', [AdminController::class, 'calendar'])
        ->name('admin.calendar');

    Route::get('/calendar/detail/{date}', [AdminController::class, 'calendarDetail'])
        ->name('admin.calendar.detail');

    Route::get('/calendar/data/{year}/{month}', [AdminController::class, 'calendarData'])
        ->name('admin.calendar.data');

    Route::get('/ranking', [AdminController::class, 'rankingKehadiran'])->name('admin.ranking');

    // ================= USERS MANAGEMENT =================
    Route::get('/users', [AdminController::class, 'manageUser'])
        ->name('admin.user.index');

    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])
        ->name('admin.user.edit');

    Route::put('/users/{id}', [AdminController::class, 'updateUser'])
        ->name('admin.user.update');

    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])
        ->name('admin.user.delete');

    Route::get('/live-monitor', [AdminController::class, 'liveMonitor'])
        ->name('admin.live.monitor');

    // Logout Admin
    Route::post('/logout', [AdminAuthController::class, 'logoutAdmin'])
        ->name('admin.logout');
});

Route::fallback(function () {
    return redirect()->route('login.siswa.show')
        ->with('error', 'Halaman tidak ditemukan.');
});
