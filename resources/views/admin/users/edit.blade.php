@extends('layouts.admin')

@section('title', 'Edit Pengguna: ' . ($user->name ?? 'User') . ' - Admin Lapakku')
@section('page-title', 'Edit Detail Informasi Pengguna')

@section('content')
<div class="card admin-edit-user-card"> {{-- Tambahkan class spesifik untuk styling --}}
    <div class="card-header">
        {{-- Tombol kembali dihapus dari header --}}
        <h4 style="margin:0; font-size: 1.2em; font-weight: 600;">Formulir Edit Pengguna: "{{ $user->name ?? 'User Tidak Ditemukan' }}"</h4>
    </div>
    <div class="card-body" style="padding-top: 25px;">
        @if(!isset($user))
            <div class="alert alert-danger text-center">Data pengguna tidak ditemukan.</div>
        @else
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom: 20px;">
                    <strong style="display:block; margin-bottom:5px;">Oops! Ada beberapa masalah dengan input Anda:</strong>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h5 class="section-label">Informasi Akun</h5>
                    <div class="form-grid two-columns"> {{-- Grid untuk 2 kolom --}}
                        <div class="form-group">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon" class="form-label">Nomor Telepon</label>
                            <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="Contoh: 08123456xxxx">
                        </div>
                        <div class="form-group">
                            <label for="role" class="form-label">Role Pengguna</label>
                            <select name="role" id="role" class="form-select" required {{ Auth::id() === $user->id ? 'disabled' : '' }}>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User Biasa</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                            @if(Auth::id() === $user->id)
                                <small class="form-text text-muted">Anda tidak dapat mengubah role akun Anda sendiri.</small>
                                <input type="hidden" name="role" value="{{ $user->role }}">
                            @endif
                        </div>
                    </div>
                    <div class="form-group"> {{-- Alamat tetap full width di bawah grid 2 kolom --}}
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap pengguna">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>
                </div>

                <hr class="form-divider">

                <div class="form-section">
                    <h5 class="section-label">Foto Profil</h5>
                    <div class="form-group profile-photo-edit-group">
                        <div class="current-photo-container">
                            <label class="form-label">Foto Saat Ini:</label>
                            <img src="{{ $user->profile_photo_url }}" alt="Foto Profil {{ $user->name }}" class="current-profile-photo-preview">
                        </div>
                        <div class="new-photo-container">
                            <label for="profile_photo" class="form-label">Ganti Foto Profil (Opsional)</label>
                            <input type="file" name="profile_photo" id="profile_photo" class="form-control file-input" accept="image/png, image/jpeg, image/jpg">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti. Format: JPG, PNG. Maks: 2MB.</small>
                        </div>
                    </div>
                </div>

                <hr class="form-divider">

                <div class="form-section">
                    <h5 class="section-label">Ubah Password (Opsional)</h5>
                    <p class="form-text text-muted" style="margin-bottom: 15px;">Kosongkan field password jika Anda tidak ingin mengubahnya.</p>
                    <div class="form-grid two-columns"> {{-- Grid untuk 2 kolom --}}
                        <div class="form-group">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <hr class="form-divider">

                <div class="form-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <span class="icon">⬅️</span> Kembali ke Daftar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <span class="icon">💾</span> Simpan Perubahan
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .admin-edit-user-card .card-header h4 { /* Styling spesifik untuk header card ini */
        color: #1e293b;
    }
    .admin-form .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #4a5568;
        font-size: 0.9em;
    }
    .admin-form .form-control,
    .admin-form .form-select {
        border-radius: 0.375rem;
        border: 1px solid #cbd5e0;
        padding: 0.6rem 0.9rem;
        font-size: 0.95rem;
        width: 100%;
        box-sizing: border-box;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
    .admin-form .form-control:focus,
    .admin-form .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }
    .admin-form .form-control[readonly] {
        background-color: #f3f4f6;
        cursor: not-allowed;
    }
    .admin-form .form-group {
        margin-bottom: 1.25rem; /* Jarak standar antar grup form */
    }
    .admin-form .form-group:last-child {
        margin-bottom: 0; /* Hapus margin bawah untuk grup terakhir di kolom/seksi */
    }


    .form-section {
        margin-bottom: 2.5rem; /* Jarak antar seksi lebih besar */
    }
    .form-section:last-of-type {
        margin-bottom: 1.5rem; /* Kurangi margin untuk seksi terakhir sebelum tombol */
    }
    .section-label {
        font-size: 1.2em; /* Label seksi lebih besar */
        font-weight: 600;
        color: #00695C; /* Warna tema */
        margin-bottom: 1.25rem;
        padding-bottom: 0.6rem;
        border-bottom: 2px solid #e0f2f1; /* Aksen warna tema */
    }
    .form-grid {
        display: grid;
        gap: 20px; /* Jarak antar field di dalam grid */
    }
    .form-grid.two-columns {
        grid-template-columns: 1fr; /* Default 1 kolom */
    }
    @media (min-width: 768px) { /* Untuk layar md ke atas */
        .form-grid.two-columns {
            grid-template-columns: 1fr 1fr; /* 2 kolom sama lebar */
        }
    }

    .profile-photo-edit-group {
        display: grid;
        grid-template-columns: auto 1fr; /* Kolom untuk gambar dan kolom untuk input */
        gap: 20px;
        align-items: flex-start; /* Sejajarkan item di atas */
    }
    .current-photo-container {
        text-align: center; /* Pusatkan label dan gambar */
    }
    .current-profile-photo-preview {
        width: 120px; /* Ukuran preview foto */
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e2e8f0;
        padding: 3px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-top: 0.5rem; /* Jarak dari label "Foto Saat Ini" */
    }
    .new-photo-container {
        /* Styling untuk container input file jika perlu */
    }
    .admin-form .file-input {
        padding: 0.4rem 0.75rem;
    }

    .form-text.text-muted {
        font-size: 0.85em;
        color: #718096;
        margin-top: 0.35rem;
        display: block;
    }
    hr.form-divider {
        margin-top: 2.5rem !important;
        margin-bottom: 2.5rem !important;
        border-top: 1px solid #e2e8f0;
    }
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px; /* Jarak antar tombol */
        margin-top: 2rem; /* Jarak dari elemen terakhir form */
        padding-top: 1.5rem; /* Padding atas untuk pemisah visual */
        border-top: 1px solid #e2e8f0; /* Garis pemisah sebelum tombol */
    }
    .form-actions .btn {
        padding: 0.65rem 1.3rem; /* Padding tombol lebih besar */
        font-size: 0.95em;
    }

    /* Utility classes (pastikan sudah ada di layouts/admin.blade.php atau CSS global) */
    .d-block { display: block !important; }
    .mb-2 { margin-bottom: 0.5rem !important; }
    .mb-3 { margin-bottom: 1rem !important; }
    /* .me-2 { margin-right: 0.5rem !important; } (sudah ada di layout admin) */
    .mt-3 { margin-top: 1rem !important; }
    .mt-4 { margin-top: 1.5rem !important; }
</style>
@endpush
