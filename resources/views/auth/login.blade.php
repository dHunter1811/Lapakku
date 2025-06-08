@extends('layouts.app')

@section('title', 'Login - Lapakku')

@section('content')
<div class="login-wrapper">
    <div class="login-container">
        {{-- Kolom Kiri: Branding & Gambar --}}
        <div class="login-branding-panel">
            <div class="branding-content">
                <a href="{{ route('home') }}" class="logo-link-login">
                    <img src="{{ asset('images/Jukung Lapakku.png') }}" alt="Lapakku Logo" class="logo-image-login">
                    <span>Lapakku</span>
                </a>
                <h1 class="branding-title">Temukan Peluang Usaha Anda.</h1>
                <p class="branding-subtitle">Masuk untuk mengelola lahan, melihat pengajuan sewa, dan memulai perjalanan bisnis Anda.</p>
            </div>
        </div>

        {{-- Kolom Kanan: Form Login --}}
        <div class="login-form-panel">
            <h2 class="form-title">Selamat Datang Kembali!</h2>
            <p class="form-subtitle">Silakan masuk ke akun Anda.</p>

            @if ($errors->any())
            <div class="alert alert-danger validation-summary">
                <strong style="display:block; margin-bottom:5px;">Gagal Login</strong>
                <span>{{ $errors->first('email') ?: $errors->first('password') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-icon">📧</span>
                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="contoh@email.com">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group password-group">
                        <span class="input-icon">🔒</span>
                        <input id="password" type="password" name="password" class="form-control" required placeholder="Masukkan password Anda">
                        <button type="button" id="togglePassword" class="password-toggle-btn">👁️</button>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>

                <div class="form-divider">
                    <span>atau</span>
                </div>

                <div class="form-group">
                    <a href="{{ route('register') }}" class="btn btn-secondary btn-block">Belum punya akun? Register</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Menghilangkan container default dari layout untuk halaman ini */
    .login-wrapper {
        width: 100%;
        min-height: calc(100vh - 70px);
        /* Sesuaikan tinggi dengan tinggi header Anda */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: linear-gradient(to right, #00594f, #00796B);
        /* Gradasi latar belakang */
    }

    .login-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        /* Dua kolom sama lebar */
        max-width: 900px;
        width: 100%;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        /* Agar border-radius bekerja */
    }

    /* Panel Kiri (Branding) */
    .login-branding-panel {
        color: white;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        /* Konten ke bawah */
        position: relative;
    }

    .login-branding-panel::before {
        /* Overlay gelap */
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
    }

    .branding-content {
        position: relative;
        z-index: 1;
    }

    .logo-link-login {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: white;
        margin-bottom: 20px;
    }

    .logo-image-login {
        height: 45px;
        margin-right: 12px;
    }

    .logo-link-login span {
        font-size: 1.8em;
        font-weight: 700;
    }

    .branding-title {
        font-size: 2em;
        line-height: 1.2;
        margin-bottom: 10px;
    }

    .branding-subtitle {
        font-size: 1em;
        opacity: 0.9;
        line-height: 1.5;
    }

    /* Panel Kanan (Form) */
    .login-form-panel {
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-title {
        font-size: 1.8em;
        color: #333;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .form-subtitle {
        color: #777;
        margin-bottom: 25px;
    }

    .login-form .form-group {
        margin-bottom: 1.25rem;
    }

    .login-form .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #555;
        font-size: 0.9em;
    }

    .input-group {
        position: relative;
    }

    .input-group .input-icon {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: #aaa;
    }

    .login-form .form-control {
        width: 100%;
        padding: 12px 15px 12px 40px;
        /* Padding kiri untuk ikon */
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 0.95em;
        transition: border-color 0.2s;
    }

    .login-form .form-control:focus {
        outline: none;
        border-color: #00796B;
        box-shadow: 0 0 0 2px rgba(0, 121, 107, 0.2);
    }

    .password-group {
        position: relative;
    }

    .password-toggle-btn {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #999;
        font-size: 1.2em;
    }

    .form-group-inline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        font-size: 0.9em;
    }

    .remember-me {
        display: flex;
        align-items: center;
    }

    .remember-me input[type="checkbox"] {
        margin-right: 5px;
    }

    .remember-me label {
        margin: 0;
        color: #555;
    }

    .forgot-password-link {
        color: #00695C;
        text-decoration: none;
    }

    .forgot-password-link:hover {
        text-decoration: underline;
    }

    .btn-block {
        width: 100%;
        padding: 12px;
        font-size: 1em;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-divider {
        display: flex;
        align-items: center;
        text-align: center;
        color: #aaa;
        margin: 20px 0;
        font-size: 0.9em;
    }

    .form-divider::before,
    .form-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #ddd;
    }

    .form-divider:not(:empty)::before {
        margin-right: .25em;
    }

    .form-divider:not(:empty)::after {
        margin-left: .25em;
    }

    .validation-summary {
        font-size: 0.9em;
    }

    .validation-summary span {
        display: block;
    }


    /* Responsif */
    @media (max-width: 800px) {
        .login-container {
            grid-template-columns: 1fr;
            /* Satu kolom di layar kecil */
        }

        .login-branding-panel {
            display: none;
            /* Sembunyikan panel gambar di mobile agar form lebih fokus */
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                // Ganti tipe input
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Ganti ikon mata
                this.textContent = type === 'password' ? '👁️' : '🙈';
            });
        }
    });
</script>
@endpush