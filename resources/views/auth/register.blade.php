@extends('layouts.app')

@section('title', 'Register - Lapakku')

@section('content')
<div class="register-wrapper">
    <div class="register-container">
        {{-- Kolom Kiri: Form Registrasi --}}
        <div class="register-form-panel">
            <h2 class="form-title">Buat Akun Baru</h2>
            <p class="form-subtitle">Bergabunglah dengan Lapakku dan mulai temukan peluang usaha Anda.</p>

            @if ($errors->any())
                <div class="alert alert-danger validation-summary">
                    <strong class="font-semibold block mb-1">Oops! Periksa kembali input Anda.</strong>
                    <ul class="list-disc pl-5 m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="register-form">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                            </svg>
                        </span>
                        <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="Masukkan nama lengkap Anda">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.756Zm6.43-.586L16 11.801V4.697l-5.803 3.558L13.19 8.244Z"/>
                            </svg>
                        </span>
                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="contoh@email.com">
                    </div>
                </div>

                {{-- Password Fields in a Row --}}
                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group password-group">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                </svg>
                            </span>
                            <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                            <button type="button" class="password-toggle-btn" data-target="password" title="Show/Hide Password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Verifikasi Password</label>
                        <div class="input-group password-group">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                </svg>
                            </span>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password" placeholder="Ulangi password">
                            <button type="button" class="password-toggle-btn" data-target="password_confirmation" title="Show/Hide Password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Profile Photo Upload with Preview --}}
                <div class="form-group profile-photo-group">
                    <div class="photo-input-container">
                        <label for="profile_photo" class="form-label">Foto Profil (Opsional)</label>
                        <input id="profile_photo" type="file" name="profile_photo" class="form-control file-input-hidden" accept="image/png, image/jpeg, image/jpg">
                        <div class="custom-file-input">
                            <span id="fileName">Pilih file...</span>
                            <button type="button" class="browse-button">Browse</button>
                        </div>
                        <small class="form-text text-muted">Format: JPG, PNG. Maks: 2MB.</small>
                    </div>
                    <div class="photo-preview-container">
                        <img id="photoPreview" src="{{ asset('images/default-avatar.png') }}" alt="Preview Foto Profil">
                        <label for="profile_photo" class="photo-edit-icon" title="Ubah Foto Profil">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.94 10.518 1.459 14.002 14.002 1.459zm-1.25 1.109L2.83 12.016 1.192 14.608 14.608 1.192l-2.016 1.638z"/>
                            </svg>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="no_telepon" class="form-label">No. Telepon (Opsional)</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702A18.634 18.634 0 0 1 0 7.0A18.634 18.634 0 0 1 10.392.102C9.081-.223 7.76.068 6.772.58l-1.033 1.034z"/>
                            </svg>
                        </span>
                        <input id="no_telepon" type="tel" name="no_telepon" class="form-control" value="{{ old('no_telepon') }}" placeholder="08123456xxxx">
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat" class="form-label">Alamat (Opsional)</label>
                    <div class="input-group">
                        <span class="input-icon align-top mt-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M11.534 14.806a.5.5 0 0 1-.018-.016L8 11.012 4.518 14.79a.5.5 0 0 1-.774-.643L7.3 10.3l-6.8-6.9a.5.5 0 0 1 .773-.637L8 9.098l6.09-6.098a.5.5 0 0 1 .774.637L8.7 10.3l3.483 4.493a.5.5 0 0 1-.018.016z"/>
                            </svg>
                        </span>
                        <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat Anda">{{ old('alamat') }}</textarea>
                    </div>
                </div>

                <div class="form-group mt-6">
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>

                <div class="form-divider">
                    <span>atau</span>
                </div>

                <div class="form-group">
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-block">Sudah Punya Akun? Login</a>
                </div>
            </form>
        </div>

        {{-- Kolom Kanan: Branding & Gambar (Posisi dibalik dari Login) --}}
        <div class="register-branding-panel">
            <div class="branding-content">
                <a href="{{ route('home') }}" class="logo-link-register">
                    <img src="{{ asset('images/logo-lapakku.png') }}" onerror="this.onerror=null;this.src='https://placehold.co/60x60/transparent/FFFFFF?text=Logo';" alt="Lapakku Logo" class="logo-image-register">
                    <span>Lapakku</span>
                </a>
                <h1 class="branding-title">Satu Langkah Lagi Menuju Kesuksesan Usaha Anda.</h1>
                <p class="branding-subtitle">Daftar sekarang untuk mendapatkan akses ke ratusan lokasi usaha strategis dan kelola properti Anda dengan mudah.</p>
            </div>
            <div class="illustration-overlay">
                {{-- Ilustrasi atau icon tambahan bisa ditambahkan di sini --}}
                <svg class="w-24 h-24 text-white opacity-80" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.47-7-7.43 0-2.3.94-4.38 2.45-5.92L12 12l-1 7.93zM12 4.07c3.95.49 7 3.47 7 7.43 0 2.3-.94 4.38-2.45 5.92L12 12l1-7.93z"/>
                </svg>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Global Variables (consistent with home.blade.php & login.blade.php) */
    :root {
        --primary-color: #00695C;
        --primary-light: #4DB6AC;
        --primary-dark: #004D40;
        --secondary-color: #FF8F00;
        --secondary-light: #FFC107;
        --dark-color: #263238;
        --light-color: #F5F5F5; /* Digunakan untuk background input */
        --gray-color: #757575;
        --light-gray: #E0E0E0; /* Digunakan untuk border input */
        --white: #FFFFFF;
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 8px 16px rgba(0, 0, 0, 0.12);
        --radius: 12px;
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

    .register-wrapper {
        width: 100%;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: linear-gradient(to top left, var(--primary-dark), var(--primary-light));
    }

    .register-container {
        display: grid;
        grid-template-columns: 1fr; /* Default: satu kolom */
        max-width: 1000px; /* Lebih lebar untuk register karena banyak form */
        width: 100%;
        background-color: var(--white);
        border-radius: var(--radius);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        min-height: 600px; /* Tinggi minimum yang disesuaikan */
    }

    @media (min-width: 992px) {
        .register-container {
            grid-template-columns: 1.1fr 1fr; /* Kolom form sedikit lebih besar dari branding */
        }
    }

    /* Panel Kanan (Branding) */
    .register-branding-panel {
        background: url('https://images.unsplash.com/photo-1556742044-3c52d6e88c62?q=80&w=1770&auto=format&fit=crop') center center/cover no-repeat;
        color: var(--white);
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        text-align: center; /* Konten branding di tengah */
    }

    .register-branding-panel::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0, 105, 92, 0.7), rgba(0, 77, 64, 0.9)); /* Gradasi warna tema yang lebih gelap */
    }

    .illustration-overlay {
        position: absolute;
        bottom: 20px; /* Pindah ke bawah */
        left: 50%;
        transform: translateX(-50%);
        z-index: 1;
        opacity: 0.2;
    }

    .branding-content {
        position: relative;
        z-index: 2;
    }

    .logo-link-register {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        color: var(--white);
        margin-bottom: 25px;
        transition: var(--transition);
    }

    .logo-link-register:hover {
        opacity: 0.8;
    }

    .logo-image-register {
        height: 50px;
        margin-right: 15px;
        border-radius: 8px;
    }

    .logo-link-register span {
        font-size: 2.2em;
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    .branding-title {
        font-size: 2.3em;
        line-height: 1.2;
        margin-bottom: 15px;
        font-weight: 800;
    }

    .branding-subtitle {
        font-size: 1.1em;
        opacity: 0.9;
        line-height: 1.6;
    }

    /* Panel Kiri (Form) */
    .register-form-panel {
        padding: 40px 50px; /* Padding lebih besar */
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-title {
        font-size: 2em;
        color: var(--dark-color);
        font-weight: 700;
        margin-bottom: 10px;
    }

    .form-subtitle {
        color: var(--gray-color);
        margin-bottom: 30px;
        font-size: 1.1em;
    }

    .register-form .form-group {
        margin-bottom: 1.5rem;
    }

    .register-form .form-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem; /* Gap lebih besar */
    }

    @media (min-width: 768px) {
        .register-form .form-row {
            grid-template-columns: 1fr 1fr;
        }
    }

    .register-form .form-label {
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
        pointer-events: none; /* Pastikan ikon tidak mengganggu klik input */
    }
    /* Untuk textarea, posisikan ikon di atas */
    .input-group textarea + .input-icon {
        top: 15px;
        transform: translateY(0);
    }

    .input-group .input-icon svg {
        width: 100%;
        height: 100%;
    }

    .register-form .form-control {
        width: 100%;
        padding: 14px 15px 14px 50px; /* Padding kiri lebih besar untuk ikon */
        border: 1px solid var(--light-gray);
        border-radius: 8px;
        font-size: 1em;
        transition: var(--transition);
        background-color: var(--light-color);
    }

    .register-form .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 105, 92, 0.2);
        background-color: var(--white);
    }

    /* Khusus untuk textarea */
    .register-form textarea.form-control {
        padding: 14px 15px 14px 50px; /* Konsisten dengan input lainnya */
        min-height: 100px; /* Tinggi minimum untuk textarea */
        resize: vertical; /* Hanya izinkan resize vertikal */
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

    /* Profile Photo Upload */
    .profile-photo-group {
        display: flex;
        align-items: center;
        gap: 25px; /* Jarak antar elemen */
        margin-bottom: 1.5rem;
        flex-wrap: wrap; /* Izinkan wrapping pada layar kecil */
    }

    .photo-input-container {
        flex-grow: 1;
        min-width: 200px; /* Agar input file tidak terlalu kecil */
    }

    /* Sembunyikan input file bawaan */
    .file-input-hidden {
        display: none;
    }

    .custom-file-input {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid var(--light-gray);
        border-radius: 8px;
        padding: 10px 15px;
        cursor: pointer;
        background-color: var(--light-color);
        transition: var(--transition);
    }

    .custom-file-input:hover {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 105, 92, 0.1);
    }

    .custom-file-input #fileName {
        color: var(--gray-color);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex-grow: 1;
        margin-right: 10px;
        font-size: 0.95em;
    }

    .custom-file-input .browse-button {
        background-color: var(--primary-color);
        color: var(--white);
        padding: 8px 15px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        font-weight: 500;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .custom-file-input .browse-button:hover {
        background-color: var(--primary-dark);
    }

    .form-text {
        color: var(--gray-color);
        font-size: 0.85em;
        margin-top: 5px;
        display: block;
    }

    .photo-preview-container {
        position: relative;
        cursor: pointer;
        flex-shrink: 0;
        width: 90px; /* Ukuran preview lebih besar */
        height: 90px;
    }

    .photo-preview-container img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary-light); /* Border dengan warna tema */
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
    }

    .photo-preview-container:hover img {
        border-color: var(--primary-color);
        transform: scale(1.02);
    }

    .photo-preview-container .photo-edit-icon {
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: var(--primary-color);
        color: var(--white);
        border-radius: 50%;
        width: 30px; /* Ukuran ikon edit lebih besar */
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9em;
        border: 3px solid var(--white);
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .photo-preview-container .photo-edit-icon:hover {
        background-color: var(--primary-dark);
        transform: scale(1.1);
    }
    .photo-edit-icon svg {
        width: 16px;
        height: 16px;
    }


    /* Buttons (consistent with login.blade.php) */
    .btn-block {
        width: 100%;
        padding: 14px;
        font-size: 1.05em;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-radius: 50px;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: block;
        text-align: center;
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
        margin: 25px 0;
        font-size: 0.95em;
    }

    .form-divider::before,
    .form-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid var(--light-gray);
    }

    .form-divider:not(:empty)::before {
        margin-right: .75em;
    }

    .form-divider:not(:empty)::after {
        margin-left: .75em;
    }

    .validation-summary {
        background-color: #ffebee;
        color: #d32f2f;
        border: 1px solid #ef9a9a;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 25px;
        font-size: 0.9em;
        line-height: 1.5;
        box-shadow: 0 2px 5px rgba(211, 47, 47, 0.1);
    }
    .validation-summary ul {
        list-style-type: disc; /* Pastikan bullet ada */
        margin-top: 8px;
    }

    /* Responsif */
    @media (max-width: 991px) {
        .register-branding-panel {
            display: none; /* Sembunyikan panel branding di tablet dan mobile */
        }
        .register-form-panel {
            padding: 30px;
        }
        .form-title {
            font-size: 1.6em;
        }
        .form-subtitle {
            font-size: 1em;
            margin-bottom: 20px;
        }
        .register-form .form-group {
            margin-bottom: 1.2rem;
        }
        .register-form .form-control {
            padding: 12px 15px 12px 45px;
        }
        .password-group .form-control {
            padding-right: 45px;
        }
        .profile-photo-group {
            flex-direction: column; /* Stack input dan preview di mobile */
            align-items: flex-start;
            gap: 15px;
        }
        .photo-input-container {
            width: 100%; /* Ambil lebar penuh */
            min-width: unset;
        }
        .photo-preview-container {
            align-self: center; /* Pusatkan preview saat stack */
        }
    }

    @media (max-width: 480px) {
        .register-wrapper {
            padding: 10px;
        }
        .register-container {
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .register-form-panel {
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
        .register-form .form-row {
            gap: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Password Toggle
    const passwordToggles = document.querySelectorAll('.password-toggle-btn');
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const targetInput = document.getElementById(this.dataset.target);
            if (targetInput) {
                const type = targetInput.getAttribute('type') === 'password' ? 'text' : 'password';
                targetInput.setAttribute('type', type);

                // Ganti ikon SVG
                const iconPath = type === 'password'
                    ? '<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>'
                    : '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5S0 8 0 8a11.77 11.77 0 0 1 1.669-2.046l.704.705A10.706 10.706 0 0 0 1 8c.796 2.022 3.078 4.385 6.29 5.568l.22.235.235.22A13.824 13.824 0 0 0 8 14.5c.677 0 1.341-.122 1.98-.363l.298-.112z"/><path d="M8 6a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm0 3a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>';
                this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">${iconPath}</svg>`;
            }
        });
    });

    // Profile Photo Preview and Custom File Input
    const photoInput = document.getElementById('profile_photo');
    const photoPreview = document.getElementById('photoPreview');
    const photoPreviewContainer = document.querySelector('.photo-preview-container');
    const fileNameSpan = document.getElementById('fileName');
    const browseButton = document.querySelector('.custom-file-input .browse-button');

    if (photoInput && photoPreview) {
        // Trigger file input when custom browse button or preview image is clicked
        if (photoPreviewContainer) {
            photoPreviewContainer.addEventListener('click', () => photoInput.click());
        }
        if (browseButton) {
            browseButton.addEventListener('click', () => photoInput.click());
        }
        if (fileNameSpan && fileNameSpan.parentNode) {
            fileNameSpan.parentNode.addEventListener('click', (e) => {
                // Only trigger if click is on the custom-file-input div itself, not its children
                if (e.target === fileNameSpan.parentNode) {
                    photoInput.click();
                }
            });
        }


        photoInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                // Update file name display
                if (fileNameSpan) {
                    fileNameSpan.textContent = file.name;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(file);
            } else {
                // Reset to default if no file selected
                if (fileNameSpan) {
                    fileNameSpan.textContent = 'Pilih file...';
                }
                photoPreview.setAttribute('src', '{{ asset('images/default-avatar.png') }}'); // Ensure default avatar exists
            }
        });
    }
});
</script>
@endpush
