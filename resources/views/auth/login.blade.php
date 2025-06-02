@extends('layouts.app')

@section('title', 'Login - Lapakku')

@section('content')
<div class="container" style="max-width: 500px; margin-top: 50px;">
    <div class="card">
        <h2 class="text-center mb-3" style="color: #00695C;">Login Lapakku</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            {{-- <div class="form-group">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Ingat Saya</label>
            </div> --}}

            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('register') }}" class="btn btn-light" style="width:100%; margin-bottom:10px;">Belum punya akun? Register</a>
                @if (Route::has('password.request'))
                    <a href="{{-- route('password.request') --}}" style="color: #00695C; display: block;">Lupa Password?</a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection