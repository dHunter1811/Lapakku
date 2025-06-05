@extends('layouts.app')

@section('title', 'Register - Lapakku')

@section('content')
<div class="container" style="max-width: 500px; margin-top: 50px;">
    <div class="card">
        <h2 class="text-center mb-3" style="color: #00695C;">Register Akun Baru</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- TAMBAHKAN enctype="multipart/form-data" PADA FORM --}}
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Verifikasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <label for="alamat">Alamat (Opsional)</label>
                <textarea id="alamat" name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
            </div>

            <div class="form-group">
                <label for="no_telepon">No. Telepon (Opsional)</label>
                <input id="no_telepon" type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon') }}">
            </div>

            {{-- INPUT FOTO PROFIL BARU --}}
            <div class="form-group">
                <label for="profile_photo">Foto Profil (Opsional)</label>
                <input id="profile_photo" type="file" name="profile_photo" class="form-control" accept="image/png, image/jpeg, image/jpg">
                <small class="form-text text-muted">Format: JPG, PNG. Maks: 2MB.</small>
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" style="color: #00695C;">Sudah punya akun? Login</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Style untuk input file agar lebih konsisten jika diperlukan */
.form-control[type="file"] {
    padding: .375rem .75rem; /* Sesuaikan padding jika perlu */
}
</style>
@endpush
