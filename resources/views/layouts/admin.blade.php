<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Lapakku')</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/admin-specific.css') }}"> --}}
    <style>
        /* Reset dan Dasar */
        *, *::before, *::after {
            box-sizing: border-box;
        }
        html, body {
            height: 100%;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #f4f7f9;
            color: #334155;
            display: flex;
            min-height: 100vh;
            font-size: 16px;
        }

        /* Sidebar Styling */
        .admin-sidebar {
            width: 260px;
            background-color: #1e293b;
            color: #e2e8f0;
            padding: 20px 15px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 3px 0px 15px rgba(0, 0, 0, 0.1);
            transition: width 0.3s ease;
            display: flex; /* Untuk footer sidebar */
            flex-direction: column; /* Untuk footer sidebar */
        }
        .admin-sidebar .logo {
            font-size: 1.75em;
            font-weight: 700;
            text-align: center;
            margin-bottom: 25px; /* Sedikit dikurangi */
            padding-bottom: 15px; /* Padding bawah untuk garis */
            color: #34d399;
            border-bottom: 1px solid #334155;
        }
        .admin-sidebar .logo span {
            color: #94a3b8;
            font-weight: 400;
        }
        .admin-sidebar nav {
            flex-grow: 1; /* Agar nav mengisi ruang yang tersedia */
        }
        .admin-sidebar nav a {
            display: flex;
            align-items: center;
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 6px;
            font-size: 0.95em;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .admin-sidebar nav a:hover {
            background-color: #334155;
            color: #ffffff;
        }
        .admin-sidebar nav a.active {
            background-color: #34d399;
            color: #1e293b;
            font-weight: 600;
        }
        .admin-sidebar nav a .icon {
            margin-right: 12px; /* Jarak ikon dan teks */
            width: 20px;
            text-align: center;
            font-size: 1.1em; /* Ukuran ikon emoji/teks */
        }
        .admin-sidebar .sidebar-footer { /* Untuk link 'Lihat Situs' di bawah */
            margin-top: auto; /* Mendorong ke bawah */
            padding-top: 15px;
            border-top: 1px solid #334155;
        }

        /* Main Content Styling */
        .admin-main-content {
            margin-left: 260px;
            flex-grow: 1;
            padding: 25px;
            background-color: #f8fafc;
            overflow-y: auto;
        }
        .admin-header {
            background-color: #ffffff;
            padding: 18px 25px;
            margin-bottom: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e2e8f0;
        }
        .admin-header h1 {
            margin: 0;
            font-size: 1.6em;
            color: #1e293b;
            font-weight: 600;
        }
        .user-info {
            display: flex;
            align-items: center;
        }
        .user-info img.profile-photo-header { /* Style untuk foto profil di header admin */
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover; /* Pastikan gambar terisi dengan baik */
            border: 2px solid #e2e8f0;
        }
        .user-info span.admin-name {
            font-weight: 600;
            color: #334155;
            margin-right: 15px;
        }
        .user-info a.header-link { /* Class umum untuk link di header user-info */
            text-decoration: none;
            font-size: 0.9em;
            font-weight: 500;
            padding: 6px 10px;
            border-radius: 4px;
            transition: background-color 0.2s ease;
            display: inline-flex; /* Agar ikon dan teks sejajar */
            align-items: center;
        }
        .user-info a.header-link .icon {
            margin-right: 5px;
        }
        .user-info a.view-site-link {
            color: #2563eb; /* Biru */
            margin-right: 15px;
        }
        .user-info a.view-site-link:hover {
            background-color: #eff6ff;
        }
        .user-info a.logout-link {
            color: #ef4444; /* Merah */
        }
        .user-info a.logout-link:hover {
            background-color: #fee2e2;
        }

        /* ... (CSS Card, Table, Button, Alert Anda yang sudah ada) ... */
        .card { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07); }
        .card-header { padding: 15px 25px; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 8px; border-top-right-radius: 8px; display:flex; justify-content: space-between; align-items: center;}
        .card-header h4 { margin: 0; font-size: 1.15em; font-weight: 600; }
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 0.95em; }
        th, td { border: 1px solid #e2e8f0; padding: 12px 15px; text-align: left; vertical-align: middle; }
        th { background-color: #f1f5f9; font-weight: 600; color: #475569; }
        tbody tr:nth-child(even) { background-color: #f8fafc; }
        tbody tr:hover { background-color: #eff6ff; }
        .btn { padding: 10px 18px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items:center; justify-content:center; border: none; cursor: pointer; font-size: 0.9em; font-weight: 500; transition: background-color 0.2s ease, transform 0.1s ease; }
        .btn .icon { margin-right: 6px; }
        .btn:hover { transform: translateY(-1px); }
        .btn-sm { padding: 6px 12px; font-size: 0.8em; }
        .btn-sm .icon { margin-right: 4px; font-size:0.9em; }
        .btn-xs { padding: .25rem .5rem; font-size: .75rem; } /* Untuk tombol aksi yang sangat kecil */
        .btn-xs .icon { margin-right: 3px; }
        .btn-primary { background-color: #2563eb; color: white; } .btn-primary:hover { background-color: #1d4ed8; }
        .btn-info { background-color: #0ea5e9; color: white; } .btn-info:hover { background-color: #0284c7; }
        .btn-warning { background-color: #f59e0b; color: white; } .btn-warning:hover { background-color: #d97706; }
        .btn-danger { background-color: #ef4444; color: white; } .btn-danger:hover { background-color: #dc2626; }
        .btn-success { background-color: #10b981; color: white; } .btn-success:hover { background-color: #059669; }
        .btn-secondary { background-color: #64748b; color: white; } .btn-secondary:hover { background-color: #475569; }
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 6px; font-size: 0.95em; }
        .alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
        .alert-danger { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
        .alert-info { color: #055160; background-color: #cff4fc; border-color: #b6effb; } /* Style untuk alert info */

        /* Responsive Sidebar (Jika ingin collapse di mobile) */
        @media (max-width: 992px) { /* Breakpoint disesuaikan */
            .admin-sidebar {
                /* Defaultnya sidebar tetap, bisa diubah dengan JS untuk toggle */
                /* width: 0; padding: 20px 0; overflow:hidden; */
            }
            .admin-main-content {
                /* margin-left: 0; */
            }
        }
        @media (max-width: 768px) {
            .admin-sidebar { width: 100%; height: auto; position: relative; box-shadow: 0 2px 5px rgba(0,0,0,0.1); flex-direction: row; /* Untuk logo dan nav jika mau */ }
            .admin-sidebar .logo { margin-bottom:0; border-bottom:none; padding-bottom:0; }
            .admin-sidebar nav { display:flex; flex-wrap:wrap; /* Nav item jadi horizontal */ }
            .admin-sidebar nav a { margin-bottom:0; margin-right:5px; padding:8px 10px; }
            .admin-sidebar .sidebar-footer { display:none; /* Sembunyikan di mobile jika terlalu penuh */ }

            .admin-main-content { margin-left: 0; width: 100%; }
            .admin-header { flex-direction: column; align-items: flex-start; }
            .admin-header h1 { margin-bottom: 10px; }
            .user-info { width: 100%; justify-content: space-between; }
            .user-info a.view-site-link { display:none; /* Sembunyikan link situs di header mobile jika sudah ada di sidebar */ }
        }
    </style>
    @stack('styles')
</head>
<body>
    <aside class="admin-sidebar">
        <div class="logo">Lapakku<span>Admin</span></div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span class="icon">📊</span>Dashboard</a>
            <a href="{{ route('admin.lahan.index') }}" class="{{ request()->routeIs('admin.lahan.*') ? 'active' : '' }}"><span class="icon">📋</span>Manajemen Listing</a>
            <a href="{{ route('admin.ratings.index') }}" class="{{ request()->routeIs('admin.ratings.*') ? 'active' : '' }}"><span class="icon">⭐</span>Daftar Rating</a>
            <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"><span class="icon">✉️</span>Pesan Masuk</a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><span class="icon">👥</span>Manajemen User</a>
        </nav>
        {{-- Link ke Halaman Utama di bagian bawah sidebar --}}
        <div class="sidebar-footer">
            <a href="{{ route('home') }}" target="_blank">
                <span class="icon">🌐</span>Lihat Situs Publik
            </a>
        </div>
    </aside>

    <div class="admin-main-content">
        <header class="admin-header">
            <h1>@yield('page-title', 'Dashboard')</h1>
            <div class="user-info">
                @auth
                    {{-- Tampilkan foto profil admin jika ada --}}
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto {{ Auth::user()->name }}" class="profile-photo-header">
                    <span class="admin-name">{{ Auth::user()->name }}</span>
                    {{-- Link ke Situs Publik dari Header --}}
                    <a href="{{ route('home') }}" target="_blank" class="header-link view-site-link">
                        <span class="icon">🌐</span>Situs
                    </a>
                    <a href="#" class="header-link logout-link" onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">
                        <span class="icon">🚪</span>Logout
                    </a>
                    <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth
            </div>
        </header>

        <main>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
             @if (session('info')) {{-- Tambahkan ini jika Anda menggunakan session 'info' --}}
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
