<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\JenisDanaController;
use App\Http\Controllers\KasMasukController;
use App\Http\Controllers\PenggunaController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));
Route::redirect('/home', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin dan bendahara: hanya melihat
    Route::middleware(RoleMiddleware::class . ':admin,bendahara')->group(function () {
        Route::get('/donatur', [DonaturController::class, 'index'])->name('donatur.index');
        Route::get('/kas', [KasMasukController::class, 'index'])->name('kas.index');
        Route::get('/kas/{id}/bukti', [KasMasukController::class, 'bukti'])->whereNumber('id')->name('kas.bukti');
    });

    // Admin: kelola pengguna, jenis dana, dan data jamaah/donatur
    Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
        Route::get('/jenis-dana', [JenisDanaController::class, 'index'])->name('jenis-dana.index');
        Route::post('/jenis-dana', [JenisDanaController::class, 'store'])->name('jenis-dana.store');
        Route::get('/jenis-dana/{id}/ubah', [JenisDanaController::class, 'edit'])->whereNumber('id')->name('jenis-dana.edit');
        Route::put('/jenis-dana/{id}', [JenisDanaController::class, 'update'])->whereNumber('id')->name('jenis-dana.update');
        Route::delete('/jenis-dana/{id}', [JenisDanaController::class, 'destroy'])->whereNumber('id')->name('jenis-dana.destroy');

        Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
        Route::get('/pengguna/tambah', [PenggunaController::class, 'create'])->name('pengguna.create');
        Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
        Route::get('/pengguna/{id}/ubah', [PenggunaController::class, 'edit'])->whereNumber('id')->name('pengguna.edit');
        Route::put('/pengguna/{id}', [PenggunaController::class, 'update'])->whereNumber('id')->name('pengguna.update');
        Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->whereNumber('id')->name('pengguna.destroy');

        Route::get('/donatur/tambah', [DonaturController::class, 'create'])->name('donatur.create');
        Route::post('/donatur', [DonaturController::class, 'store'])->name('donatur.store');
        Route::get('/donatur/{id}/ubah', [DonaturController::class, 'edit'])->whereNumber('id')->name('donatur.edit');
        Route::put('/donatur/{id}', [DonaturController::class, 'update'])->whereNumber('id')->name('donatur.update');
        Route::delete('/donatur/{id}', [DonaturController::class, 'destroy'])->whereNumber('id')->name('donatur.destroy');
    });

    // Bendahara: mencatat kas masuk
    Route::middleware(RoleMiddleware::class . ':bendahara')->group(function () {
        Route::get('/kas/catat', [KasMasukController::class, 'create'])->name('kas.create');
        Route::post('/kas', [KasMasukController::class, 'store'])->name('kas.store');
        Route::get('/kas/{id}/ubah', [KasMasukController::class, 'edit'])->whereNumber('id')->name('kas.edit');
        Route::put('/kas/{id}', [KasMasukController::class, 'update'])->whereNumber('id')->name('kas.update');
        Route::delete('/kas/{id}', [KasMasukController::class, 'destroy'])->whereNumber('id')->name('kas.destroy');
    });
});
