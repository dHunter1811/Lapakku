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
                    <strong style="display:block; margin-bottom:5px;">Oops! Periksa kembali input Anda.</strong>
                    <ul style="margin: 0; padding-left: 20px;">
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
                    <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="Masukkan nama lengkap Anda">
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="contoh@email.com">
                </div>

                {{-- Password Fields in a Row --}}
                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-group">
                            <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                            <button type="button" class="password-toggle-btn" data-target="password">👁️</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Verifikasi Password</label>
                        <div class="password-group">
                             <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password" placeholder="Ulangi password">
                             <button type="button" class="password-toggle-btn" data-target="password_confirmation">👁️</button>
                        </div>
                    </div>
                </div>

                {{-- Profile Photo Upload with Preview --}}
                 <div class="form-group profile-photo-group">
                    <div class="photo-input-container">
                        <label for="profile_photo" class="form-label">Foto Profil (Opsional)</label>
                        <input id="profile_photo" type="file" name="profile_photo" class="form-control" accept="image/png, image/jpeg, image/jpg">
                        <small class="form-text text-muted">Format: JPG, PNG. Maks: 2MB.</small>
                    </div>
                    <div class="photo-preview-container">
                        <img id="photoPreview" src="{{ asset('images/default-avatar.png') }}" alt="Preview Foto Profil">
                        <label for="profile_photo" class="photo-edit-icon">✏️</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="no_telepon" class="form-label">No. Telepon (Opsional)</label>
                    <input id="no_telepon" type="tel" name="no_telepon" class="form-control" value="{{ old('no_telepon') }}" placeholder="08123456xxxx">
                </div>

                <div class="form-group">
                    <label for="alamat" class="form-label">Alamat (Opsional)</label>
                    <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat Anda">{{ old('alamat') }}</textarea>
                </div>

                <div class="form-group" style="margin-top: 25px;">
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

        {{-- Kolom Kanan: Branding & Gambar --}}
        <div class="register-branding-panel">
            <div class="branding-content">
                <a href="{{ route('home') }}" class="logo-link-register">
                    <img src="{{ asset('images/Jukung Lapakku.png') }}" alt="Lapakku Logo" class="logo-image-register">
                    <span>Lapakku</span>
                </a>
                <h1 class="branding-title">Satu Langkah Lagi Menuju Kesuksesan Usaha Anda.</h1>
                <p class="branding-subtitle">Daftar sekarang untuk mendapatkan akses ke ratusan lokasi usaha strategis dan kelola properti Anda dengan mudah.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .register-wrapper {
        width: 100%;
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background-color: #f0f4f8;
    }
    .register-container {
        display: grid;
        grid-template-columns: 1fr; /* Satu kolom untuk mobile */
        max-width: 950px;
        width: 100%;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    @media (min-width: 992px) {
        .register-container {
            grid-template-columns: 1.1fr 1fr; /* Kolom form sedikit lebih besar */
        }
    }

    /* Panel Kanan (Branding) */
    .register-branding-panel {
        color: white;
        padding: 40px;
        display: none; /* Sembunyikan di mobile */
        flex-direction: column;
        justify-content: center;
        position: relative;
    }
    @media (min-width: 992px) {
        .register-branding-panel {
            display: flex;
        }
    }
    .register-branding-panel::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(to top, rgba(0, 89, 79, 0.8), rgba(0, 121, 107, 0.6)); /* Gradasi warna tema */
    }
    .branding-content {
        position: relative; z-index: 1; text-align: center;
    }
    .logo-link-register {
        display: inline-flex; align-items: center; text-decoration: none; color: white; margin-bottom: 25px;
    }
    .logo-image-register {
        height: 50px; margin-right: 12px;
    }
    .logo-link-register span {
        font-size: 2em; font-weight: 700;
    }
    .branding-title {
        font-size: 1.8em; line-height: 1.3; margin-bottom: 15px; font-weight: 600;
    }
    .branding-subtitle {
        font-size: 1em; opacity: 0.95; line-height: 1.6;
    }

    /* Panel Kiri (Form) */
    .register-form-panel {
        padding: 30px 40px;
    }
    .form-title {
        font-size: 1.8em; color: #333; font-weight: 600; margin-bottom: 5px;
    }
    .form-subtitle {
        color: #777; margin-bottom: 25px;
    }
    .register-form .form-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    @media (min-width: 768px) {
        .register-form .form-row {
            grid-template-columns: 1fr 1fr;
        }
    }
    .register-form .form-group {
        margin-bottom: 1.25rem;
    }
    .register-form .form-label {
        display: block; margin-bottom: 0.5rem; font-weight: 500; color: #555; font-size: 0.9em;
    }
    .register-form .form-control {
        width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95em; transition: border-color 0.2s;
    }
    .register-form .form-control:focus {
        outline: none; border-color: #00796B; box-shadow: 0 0 0 2px rgba(0, 121, 107, 0.2);
    }
    .password-group {
        position: relative;
    }
    .password-toggle-btn {
        position: absolute; top: 50%; right: 10px; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #999; font-size: 1.2em;
    }
    .profile-photo-group {
        display: flex; align-items: center; gap: 20px;
    }
    .photo-input-container {
        flex-grow: 1;
    }
    .photo-preview-container {
        position: relative; cursor: pointer;
    }
    .photo-preview-container img {
        width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #e0e0e0;
    }
    .photo-preview-container .photo-edit-icon {
        position: absolute; bottom: 0; right: 0; background-color: #00796B; color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 0.8em; border: 2px solid white;
    }
    .btn-block {
        width: 100%; padding: 12px; font-size: 1em; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .form-divider {
        display: flex; align-items: center; text-align: center; color: #aaa; margin: 20px 0; font-size: 0.9em;
    }
    .form-divider::before, .form-divider::after {
        content: ''; flex: 1; border-bottom: 1px solid #ddd;
    }
    .form-divider:not(:empty)::before { margin-right: .25em; }
    .form-divider:not(:empty)::after { margin-left: .25em; }
    .validation-summary {
        font-size: 0.9em;
    }
    .validation-summary ul {
        margin-top: 8px;
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
                this.textContent = type === 'password' ? '👁️' : '🙈';
            }
        });
    });

    // Profile Photo Preview
    const photoInput = document.getElementById('profile_photo');
    const photoPreview = document.getElementById('photoPreview');
    const photoPreviewContainer = document.querySelector('.photo-preview-container');

    if (photoInput && photoPreview) {
        // Klik pada preview juga akan memicu input file
        if (photoPreviewContainer) {
            photoPreviewContainer.addEventListener('click', () => photoInput.click());
        }

        photoInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush