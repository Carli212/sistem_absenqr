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
| DEFAULT → Arahkan ke Login Siswa
|--------------------------------------------------------------------------
*/
Route::get('/', function() {
    return redirect()->route('login.siswa.show');
});


/*
|--------------------------------------------------------------------------
| UPLOAD FOTO PROFIL SISWA
|--------------------------------------------------------------------------
*/
Route::post('/update-foto', [UserController::class, 'updateFoto'])
    ->name('user.updateFoto');


/*
|--------------------------------------------------------------------------
| LOGIN SISWA
|--------------------------------------------------------------------------
*/
Route::get('/login-siswa',  [AuthController::class, 'showLoginSiswa'])
    ->name('login.siswa.show');

Route::post('/login-siswa', [AuthController::class, 'processLoginSiswa'])
    ->name('login.siswa.process');


/*
|--------------------------------------------------------------------------
| SCAN QR (halaman + proses)
|--------------------------------------------------------------------------
*/
Route::get('/scan',  [ScanQrController::class, 'showScan'])
    ->name('user.scan');

Route::post('/scan', [ScanQrController::class, 'processScan'])
    ->name('user.scan.process');


/*
|--------------------------------------------------------------------------
| FITUR SISWA (HARUS LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('siswa.auth')->group(function () {

    Route::get('/dashboard-siswa', [AbsensiController::class, 'dashboard'])
        ->name('user.dashboard');

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
| FITUR ADMIN (HARUS LOGIN ADMIN)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('admin.auth')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // QR Code (tampilan)
    Route::get('/qr', [AdminController::class, 'generateQR'])
        ->name('admin.qr');

    // QR Code (JSON, untuk refresh otomatis)
    Route::get('/qr/json', [AdminController::class, 'qrJson'])
        ->name('admin.qr.json');

    // Rekap Absensi
    Route::get('/rekap', [AdminController::class, 'rekap'])
        ->name('admin.rekap');

    // Absensi Manual
    Route::get('/absensi-manual', [AdminController::class, 'showAbsensiManual'])
        ->name('admin.absensi.manual');

    Route::post('/absensi-manual', [AdminController::class, 'storeAbsensiManual'])
        ->name('admin.absensi.manual.store');

    Route::delete('/absensi-manual/{id}', [AdminController::class, 'deleteAbsensiManual'])
        ->name('admin.absensi.manual.delete');

    // Logout Admin
    Route::post('/logout', [AdminAuthController::class, 'logoutAdmin'])
        ->name('admin.logout');
});


/*
|--------------------------------------------------------------------------
| PROFIL SISWA
|--------------------------------------------------------------------------
*/
Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile');