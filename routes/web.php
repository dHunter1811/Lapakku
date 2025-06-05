<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PengajuanSewaController;
use App\Http\Controllers\PemilikDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LahanManagementController as AdminLahanManagementController;
use App\Http\Controllers\Admin\RatingManagementController as AdminRatingManagementController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\UserManagementController as AdminUserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Halaman Publik Umum
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/kontak', [PageController::class, 'showContactForm'])->name('kontak.show');
Route::post('/kontak', [PageController::class, 'storeContactMessage'])->name('kontak.store');
Route::get('/tentang-kami', [PageController::class, 'showTentangKami'])->name('tentang-kami.show');
Route::get('/bantuan', [PageController::class, 'showBantuan'])->name('bantuan.show'); // Rute Bantuan ditambahkan

// Rute Lahan yang publik (index & show)
Route::get('lahan', [LahanController::class, 'index'])->name('lahan.index');
Route::get('lahan/{lahan}', [LahanController::class, 'show'])->name('lahan.show');


// Rute Autentikasi untuk Tamu (Guest)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    // Route untuk Lupa Password bisa ditambahkan di sini jika diperlukan
});

// Rute yang Membutuhkan Autentikasi Pengguna (User yang sudah login)
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Lahan oleh pengguna (create, store, edit, update, destroy)
    // Method 'index' & 'show' sudah publik, jadi dikecualikan dari resource yang butuh auth di sini
    Route::resource('lahan', LahanController::class)->except(['index', 'show']);

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

    // (Opsional) Rute untuk user dashboard umum lainnya jika ada
    // Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});


// Rute Admin (Membutuhkan autentikasi DAN role admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Lahan oleh Admin
    Route::get('lahan', [AdminLahanManagementController::class, 'index'])->name('lahan.index');
    Route::get('lahan/create', [AdminLahanManagementController::class, 'create'])->name('lahan.create'); // Jika admin bisa create
    Route::post('lahan', [AdminLahanManagementController::class, 'store'])->name('lahan.store');       // Jika admin bisa store
    Route::get('lahan/{lahan}/edit', [AdminLahanManagementController::class, 'edit'])->name('lahan.edit');
    Route::put('lahan/{lahan}', [AdminLahanManagementController::class, 'update'])->name('lahan.update');
    Route::patch('lahan/{lahan}/approve', [AdminLahanManagementController::class, 'approve'])->name('lahan.approve');
    Route::patch('lahan/{lahan}/reject', [AdminLahanManagementController::class, 'reject'])->name('lahan.reject');
    Route::delete('lahan/{lahan}', [AdminLahanManagementController::class, 'destroy'])->name('lahan.destroy');

    // Manajemen Rating oleh Admin
    Route::get('ratings', [AdminRatingManagementController::class, 'index'])->name('ratings.index');
    Route::delete('ratings/{rating}', [AdminRatingManagementController::class, 'destroy'])->name('ratings.destroy');

    // Manajemen Pesan Masuk oleh Admin
    Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');
    // Route::patch('messages/{message}/toggle-read', [AdminMessageController::class, 'toggleRead'])->name('messages.toggleRead');

    // Manajemen User oleh Admin
    Route::resource('users', AdminUserManagementController::class);
});
