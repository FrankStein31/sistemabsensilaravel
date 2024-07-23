<?php

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TuController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StudentAttendanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\settingtucontroller;

// Landing page
Route::get('/', function () {
    return view('landingpage.landingpage1');
});

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('student_attendances', StudentAttendanceController::class);

Route::middleware(['auth', 'role:admin_sekolah'])->group(function () {
    // Route::get('admin/dashboard', [SiswaController::class, 'dashboard'])->name('admin_sekolah.dashboard');
    // Route::get('admin/manajemendatasiswa', [SiswaController::class, 'index'])->name('admin_sekolah.manajemendatasiswa');
    // Route::get('admin/siswa/create', [SiswaController::class, 'create'])->name('admin_sekolah.siswa.create');
    // Route::post('admin/siswa/store', [SiswaController::class, 'store'])->name('admin_sekolah.siswa.store');
    // Route::get('admin/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('admin_sekolah.siswa.edit');
    // Route::put('admin/siswa/{siswa}', [SiswaController::class, 'update'])->name('admin_sekolah.siswa.update');
    // Route::delete('admin/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('admin_sekolah.siswa.destroy');
    // Route::get('admin/kehadiran', [SiswaController::class, 'kehadiran'])->name('admin_sekolah.kehadiran');
    // Route::post('/presensi', [SiswaController::class, 'handlePresensi']);
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('admin_sekolah.dashboard');
    Route::get('/siswas', [SiswaController::class, 'index'])->name('admin_sekolah.manajemendatasiswa');
    Route::get('/siswas/create', [SiswaController::class, 'create'])->name('admin_sekolah.create_siswa');
    Route::post('/siswas', [SiswaController::class, 'store'])->name('admin_sekolah.siswa.store');
    Route::get('/siswas/{siswa}/edit', [SiswaController::class, 'edit'])->name('admin_sekolah.edit_siswa');
    Route::put('/siswas/{siswa}', [SiswaController::class, 'update'])->name('admin_sekolah.update_siswa');
    Route::delete('/siswas/{siswa}', [SiswaController::class, 'destroy'])->name('admin_sekolah.destroy_siswa');
    Route::get('/kehadiran', [SiswaController::class, 'kehadiran'])->name('admin_sekolah.kehadiran');
    Route::post('/presensi', [SiswaController::class, 'handlePresensi'])->name('admin_sekolah.presensi');
    Route::get('/get-rfid-uid', [SiswaController::class, 'getRfidUid'])->name('admin_sekolah.getRfidUid');
    Route::get('/api/siswa/{nis}', [SiswaController::class, 'getSiswaByNIS']);
});

Route::middleware(['auth', 'role:admin_tu'])->group(function () {
    Route::get('admin_tu/dashboard', [TuController::class, 'dashboard'])->name('admin_tu.dashboard');
    Route::get('admin_tu/kehadiran', [TuController::class, 'kehadiran'])->name('admin_tu.kehadiran');
    Route::get('admin_tu/kehadiran/download-pdf', [TuController::class, 'downloadPdf'])->name('admin_tu.kehadiran.downloadPdf');
    Route::get('admin_tu/kehadiran/download-excel', [TuController::class, 'downloadExcel'])->name('admin_tu.kehadiran.downloadExcel');
    Route::get('/admin/tu/download/excel', [TuController::class, 'downloadExcel'])->name('admin.tu.download.excel');
});

// Route::middleware(['auth', 'role:siswa'])->group(function () {
//     Route::get('siswa/dashboard', [UserSiswaController::class, 'index'])->name('siswa.dashboard');
//     Route::get('siswa/riwayat-presensi', [UserSiswaController::class, 'kehadiran'])->name('siswa.riwayatPresensi');
// });

Route::get('siswa/login', [App\Http\Controllers\Auth\StudentLoginController::class, 'showLoginForm'])->name('siswa.login');
Route::post('siswa/login', [App\Http\Controllers\Auth\StudentLoginController::class, 'login'])->name('siswa.login.submit');
Route::post('siswa/logout', [App\Http\Controllers\Auth\StudentLoginController::class, 'logout'])->name('siswa.logout');

Route::middleware(['auth:student'])->group(function () {
    Route::get('siswa/dashboard', [App\Http\Controllers\UserSiswaController::class, 'index'])->name('siswa.dashboard');
    Route::get('siswa/riwayat-presensi', [App\Http\Controllers\UserSiswaController::class, 'kehadiran'])->name('siswa.riwayatPresensi');
});

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::resource('settingtu', settingtucontroller::class);
    Route::resource('setting', SettingController::class);
});