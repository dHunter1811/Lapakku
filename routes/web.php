<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LahanController; // Tetap diperlukan untuk index, show, edit, update, destroy
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PengajuanSewaController;
use App\Http\Controllers\PemilikDashboardController;
use App\Http\Controllers\TambahLahanController; // TAMBAHKAN IMPORT INI
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LahanManagementController as AdminLahanManagementController;
use App\Http\Controllers\Admin\RatingManagementController as AdminRatingManagementController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\UserManagementController as AdminUserManagementController;

// Halaman Publik Umum
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/kontak', [PageController::class, 'showContactForm'])->name('kontak.show');
Route::post('/kontak', [PageController::class, 'storeContactMessage'])->name('kontak.store');
Route::get('/tentang-kami', [PageController::class, 'showTentangKami'])->name('tentang-kami.show');
Route::get('/bantuan', [PageController::class, 'showBantuan'])->name('bantuan.show');

// Rute Lahan yang publik (index & show)
Route::get('lahan', [LahanController::class, 'index'])->name('lahan.index');
Route::get('lahan/{lahan}', [LahanController::class, 'show'])->name('lahan.show');

// Rute Autentikasi untuk Tamu (Guest)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// Rute yang Membutuhkan Autentikasi Pengguna
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // === RUTE BARU UNTUK TAMBAH LAHAN ===
    Route::get('lahan-baru/tambah', [TambahLahanController::class, 'formTambah'])->name('lahanbaru.tambah');
    Route::post('lahan-baru/simpan', [TambahLahanController::class, 'simpanLahanBaru'])->name('lahanbaru.simpan');
    // ===================================

    // Rute Lahan untuk edit, update, destroy (tetap menggunakan LahanController)
    Route::get('lahan/{lahan}/edit', [LahanController::class, 'edit'])->name('lahan.edit');
    Route::put('lahan/{lahan}', [LahanController::class, 'update'])->name('lahan.update');
    Route::delete('lahan/{lahan}', [LahanController::class, 'destroy'])->name('lahan.destroy');
    // Catatan: Route::resource('lahan', LahanController::class)->except(['index', 'show', 'create', 'store']);
    // juga bisa digunakan di sini jika ingin lebih ringkas untuk edit, update, destroy.

    // Memberi rating
    Route::post('lahan/{lahan}/ratings', [RatingController::class, 'store'])->name('lahan.ratings.store');

    // Profil Pengguna
    Route::get('/profil/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [UserProfileController::class, 'update'])->name('profile.update');

    // Pengajuan Sewa oleh pengguna
    Route::post('/lahan/{lahan}/ajukan-sewa', [PengajuanSewaController::class, 'store'])->name('pengajuan-sewa.store');

    // Dashboard Pemilik Lahan
    Route::get('/dashboard-pemilik', [PemilikDashboardController::class, 'index'])->name('pemilik.dashboard');
    Route::patch('/pengajuan-sewa/{pengajuanSewa}/setujui', [PemilikDashboardController::class, 'setujui'])->name('pemilik.pengajuan.setujui');
    Route::patch('/pengajuan-sewa/{pengajuanSewa}/tolak', [PemilikDashboardController::class, 'tolak'])->name('pemilik.pengajuan.tolak');
});

// Rute Admin (tetap sama)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // ... (Rute admin Anda tetap sama) ...
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('lahan', [AdminLahanManagementController::class, 'index'])->name('lahan.index');
    Route::get('lahan/create', [AdminLahanManagementController::class, 'create'])->name('lahan.create');
    Route::post('lahan', [AdminLahanManagementController::class, 'store'])->name('lahan.store');
    Route::get('lahan/{lahan}/edit', [AdminLahanManagementController::class, 'edit'])->name('lahan.edit');
    Route::put('lahan/{lahan}', [AdminLahanManagementController::class, 'update'])->name('lahan.update');
    Route::patch('lahan/{lahan}/approve', [AdminLahanManagementController::class, 'approve'])->name('lahan.approve');
    Route::patch('lahan/{lahan}/reject', [AdminLahanManagementController::class, 'reject'])->name('lahan.reject');
    Route::delete('lahan/{lahan}', [AdminLahanManagementController::class, 'destroy'])->name('lahan.destroy');
    Route::get('ratings', [AdminRatingManagementController::class, 'index'])->name('ratings.index');
    Route::delete('ratings/{rating}', [AdminRatingManagementController::class, 'destroy'])->name('ratings.destroy');
    Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');
    Route::resource('users', AdminUserManagementController::class);
});
