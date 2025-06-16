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

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Verifikasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3">{{ old('alamat') }}</textarea>
            </div>

            <div class="form-group">
                <label for="no_telepon">No. Telepon</label>
                <input id="no_telepon" type="text" name="no_telepon" value="{{ old('no_telepon') }}">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" style="color: #00695C;">Sudah punya akun? Login</a>
            </div>
        </form>
    </div>
</div>
@endsection