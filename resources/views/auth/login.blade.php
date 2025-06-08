@extends('layouts.app')

@section('title', 'Login - Lapakku')

@section('content')
<div class="login-wrapper">
    <div class="login-container">
        {{-- Kolom Kiri: Branding & Gambar --}}
        <div class="login-branding-panel">
            <div class="branding-content">
                <a href="{{ route('home') }}" class="logo-link-login">
                    {{-- Ganti dengan logo SVG atau PNG berkualitas tinggi yang transparan --}}
                    <img src="{{ asset('images/logo-lapakku.png') }}" onerror="this.onerror=null;this.src='https://placehold.co/60x60/transparent/FFFFFF?text=Logo';" alt="Lapakku Logo" class="logo-image-login">
                    <span>Lapakku</span>
                </a>
                <h1 class="branding-title">Temukan Peluang Usaha Anda.</h1>
                <p class="branding-subtitle">Masuk untuk mengelola lahan, melihat pengajuan sewa, dan memulai perjalanan bisnis Anda.</p>
            </div>
            <div class="illustration-overlay">
                {{-- Ilustrasi atau icon tambahan bisa ditambahkan di sini --}}
                <svg class="w-24 h-24 text-white opacity-80" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.47-7-7.43 0-2.3.94-4.38 2.45-5.92L12 12l-1 7.93zM12 4.07c3.95.49 7 3.47 7 7.43 0 2.3-.94 4.38-2.45 5.92L12 12l1-7.93z"/>
                </svg>
            </div>
        </div>

        {{-- Kolom Kanan: Form Login --}}
        <div class="login-form-panel">
            <h2 class="form-title">Selamat Datang Kembali!</h2>
            <p class="form-subtitle">Silakan masuk ke akun Anda.</p>

            @if ($errors->any())
            <div class="alert alert-danger validation-summary">
                <strong class="font-semibold block mb-1">Gagal Login</strong>
                <span>{{ $errors->first('email') ?: $errors->first('password') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.756Zm6.43-.586L16 11.801V4.697l-5.803 3.558L13.19 8.244Z"/>
                            </svg>
                        </span>
                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="contoh@email.com">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group password-group">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                            </svg>
                        </span>
                        <input id="password" type="password" name="password" class="form-control" required placeholder="Masukkan password Anda">
                        <button type="button" id="togglePassword" class="password-toggle-btn" title="Show/Hide Password">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-group-inline">
                    <div class="remember-me">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Ingat Saya
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="forgot-password-link" href="{{ route('password.request') }}">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <div class="form-group mt-6">
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
    /* Global Variables (consistent with home.blade.php) */
    :root {
        --primary-color: #00695C;
        --primary-light: #4DB6AC;
        --primary-dark: #004D40;
        --secondary-color: #FF8F00;
        --secondary-light: #FFC107;
        --dark-color: #263238;
        --light-color: #F5F5F5;
        --gray-color: #757575;
        --light-gray: #E0E0E0;
        --white: #FFFFFF;
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 8px 16px rgba(0, 0, 0, 0.12);
        --radius: 12px; /* Lebih besar untuk login container */
        --transition: all 0.3s ease;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Inter', sans-serif;
        line-height: 1.6;
        color: var(--dark-color);
        background-color: var(--light-color);
    }

    /* Override main layout container for full width login */
    .login-wrapper {
        width: 100%;
        min-height: 100vh; /* Menggunakan 100vh untuk mengisi seluruh tinggi viewport */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: linear-gradient(to bottom right, var(--primary-dark), var(--primary-light));
        /* Gradasi latar belakang yang lebih dinamis */
    }

    .login-container {
        display: grid;
        grid-template-columns: 1fr 1fr; /* Dua kolom sama lebar */
        max-width: 960px; /* Lebar maksimum yang sedikit lebih besar */
        width: 100%;
        background-color: var(--white);
        border-radius: var(--radius);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25); /* Bayangan lebih dalam */
        overflow: hidden;
        min-height: 550px; /* Tinggi minimum untuk estetika */
    }

    /* Panel Kiri (Branding) */
    .login-branding-panel {
        background: url('https://images.unsplash.com/photo-1600880292203-942bb68b2432?q=80&w=1887&auto=format&fit=crop') center center/cover no-repeat;
        color: var(--white);
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end; /* Konten ke bawah */
        position: relative;
    }

    .login-branding-panel::before {
        /* Overlay gelap dengan gradasi */
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3));
    }

    .illustration-overlay {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 1;
        opacity: 0.2; /* Lebih samar */
    }

    .branding-content {
        position: relative;
        z-index: 2; /* Pastikan di atas overlay dan ilustrasi */
    }

    .logo-link-login {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--white);
        margin-bottom: 25px; /* Jarak lebih besar */
        transition: var(--transition);
    }

    .logo-link-login:hover {
        opacity: 0.8;
    }

    .logo-image-login {
        height: 50px; /* Ukuran logo lebih besar */
        margin-right: 15px;
        border-radius: 8px; /* Sudut sedikit membulat untuk logo */
    }

    .logo-link-login span {
        font-size: 2.2em; /* Ukuran teks logo lebih besar */
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    .branding-title {
        font-size: 2.5em; /* Ukuran judul lebih besar */
        line-height: 1.2;
        margin-bottom: 15px;
        font-weight: 800;
    }

    .branding-subtitle {
        font-size: 1.1em; /* Ukuran subtitle lebih besar */
        opacity: 0.9;
        line-height: 1.6;
    }

    /* Panel Kanan (Form) */
    .login-form-panel {
        padding: 50px; /* Padding lebih besar */
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-title {
        font-size: 2em; /* Ukuran judul form lebih besar */
        color: var(--dark-color);
        font-weight: 700;
        margin-bottom: 10px;
    }

    .form-subtitle {
        color: var(--gray-color);
        margin-bottom: 30px; /* Jarak lebih besar */
        font-size: 1.1em;
    }

    .login-form .form-group {
        margin-bottom: 1.5rem; /* Jarak antar group form */
    }

    .login-form .form-label {
        display: block;
        margin-bottom: 0.6rem;
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.95em;
    }

    .input-group {
        position: relative;
    }

    .input-group .input-icon {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: var(--gray-color);
        width: 20px;
        height: 20px;
    }

    .input-group .input-icon svg {
        width: 100%;
        height: 100%;
    }

    .login-form .form-control {
        width: 100%;
        padding: 14px 15px 14px 50px; /* Padding kiri lebih besar untuk ikon */
        border: 1px solid var(--light-gray);
        border-radius: 8px; /* Sudut membulat */
        font-size: 1em;
        transition: var(--transition);
        background-color: var(--light-color); /* Latar belakang input */
    }

    .login-form .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 105, 92, 0.2);
        background-color: var(--white);
    }

    .password-group .form-control {
        padding-right: 50px; /* Padding kanan untuk tombol toggle */
    }

    .password-toggle-btn {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--gray-color);
        font-size: 1.2em;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }

    .password-toggle-btn:hover {
        color: var(--primary-color);
        background-color: rgba(0, 105, 92, 0.1);
    }
    
    .password-toggle-btn svg {
        width: 18px;
        height: 18px;
    }

    .form-group-inline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        font-size: 0.95em;
        color: var(--gray-color);
    }

    .remember-me {
        display: flex;
        align-items: center;
    }

    .remember-me input[type="checkbox"] {
        margin-right: 8px;
        width: 18px;
        height: 18px;
        accent-color: var(--primary-color); /* Warna checkbox */
    }

    .remember-me label {
        margin: 0;
        color: var(--dark-color);
    }

    .forgot-password-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .forgot-password-link:hover {
        text-decoration: underline;
        color: var(--primary-dark);
    }

    /* Buttons (re-using primary/secondary from home.blade.php concept) */
    .btn-block {
        width: 100%;
        padding: 14px; /* Padding lebih besar */
        font-size: 1.05em; /* Ukuran font lebih besar */
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-radius: 50px; /* Lebih bulat */
        transition: var(--transition);
        border: none;
        cursor: pointer;
        text-decoration: none; /* Untuk tombol link */
        display: block; /* Untuk tombol link */
        text-align: center; /* Untuk tombol link */
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: var(--white);
        box-shadow: 0 4px 10px rgba(0, 105, 92, 0.3);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 105, 92, 0.4);
    }

    .btn-secondary {
        background-color: var(--white);
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .btn-secondary:hover {
        background-color: rgba(0, 105, 92, 0.1);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-divider {
        display: flex;
        align-items: center;
        text-align: center;
        color: var(--gray-color);
        margin: 25px 0; /* Jarak lebih besar */
        font-size: 0.95em;
    }

    .form-divider::before,
    .form-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid var(--light-gray);
    }

    .form-divider:not(:empty)::before {
        margin-right: .75em; /* Jarak lebih besar */
    }

    .form-divider:not(:empty)::after {
        margin-left: .75em; /* Jarak lebih besar */
    }

    .validation-summary {
        background-color: #ffebee; /* Warna merah muda lembut */
        color: #d32f2f; /* Warna teks merah gelap */
        border: 1px solid #ef9a9a; /* Border merah muda */
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 25px;
        font-size: 0.9em;
        line-height: 1.5;
        box-shadow: 0 2px 5px rgba(211, 47, 47, 0.1);
    }

    /* Responsif */
    @media (max-width: 800px) {
        .login-container {
            grid-template-columns: 1fr; /* Satu kolom di layar kecil */
            max-width: 450px; /* Batasi lebar di mobile */
            min-height: auto; /* Biarkan tinggi menyesuaikan konten */
        }

        .login-branding-panel {
            display: none; /* Sembunyikan panel gambar di mobile agar form lebih fokus */
        }

        .login-form-panel {
            padding: 30px; /* Padding lebih kecil di mobile */
        }

        .form-title {
            font-size: 1.6em;
        }

        .form-subtitle {
            font-size: 1em;
            margin-bottom: 20px;
        }

        .login-form .form-group {
            margin-bottom: 1.2rem;
        }

        .login-form .form-control {
            padding: 12px 15px 12px 45px;
        }

        .password-group .form-control {
            padding-right: 45px;
        }
    }

    @media (max-width: 480px) {
        .login-wrapper {
            padding: 10px;
        }

        .login-container {
            border-radius: 8px; /* Lebih kecil di mobile */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .login-form-panel {
            padding: 25px;
        }

        .btn-block {
            padding: 12px;
            font-size: 0.95em;
        }

        .validation-summary {
            padding: 12px;
            margin-bottom: 20px;
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
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Ganti ikon SVG
                const iconPath = type === 'password'
                    ? '<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>'
                    : '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5S0 8 0 8a11.77 11.77 0 0 1 1.669-2.046l.704.705A10.706 10.706 0 0 0 1 8c.796 2.022 3.078 4.385 6.29 5.568l.22.235.235.22A13.824 13.824 0 0 0 8 14.5c.677 0 1.341-.122 1.98-.363l.298-.112z"/><path d="M8 6a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm0 3a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>';
                this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">${iconPath}</svg>`;
            });
        }
    });
</script>
@endpush
