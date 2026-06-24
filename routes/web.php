<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;

// ── PUBLIC ─────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lomba/{lomba}', [LombaController::class, 'show'])->name('lomba.show');
Route::post('/lomba/{lomba}/daftar', [LombaController::class, 'daftar'])->name('lomba.daftar');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/publikasi', [\App\Http\Controllers\PublikasiController::class, 'index'])->name('publikasi.index');

Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blog.show');


// ── PAYMENT ────────────────────────────────────────────────────────────
Route::get('/payment/{pendaftaran}/pay', [\App\Http\Controllers\PaymentController::class, 'pay'])->name('payment.pay');
Route::post('/payment/callback', [\App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/success', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [\App\Http\Controllers\PaymentController::class, 'failed'])->name('payment.failed');

// ── ADMIN AUTH (tidak perlu login) ─────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [Admin\AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');
});

// ── ADMIN PANEL (wajib login) ───────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(AdminAuth::class)->group(function () {

    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Lomba
    Route::resource('lomba', Admin\LombaController::class);

    // Pendaftaran
    Route::get('pendaftaran', [Admin\PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('pendaftaran/export', [Admin\PendaftaranController::class, 'export'])->name('pendaftaran.export');
    Route::get('pendaftaran/{pendaftaran}', [Admin\PendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::patch('pendaftaran/{pendaftaran}/status', [Admin\PendaftaranController::class, 'updateStatus'])->name('pendaftaran.status');
    Route::delete('pendaftaran/{pendaftaran}', [Admin\PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');

    // Blog
    Route::resource('blog', Admin\BlogController::class);

    // Peserta & Publikasi
    Route::get('peserta/import', [Admin\PesertaController::class, 'importForm'])->name('peserta.import.form');
    Route::post('peserta/import', [Admin\PesertaController::class, 'import'])->name('peserta.import');
    Route::post('peserta/publish-all', [Admin\PesertaController::class, 'publishAll'])->name('peserta.publish-all');
    Route::post('peserta/unpublish-all', [Admin\PesertaController::class, 'unpublishAll'])->name('peserta.unpublish-all');
    Route::resource('peserta', Admin\PesertaController::class, ['parameters' => ['peserta' => 'peserta']]);

    // Galeri
    Route::get('galeri', [Admin\GaleriController::class, 'index'])->name('galeri.index');
    Route::post('galeri', [Admin\GaleriController::class, 'store'])->name('galeri.store');
    Route::delete('galeri/{galeri}', [Admin\GaleriController::class, 'destroy'])->name('galeri.destroy');
    Route::patch('galeri/{galeri}/toggle', [Admin\GaleriController::class, 'toggleActive'])->name('galeri.toggle');
});
