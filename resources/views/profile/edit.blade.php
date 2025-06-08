@extends('layouts.app')

@section('title', 'Edit Profil Saya - Lapakku')

@section('content')
<div class="container">
    <div class="card" style="max-width: 700px; margin: 40px auto; padding: 30px;">
        <h1 style="color: #00695C; text-align:center; margin-bottom:25px; font-size:2em;">Edit Profil Saya</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong style="display:block; margin-bottom:5px;">Oops! Ada beberapa masalah dengan input Anda:</strong>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Gunakan method PUT untuk update --}}

            <div class="text-center mb-4">
                <img src="{{ $user->profile_photo_url }}" alt="Foto Profil {{ $user->name }}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid #00796B; padding: 3px;">
            </div>

            <div class="form-group">
                <label for="profile_photo">Ganti Foto Profil (Opsional)</label>
                <input id="profile_photo" type="file" name="profile_photo" class="form-control" accept="image/png, image/jpeg, image/jpg">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti. Format: JPG, PNG. Maks: 2MB.</small>
            </div>

            <hr style="margin: 25px 0;">

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat (Opsional)</label>
                <textarea id="alamat" name="alamat" class="form-control" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            <div class="form-group">
                <label for="no_telepon">No. Telepon (Opsional)</label>
                <input id="no_telepon" type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon) }}">
            </div>

            <hr style="margin: 25px 0;">
            <h5 style="color: #00796B; margin-bottom:15px;">Ubah Password (Opsional)</h5>
            <p class="text-muted" style="font-size:0.9em; margin-bottom:15px;">Kosongkan field password jika Anda tidak ingin mengubahnya.</p>

            <div class="form-group">
                <label for="current_password">Password Saat Ini</label>
                <input id="current_password" type="password" name="current_password" class="form-control" autocomplete="current-password">
                 @error('current_password') <span class="text-danger text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="new_password">Password Baru</label>
                <input id="new_password" type="password" name="new_password" class="form-control" autocomplete="new-password">
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                <input id="new_password_confirmation" type="password" name="new_password_confirmation" class="form-control" autocomplete="new-password">
            </div>

            <div class="form-group" style="margin-top:30px;">
                <button type="submit" class="btn btn-primary" style="width:100%; padding:12px; font-size:1.1em;">Simpan Perubahan Profil</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-group { margin-bottom: 1.25rem; }
    .form-control {
        display: block;
        width: 100%;
        padding: .5rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
    }
    .form-control:focus { border-color: #80bdff; box-shadow: 0 0 0 .2rem rgba(0,123,255,.25); }
    .alert { margin-bottom: 1.5rem; }
    .text-sm { font-size: 0.875em; }
</style>
@endpush
