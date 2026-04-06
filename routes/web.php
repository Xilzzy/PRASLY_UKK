<?php

// Pusat routing aplikasi PRASLY

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaduanController;

// Rute Autentikasi (Bisa diakses tanpa login)
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute Admin (Hanya untuk Admin)
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    // CRUD Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('admin.siswa.index');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('admin.siswa.store');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');

    // CRUD Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');

    // Kelola Pengaduan Siswa
    Route::get('/pengaduan', [PengaduanController::class, 'adminIndex'])->name('admin.pengaduan.index');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'adminDetail'])->name('admin.pengaduan.detail');
    Route::put('/pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])->name('admin.pengaduan.updateStatus');
    Route::post('/pengaduan/{id}/tanggapan', [PengaduanController::class, 'storeTanggapan'])->name('admin.pengaduan.tanggapan');
});

// Rute Siswa (Hanya untuk Siswa)
Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->group(function () {
    // Dashboard Siswa
    Route::get('/dashboard', [DashboardController::class, 'siswa'])->name('siswa.dashboard');

    // Kelola Pengaduan Sendiri
    Route::get('/pengaduan', [PengaduanController::class, 'siswaIndex'])->name('siswa.pengaduan.index');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('siswa.pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('siswa.pengaduan.store');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'siswaDetail'])->name('siswa.pengaduan.detail');
    Route::get('/pengaduan/{id}/edit', [PengaduanController::class, 'edit'])->name('siswa.pengaduan.edit');
    Route::put('/pengaduan/{id}', [PengaduanController::class, 'update'])->name('siswa.pengaduan.update');
    Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('siswa.pengaduan.destroy');
});
