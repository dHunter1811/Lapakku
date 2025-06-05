<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Lapakku - Sewa Tempat Usaha Jadi Mudah')</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <style>
        /* Reset CSS Dasar */
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            background-color: #f7fafc;
            color: #4a5568;
            line-height: 1.6;
            font-size: 16px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
        }
        main {
            flex-grow: 1;
        }

        /* Header Navigation */
        .header-nav {
            background-color: #00695C;
            color: white;
            padding: 10px 0; /* Mungkin perlu sedikit ditambah jika logo besar */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .header-nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-nav .logo-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            margin-right: auto;
        }
        .header-nav .logo-link img.logo-image {
            /* === UBAH NILAI HEIGHT DI SINI === */
            height: 45px; /* Misalnya dari 35px menjadi 45px atau 50px */
            width: auto;
            margin-right: 12px; /* Jarak mungkin perlu disesuaikan juga */
        }
        .header-nav .logo-link .logo-text {
            /* Jika logo lebih besar, teks mungkin perlu sedikit disesuaikan juga agar seimbang */
            font-size: 1.7em; /* Misalnya sedikit diperbesar */
            font-weight: 700;
            color: white;
        }
        .header-nav .main-nav a {
            color: #e0f2f1;
            text-decoration: none;
            margin-left: 20px;
            padding: 8px 5px;
            font-weight: 500;
            transition: color 0.2s ease, border-bottom-color 0.2s ease;
            border-bottom: 2px solid transparent;
        }
        .header-nav .main-nav a:hover,
        .header-nav .main-nav a.active {
            color: white;
            border-bottom-color: #80cbc4;
        }

        /* ... (CSS User Profile Dropdown dan lainnya tetap sama) ... */
        .user-profile-dropdown { position: relative; display: inline-block; margin-left: 20px; }
        .user-profile-trigger { display: flex; align-items: center; cursor: pointer; padding: 5px; border-radius: 50px; transition: background-color 0.2s ease; }
        .user-profile-trigger:hover { background-color: rgba(255,255,255,0.1); }
        .user-profile-trigger img { width: 38px; height: 38px; border-radius: 50%; margin-right: 10px; object-fit: cover; border: 2px solid #80cbc4; }
        .user-profile-trigger .user-name { font-weight: 500; font-size: 0.95em; color: white; }
        .user-profile-dropdown-content { display: none; position: absolute; background-color: #ffffff; min-width: 220px; box-shadow: 0px 8px 20px 0px rgba(0,0,0,0.15); z-index: 1001; right: 0; border-radius: 6px; margin-top: 8px; border: 1px solid #e2e8f0; overflow: hidden; }
        .user-profile-dropdown-content a { color: #4a5568 !important; padding: 12px 18px; text-decoration: none; display: block; font-size: 0.9em; transition: background-color 0.2s ease; white-space: nowrap; }
        .user-profile-dropdown-content a .icon { margin-right: 8px; opacity: 0.7; }
        .user-profile-dropdown-content a:hover { background-color: #f1f5f9; }
        .user-profile-dropdown-content hr { margin: 6px 0; border: 0; border-top: 1px solid #e2e8f0; }
        .user-profile-dropdown.open .user-profile-dropdown-content { display: block; }
        .footer-main { background-color: #e2e8f0; color: #64748b; text-align: center; padding: 25px 0; margin-top: auto; font-size: 0.9em; border-top: 1px solid #cbd5e0; }
        .footer-main a { color: #00695C; text-decoration: none; font-weight: 500; }
        .footer-main a:hover { text-decoration: underline; }
        .card { background-color: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -1px rgba(0,0,0,0.04); }
        .btn { padding: 10px 18px; border-radius: 6px; text-decoration: none; display: inline-block; border: none; cursor: pointer; font-weight: 500; transition: background-color 0.2s ease, transform 0.1s ease; }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary { background-color: #00796B; color: white; } .btn-primary:hover { background-color: #00695C; }
        .btn-secondary { background-color: #64748b; color: white; } .btn-secondary:hover { background-color: #475569; }
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #4a5568; font-size: 0.9em; }
        .form-control, .form-select { display: block; width: 100%; padding: .5rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #cbd5e0; border-radius: .375rem; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; box-sizing: border-box;}
        .form-control:focus, .form-select:focus { border-color: #3b82f6; outline: 0; box-shadow: 0 0 0 .2rem rgba(59,130,246,.25); }
        .alert { padding: 1rem; margin-bottom: 1.5rem; border: 1px solid transparent; border-radius: .375rem; }
        .alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
        .alert-danger { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 25px; }
        .product-card { border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; background: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -1px rgba(0,0,0,0.04); display:flex; flex-direction:column; transition: box-shadow 0.2s ease, transform 0.2s ease;}
        .product-card:hover { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); transform: translateY(-3px); }
        .product-card img { width: 100%; height: 200px; object-fit: cover; }
        .product-card-content { padding: 18px; flex-grow:1; display:flex; flex-direction:column; }
        .product-card-content h3 { margin-top: 0; font-size: 1.15em; margin-bottom: 10px; color:#334155; line-height:1.3; height:auto; min-height:44px; }
        .product-card-content h3 a {text-decoration:none; color:inherit;}
        .product-card-content .price { font-weight: 700; font-size:1.1em; color: #00796B; margin-bottom: 8px; }
        .product-card-content .location, .product-card-content .rating, .product-card-content .time { font-size: 0.85em; color: #64748b; margin-bottom:6px;}
        .product-card-content .btn-sm { margin-top:auto; }
    </style>
    @stack('styles')
</head>
<body>
    <header class="header-nav">
        <div class="container">
            <a href="{{ route('home') }}" class="logo-link">
                <img src="{{ asset('images/logo-lapakku.jpg') }}" alt="Lapakku Logo" class="logo-image">
                <span class="logo-text">Lapakku</span>
            </a>
            <nav class="main-nav" style="display: flex; align-items: center;">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('lahan.index') }}" class="{{ request()->routeIs('lahan.index') || request()->routeIs('lahan.show') ? 'active' : '' }}">Cari Lahan</a>
                <a href="{{ route('kontak.show') }}" class="{{ request()->routeIs('kontak.show') ? 'active' : '' }}">Kontak</a>
                 <a href="{{ route('bantuan.show') }}" class="{{ request()->routeIs('bantuan.show') ? 'active' : '' }}">Bantuan</a> {{-- Tambahkan link bantuan jika ada --}}
                @guest
                    <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                    <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
                @else
                    <div class="user-profile-dropdown" id="userProfileDropdown">
                        <a href="#" class="user-profile-trigger" onclick="toggleDropdown(event)">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto Profil {{ Auth::user()->name }}">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px; height:16px; margin-left:5px; opacity:0.7;">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.29a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <div class="user-profile-dropdown-content">
                            <a href="{{ route('profile.edit') }}"><span class="icon">👤</span>Edit Profil Saya</a>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" style="background-color: #e0f2f1; color: #004d40 !important; font-weight:500;">
                                    <span class="icon">⚙️</span>Panel Admin
                                </a>
                            @else
                                <a href="{{ route('lahan.create') }}"><span class="icon">➕</span>Tambah Lahan Baru</a>
                                <a href="{{ route('pemilik.dashboard') }}"><span class="icon">🏠</span>Dashboard Saya</a>
                            @endif
                            <hr>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <span class="icon">🚪</span>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                        </div>
                    </div>
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
                <a href="{{ route('tentang-kami.show') }}">Tentang Kami</a> |
                <a href="{{ route('kontak.show') }}">Kontak</a> |
                <a href="{{ route('bantuan.show') }}">Bantuan</a>
            </p>
        </div>
    </footer>

    @stack('scripts')
    <script>
        function toggleDropdown(event) {
            event.preventDefault();
            const dropdown = document.getElementById('userProfileDropdown');
            if (dropdown) {
                dropdown.classList.toggle('open');
            }
        }
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userProfileDropdown');
            if (dropdown && !dropdown.contains(event.target) && !event.target.closest('.user-profile-trigger')) {
                dropdown.classList.remove('open');
            }
        });
    </script>
</body>
</html>
