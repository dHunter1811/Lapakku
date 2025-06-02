<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LahanManagementController as AdminLahanManagementController;
use App\Http\Controllers\Admin\RatingManagementController as AdminRatingManagementController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\UserManagementController as AdminUserManagementController;

// Halaman Utama
Route::get('/', [PageController::class, 'home'])->name('home');

// Rute Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    // Route untuk Lupa Password bisa ditambahkan di sini
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Rute Lahan (Resourceful, kecuali index & show yang publik)
    // User yang login bisa membuat, menyimpan, mengedit, update, destroy lahan miliknya
    Route::resource('lahan', LahanController::class)->except(['index', 'show']);

    // Rute untuk memberi rating (membutuhkan user login)
    Route::post('lahan/{lahan}/ratings', [RatingController::class, 'store'])->name('lahan.ratings.store');

    // (Opsional) Rute untuk user dashboard, profil, dll.
    // Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});

// Rute Lahan yang publik (index & show)
Route::get('lahan', [LahanController::class, 'index'])->name('lahan.index');
Route::get('lahan/{lahan}', [LahanController::class, 'show'])->name('lahan.show');


// Rute Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Lahan oleh Admin
    Route::get('lahan', [AdminLahanManagementController::class, 'index'])->name('lahan.index');
    Route::get('lahan/{lahan}/edit', [AdminLahanManagementController::class, 'edit'])->name('lahan.edit');
    Route::put('lahan/{lahan}', [AdminLahanManagementController::class, 'update'])->name('lahan.update'); // Bisa juga PATCH
    Route::patch('lahan/{lahan}/approve', [AdminLahanManagementController::class, 'approve'])->name('lahan.approve');
    Route::patch('lahan/{lahan}/reject', [AdminLahanManagementController::class, 'reject'])->name('lahan.reject');
    Route::delete('lahan/{lahan}', [AdminLahanManagementController::class, 'destroy'])->name('lahan.destroy');

    // Manajemen Rating oleh Admin
    Route::get('ratings', [AdminRatingManagementController::class, 'index'])->name('ratings.index');
    Route::delete('ratings/{rating}', [AdminRatingManagementController::class, 'destroy'])->name('ratings.destroy');

    // Manajemen Pesan Masuk oleh Admin (Opsional)
    Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');
    // Route::patch('messages/{message}/toggle-read', [AdminMessageController::class, 'toggleRead'])->name('messages.toggleRead');

    // Manajemen User oleh Admin (Opsional)
    Route::resource('users', AdminUserManagementController::class); // Ini akan membuat route CRUD standar
});

// (Opsional) Rute untuk Contact Form jika ada halaman kontak terpisah
// Route::get('/kontak', [PageController::class, 'showContactForm'])->name('contact.form');
// Route::post('/kontak', [PageController::class, 'sendContactMessage'])->name('contact.send');