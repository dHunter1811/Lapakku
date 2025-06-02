@extends('layouts.app')

@section('title', 'Register - Lapakku')

@section('content')
<div class="container register-container">
    <div class="card register-card">
        <div class="card-header">
            <div class="brand-logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48" fill="#00695C">
                    <path d="M12 2L4 7v10l8 5 8-5V7L12 2zm0 2.5L18 9v6l-6 3.5-6-3.5V9l6-4.5zM12 15l4-2.2V9l-4 2.2-4-2.2v3.8l4 2.2z"/>
                </svg>
                <h1 class="brand-name">Lapakku</h1>
            </div>
            <h2 class="register-title">Buat Akun Baru</h2>
            <p class="register-subtitle">Isi form berikut untuk membuat akun baru</p>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="register-form">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <!-- <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                            </svg>
                        </span> -->
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-input" placeholder="Masukkan nama lengkap">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <!-- <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                            </svg>
                        </span> -->
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="Masukkan alamat email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <!-- <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                            </svg>
                        </span> -->
                        <input id="password" type="password" name="password" required class="form-input" placeholder="Buat password (minimal 8 karakter)">
                        <button type="button" class="password-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Verifikasi Password</label>
                    <div class="input-group">
                        <!-- <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                            </svg>
                        </span> -->
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="form-input" placeholder="Ulangi password">
                        <button type="button" class="password-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" class="form-textarea" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="no_telepon" class="form-label">No. Telepon</label>
                    <div class="input-group">
                        <!-- <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                            </svg>
                        </span> -->
                        <input id="no_telepon" type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="form-input" placeholder="Masukkan nomor telepon">
                    </div>
                </div>

                <div class="form-group terms-group">
                    <input type="checkbox" name="terms" id="terms" required class="checkbox">
                    <label for="terms" class="checkbox-label">Saya menyetujui <a href="#" class="terms-link">Syarat dan Ketentuan</a> serta <a href="#" class="terms-link">Kebijakan Privasi</a> Lapakku</label>
                </div>

                <button type="submit" class="register-button">Daftar Sekarang</button>
            </form>

            <div class="divider">
                <span>atau</span>
            </div>

            <div class="social-login">
                <button type="button" class="social-button google-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="social-icon">
                        <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                    </svg>
                    Daftar dengan Google
                </button>
                <button type="button" class="social-button facebook-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="social-icon">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                    </svg>
                    Daftar dengan Facebook
                </button>
            </div>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}" class="login-button">Masuk Sekarang</a>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    :root {
        --primary-color: #00695C;
        --primary-light: #4DB6AC;
        --secondary-color: #FF8F00;
        --error-color: #D32F2F;
        --text-color: #333333;
        --light-gray: #F5F5F5;
        --medium-gray: #E0E0E0;
        --dark-gray: #757575;
        --white: #FFFFFF;
    }

    .register-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
        background-color: var(--light-gray);
    }

    .register-card {
        width: 100%;
        max-width: 500px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: none;
    }

    .card-header {
        background-color: var(--white);
        padding: 30px 30px 20px;
        text-align: center;
        border-bottom: 1px solid var(--medium-gray);
    }

    .brand-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .brand-name {
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-color);
        margin-left: 10px;
    }

    .register-title {
        font-size: 18px;
        color: var(--text-color);
        margin: 0;
        font-weight: 600;
    }

    .register-subtitle {
        font-size: 14px;
        color: var(--dark-gray);
        margin: 5px 0 0;
    }

    .card-body {
        padding: 30px;
        background-color: var(--white);
    }

    .alert-danger {
        background-color: rgba(211, 47, 47, 0.1);
        color: var(--error-color);
        border-radius: 8px;
        padding: 12px 15px;
        margin-bottom: 20px;
        border: 1px solid rgba(211, 47, 47, 0.2);
    }

    .error-list {
        margin: 0;
        padding-left: 20px;
        list-style-type: none;
    }

    .error-list li {
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        color: var(--text-color);
        font-weight: 500;
    }

    .input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 12px;
        color: var(--dark-gray);
    }

    .form-input {
        width: 100%;
        padding: 12px 15px 12px 40px;
        border: 1px solid var(--medium-gray);
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(0, 105, 92, 0.2);
    }

    .form-textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--medium-gray);
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        min-height: 100px;
        resize: vertical;
    }

    .form-textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(0, 105, 92, 0.2);
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        color: var(--dark-gray);
        cursor: pointer;
        padding: 0;
    }

    .terms-group {
        display: flex;
        align-items: flex-start;
        margin: 25px 0;
    }

    .checkbox {
        width: 16px;
        height: 16px;
        margin-right: 8px;
        margin-top: 3px;
        accent-color: var(--primary-color);
    }

    .checkbox-label {
        font-size: 14px;
        color: var(--text-color);
        line-height: 1.4;
    }

    .terms-link {
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.2s;
    }

    .terms-link:hover {
        color: var(--primary-light);
        text-decoration: underline;
    }

    .register-button {
        width: 100%;
        padding: 12px;
        background-color: var(--primary-color);
        color: var(--white);
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-bottom: 20px;
    }

    .register-button:hover {
        background-color: #00897B;
    }

    .divider {
        display: flex;
        align-items: center;
        margin: 25px 0;
        color: var(--dark-gray);
        font-size: 14px;
    }

    .divider::before, .divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid var(--medium-gray);
    }

    .divider::before {
        margin-right: 10px;
    }

    .divider::after {
        margin-left: 10px;
    }

    .social-login {
        margin-bottom: 20px;
    }

    .social-button {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        border: 1px solid var(--medium-gray);
        background-color: var(--white);
        color: var(--text-color);
        transition: all 0.3s;
    }

    .social-button:hover {
        background-color: var(--light-gray);
    }

    .social-icon {
        margin-right: 10px;
    }

    .google-button {
        color: #DB4437;
    }

    .facebook-button {
        color: #4267B2;
    }

    .login-link {
        text-align: center;
        font-size: 14px;
        color: var(--text-color);
        margin-top: 20px;
    }

    .login-button {
        color: var(--primary-color);
        font-weight: 500;
        text-decoration: none;
        transition: color 0.2s;
    }

    .login-button:hover {
        color: var(--primary-light);
        text-decoration: underline;
    }

    @media (max-width: 480px) {
        .register-card {
            border-radius: 0;
        }
        
        .card-header, .card-body {
            padding: 25px 20px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password toggle functionality
        const passwordToggles = document.querySelectorAll('.password-toggle');
        
        passwordToggles.forEach(toggle => {
            const inputId = toggle.closest('.input-group').querySelector('input').id;
            const passwordInput = document.getElementById(inputId);
            
            toggle.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icon
                if (type === 'text') {
                    toggle.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                            <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                            <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                        </svg>
                    `;
                } else {
                    toggle.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                        </svg>
                    `;
                }
            });
        });

        // Phone number formatting
        const phoneInput = document.getElementById('no_telepon');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                e.target.value = value;
            });
        }
    });
</script>