@extends('layouts.app')

@section('title', 'Hubungi Kami - Lapakku')

@section('content')
<div class="contact-wrapper">
    <div class="card contact-card">
        <header class="contact-header text-center">
            <h1 class="page-title-contact">Hubungi Kami</h1>
            <p class="lead-paragraph-contact">
                Punya pertanyaan, saran, atau butuh bantuan? Jangan ragu untuk mengirimkan pesan kepada kami melalui formulir di bawah ini.
            </p>
        </header>

        @if (session('success'))
            <div class="alert alert-success validation-summary">
                <strong class="font-semibold block mb-1">Pesan Terkirim!</strong>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger validation-summary">
                <strong class="font-semibold block mb-1">Oops! Ada beberapa masalah dengan input Anda:</strong>
                <ul class="list-disc pl-5 m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kontak.store') }}" method="POST" class="contact-form">
            @csrf
            <div class="form-group">
                <label for="nama" class="form-label">Nama Lengkap Anda</label>
                <div class="input-group">
                    <span class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.685 10.5 10 8 10c-2.5 0-3.516.685-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                        </svg>
                    </span>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', auth()->check() ? auth()->user()->name : '') }}" required placeholder="Masukkan nama lengkap Anda">
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Alamat Email Anda</label>
                <div class="input-group">
                    <span class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.756Zm6.43-.586L16 11.801V4.697l-5.803 3.558L13.19 8.244Z"/>
                        </svg>
                    </span>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" required placeholder="contoh@email.com">
                </div>
            </div>

            <div class="form-group">
                <label for="pesan" class="form-label">Pesan Anda</label>
                <div class="input-group">
                    <span class="input-icon align-top-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                            <path d="M5 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </span>
                    <textarea name="pesan" id="pesan" class="form-control" rows="6" required placeholder="Tulis pesan Anda di sini..."></textarea>
                </div>
            </div>

            <div class="form-group mt-6">
                <button type="submit" class="btn btn-primary btn-block">Kirim Pesan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Global Variables (consistent with other views) */
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

    .contact-wrapper {
        padding-top: 40px;
        padding-bottom: 60px;
        min-height: calc(100vh - 70px); /* Adjust for header/footer if present */
        display: flex;
        justify-content: center;
        align-items: flex-start;
        background: linear-gradient(to bottom right, var(--primary-light), var(--primary-color));
    }

    .contact-card {
        padding: 40px 50px;
        background-color: var(--white);
        border-radius: var(--radius);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2); /* Shadow yang lebih menonjol */
        width: 100%;
        max-width: 700px; /* Batasi lebar agar tidak terlalu lebar di desktop */
        margin: auto;
    }

    .contact-header {
        margin-bottom: 40px;
    }

    .page-title-contact {
        font-size: 2.8em; /* Ukuran lebih besar */
        color: var(--primary-dark);
        font-weight: 800;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .lead-paragraph-contact {
        font-size: 1.1em;
        color: var(--gray-color);
        max-width: 600px;
        margin: 0 auto;
    }

    /* Form Styling (consistent with login/register) */
    .contact-form .form-group {
        margin-bottom: 1.5rem;
    }

    .contact-form .form-label {
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
        pointer-events: none;
    }
    .input-group .align-top-icon { /* Untuk textarea */
        top: 15px;
        transform: translateY(0);
    }

    .input-group .input-icon svg {
        width: 100%;
        height: 100%;
    }

    .contact-form .form-control {
        width: 100%;
        padding: 14px 15px 14px 50px; /* Padding kiri untuk ikon */
        border: 1px solid var(--light-gray);
        border-radius: 8px;
        font-size: 1em;
        transition: var(--transition);
        background-color: var(--light-color);
    }

    .contact-form .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 105, 92, 0.2);
        background-color: var(--white);
    }

    /* Textarea specific styling */
    .contact-form textarea.form-control {
        padding: 14px 15px 14px 50px; /* Consistent padding */
        min-height: 140px; /* Tinggi minimum textarea */
        resize: vertical; /* Hanya izinkan resize vertikal */
    }

    /* Alert/Validation Summary (consistent with login/register) */
    .validation-summary {
        background-color: #ffebee; /* Light red for errors */
        color: #d32f2f; /* Darker red text for errors */
        border: 1px solid #ef9a9a; /* Red border for errors */
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 25px;
        font-size: 0.9em;
        line-height: 1.5;
        box-shadow: 0 2px 5px rgba(211, 47, 47, 0.1);
    }
    .validation-summary.alert-success {
        background-color: #e8f5e9; /* Light green for success */
        color: #2e7d32; /* Darker green text for success */
        border: 1px solid #a5d6a7; /* Green border for success */
        box-shadow: 0 2px 5px rgba(46, 125, 50, 0.1);
    }
    .validation-summary ul {
        list-style-type: disc;
        margin-top: 8px;
    }
    .validation-summary strong {
        font-weight: 600;
    }

    /* Button Styling (consistent with previous designs) */
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

    /* Responsiveness */
    @media (max-width: 768px) {
        .contact-card {
            padding: 30px;
        }
        .page-title-contact {
            font-size: 2.2em;
        }
        .lead-paragraph-contact {
            font-size: 1em;
        }
        .contact-form .form-control {
            padding: 12px 15px 12px 45px;
        }
        .contact-form textarea.form-control {
            min-height: 120px;
        }
        .btn-block {
            padding: 12px;
            font-size: 1em;
        }
        .validation-summary {
            padding: 12px;
            margin-bottom: 20px;
        }
    }

    @media (max-width: 480px) {
        .contact-wrapper {
            padding: 20px 10px;
        }
        .contact-card {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .page-title-contact {
            font-size: 1.8em;
        }
    }
</style>
@endpush
