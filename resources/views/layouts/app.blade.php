<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Lapakku')</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            background-color: #f4f7f6;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header-nav {
            background-color: #00695C;
            color: white;
            padding: 15px 0;
        }

        .header-nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-nav a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }

        .header-nav .logo {
            font-size: 1.5em;
            font-weight: bold;
        }

        .footer-main {
            background-color: #e0e0e0;
            color: #555;
            text-align: center;
            padding: 20px 0;
            margin-top: 30px;
            font-size: 0.9em;
        }

        .footer-main a {
            color: #00695C;
            text-decoration: none;
        }

        .card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn {
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #00796B;
            color: white;
        }

        .btn-secondary {
            background-color: #4DB6AC;
            color: white;
        }

        .btn-light {
            background-color: white;
            color: #00796B;
            border: 1px solid #00796B;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .text-center {
            text-align: center;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }

        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .product-card-content {
            padding: 15px;
        }

        .product-card-content h3 {
            margin-top: 0;
            font-size: 1.1em;
        }

        .product-card-content .price {
            font-weight: bold;
            color: #00796B;
        }

        .product-card-content .location,
        .product-card-content .rating,
        .product-card-content .time {
            font-size: 0.9em;
            color: #555;
            margin-bottom: 5px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background-color: white;
        }
        /* Tambahkan CSS lainnya di sini atau di file terpisah */
    </style>
    @stack('styles')
</head>

<body>
    <header class="header-nav">
        <div class="container">
            <a href="{{ route('home') }}" class="logo" style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ asset('images/lapakku-logo.png') }}" alt="Lapakku Logo" class="logo-icon">
                Lapakku
            </a>
            <nav>
                <a href="{{ route('home') }}">Home</a>
                @guest
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
                @else
                <a href="{{ route('lahan.create') }}">Tambah Lahan</a>
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                @else
                {{-- <a href="{{ route('user.dashboard') }}">Dashboard Saya</a> --}}
                @endif
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @endguest
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer-main">
        <div class="container">
            <p>&copy; {{ date('Y') }} Lapakku.com |
                <a href="#">Tentang Kami</a> |
                <a href="#">Kontak</a> |
                <a href="#">Bantuan</a>
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>