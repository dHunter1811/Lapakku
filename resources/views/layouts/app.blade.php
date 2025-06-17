<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#00796B">
    <title>@yield('title', 'Lapakku - Platform Sewa Tempat Usaha Terpercaya')</title>
    
    <!-- Preconnect untuk optimasi performa -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Font Inter dengan berbagai weight -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            /* Design Tokens */
            --primary: #00796B;
            --primary-dark: #00695C;
            --primary-light: #B2DFDB;
            --primary-50: #E0F2F1;
            --accent: #FFC107;
            --accent-dark: #FFA000;
            --text: #2D3748;
            --text-light: #4A5568;
            --text-lighter: #718096;
            --background: #F8FAFC;
            --white: #FFFFFF;
            --gray-50: #F7FAFC;
            --gray-100: #EDF2F7;
            --gray-200: #E2E8F0;
            --gray-300: #CBD5E0;
            --gray-400: #A0AEC0;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --header-height: 80px;
        }

        /* Base Styles */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.6;
            font-size: 16px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Container System */
        .container {
            width: 100%;
            max-width: 1280px;
            margin-right: auto;
            margin-left: auto;
            padding-right: 24px;
            padding-left: 24px;
        }

        .container-fluid {
            width: 100%;
            padding-right: 24px;
            padding-left: 24px;
        }

        /* Layout */
        main {
            flex-grow: 1;
            padding-top: var(--header-height);
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.25;
            color: var(--text);
            margin-bottom: 1rem;
        }

        h1 { font-size: 2.5rem; }
        h2 { font-size: 2rem; }
        h3 { font-size: 1.75rem; }
        h4 { font-size: 1.5rem; }
        h5 { font-size: 1.25rem; }
        h6 { font-size: 1rem; }

        p {
            margin-bottom: 1rem;
            color: var(--text-light);
        }

        a {
            color: var(--primary);
            text-decoration: none;
            transition: var(--transition);
        }

        a:hover {
            color: var(--primary-dark);
        }

        /* Header Navigation - Modern Redesign */
        .header-nav {
            background-color: var(--white);
            color: var(--text);
            padding: 0;
            box-shadow: var(--shadow-md);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: var(--header-height);
            display: flex;
            align-items: center;
            border-bottom: 1px solid var(--gray-200);
        }

        .header-nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .header-nav .logo-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            margin-right: auto;
            gap: 12px;
        }

        .header-nav .logo-link img.logo-image {
            height: 48px;
            width: auto;
            transition: var(--transition);
        }

        .header-nav .logo-link .logo-text {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-dark);
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: var(--transition);
        }

        /* Main Navigation */
        .main-nav {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .main-nav a {
            color: var(--text-light);
            text-decoration: none;
            padding: 12px 16px;
            font-weight: 500;
            border-radius: var(--radius-md);
            transition: var(--transition);
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .main-nav a:hover,
        .main-nav a.active {
            color: var(--primary-dark);
            background-color: var(--primary-50);
        }

        .main-nav a.active {
            font-weight: 600;
        }

        .main-nav a.active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            background-color: var(--primary);
            border-radius: 50%;
        }

        /* User Profile Dropdown - Enhanced */
        .user-profile-dropdown {
            position: relative;
            margin-left: 12px;
        }

        .user-profile-trigger {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 8px;
            border-radius: var(--radius-xl);
            transition: var(--transition);
            gap: 8px;
        }

        .user-profile-trigger:hover {
            background-color: var(--gray-100);
        }

        .user-profile-trigger img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-50);
        }

        .user-profile-trigger .user-name {
            font-weight: 500;
            font-size: 0.95em;
            color: var(--text);
            margin-right: 4px;
        }

        .user-profile-trigger .chevron {
            transition: transform 0.2s ease;
        }

        .user-profile-dropdown.open .user-profile-trigger .chevron {
            transform: rotate(180deg);
        }

        .user-profile-dropdown-content {
            display: none;
            position: absolute;
            background-color: var(--white);
            min-width: 240px;
            box-shadow: var(--shadow-xl);
            z-index: 1001;
            right: 0;
            border-radius: var(--radius-md);
            margin-top: 8px;
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transform-origin: top right;
            animation: fadeIn 0.2s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .user-profile-dropdown-content a {
            color: var(--text-light) !important;
            padding: 12px 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.95em;
            transition: var(--transition);
            border-left: 3px solid transparent;
        }

        .user-profile-dropdown-content a:hover {
            background-color: var(--gray-50);
            color: var(--primary-dark) !important;
            border-left-color: var(--primary);
        }

        .user-profile-dropdown-content a .icon {
            width: 20px;
            text-align: center;
            color: var(--primary);
        }

        .user-profile-dropdown-content hr {
            margin: 0;
            border: 0;
            border-top: 1px solid var(--gray-200);
        }

        .user-profile-dropdown.open .user-profile-dropdown-content {
            display: block;
        }

        /* Buttons - Modern Style */
        .btn {
            padding: 12px 24px;
            border-radius: var(--radius-md);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            gap: 8px;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
            box-shadow: 0 4px 6px rgba(0, 121, 107, 0.1);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            color: var(--white);
        }

        .btn-secondary {
            background-color: var(--white);
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-secondary:hover {
            background-color: var(--primary-50);
            color: var(--primary-dark);
        }

        .btn-accent {
            background-color: var(--accent);
            color: var(--text);
        }

        .btn-accent:hover {
            background-color: var(--accent-dark);
            color: var(--text);
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.875rem;
        }

        .btn-lg {
            padding: 16px 32px;
            font-size: 1.1rem;
        }

        /* Card System */
        .card {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid var(--gray-200);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid var(--gray-200);
        }

        .card-body {
            padding: 20px;
        }

        .card-footer {
            padding: 20px;
            border-top: 1px solid var(--gray-200);
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .form-control,
        .form-select {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--text);
            background-color: var(--white);
            background-clip: padding-box;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-md);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            outline: 0;
            box-shadow: 0 0 0 3px rgba(0, 121, 107, 0.2);
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: var(--radius-md);
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .alert-icon {
            font-size: 1.25rem;
            margin-top: 2px;
        }

        .alert-success {
            color: #0f5132;
            background-color: #d1e7dd;
            border-color: #badbcc;
        }

        .alert-danger {
            color: #842029;
            background-color: #f8d7da;
            border-color: #f5c2c7;
        }

        /* Product Grid - Enhanced */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 32px;
        }

        .product-card {
            border-radius: var(--radius-lg);
            overflow: hidden;
            background: var(--white);
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            position: relative;
        }

        .product-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-5px);
        }

        .product-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            background-color: var(--primary);
            color: var(--white);
            padding: 4px 12px;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 2;
        }

        .product-image-container {
            position: relative;
            padding-top: 75%; /* 4:3 aspect ratio */
            overflow: hidden;
        }

        .product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-actions {
            position: absolute;
            top: 16px;
            right: 16px;
            display: flex;
            gap: 8px;
            z-index: 2;
        }

        .action-button {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            color: var(--text-light);
            box-shadow: var(--shadow-sm);
        }

        .action-button:hover {
            background: var(--white);
            color: var(--primary);
            transform: scale(1.1);
        }

        .product-details {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-size: 1.15rem;
            font-weight: 600;
            margin: 0 0 8px;
            color: var(--text);
            line-height: 1.4;
        }

        .product-title a {
            color: inherit;
            text-decoration: none;
            transition: var(--transition);
        }

        .product-title a:hover {
            color: var(--primary);
        }

        .product-location {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 12px;
        }

        .product-features {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            font-size: 0.9rem;
            flex-wrap: wrap;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 4px;
            color: var(--text-light);
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--gray-200);
        }

        .price {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.1rem;
        }

        .price span {
            font-size: 0.8rem;
            color: var(--text-light);
            font-weight: 400;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stars {
            display: flex;
        }

        .rating-count {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        /* Footer - Modern Design */
        .footer-main {
            background-color: var(--white);
            color: var(--text-light);
            padding: 60px 0 30px;
            margin-top: auto;
            border-top: 1px solid var(--gray-200);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            text-decoration: none;
        }

        .footer-logo img {
            height: 40px;
            width: auto;
        }

        .footer-logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .footer-about {
            max-width: 300px;
        }

        .footer-about p {
            font-size: 0.95rem;
            line-height: 1.7;
            color: var(--text-light);
        }

        .footer-links h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text);
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: var(--text-light);
            font-size: 0.95rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-links a:hover {
            color: var(--primary);
            transform: translateX(4px);
        }

        .footer-social {
            display: flex;
            gap: 16px;
            margin-top: 20px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
            transition: var(--transition);
        }

        .social-link:hover {
            background-color: var(--primary);
            color: var(--white);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid var(--gray-200);
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .footer-bottom a {
            color: var(--text-light);
            font-weight: 500;
        }

        .footer-bottom a:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        /* Responsive Adjustments */
        @media (max-width: 1024px) {
            .header-nav .container {
                padding-right: 20px;
                padding-left: 20px;
            }
            
            .main-nav {
                gap: 4px;
            }
            
            .main-nav a {
                padding: 10px 12px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            :root {
                --header-height: 70px;
            }
            
            .header-nav {
                height: var(--header-height);
            }
            
            .header-nav .logo-link img.logo-image {
                height: 40px;
            }
            
            .header-nav .logo-link .logo-text {
                font-size: 1.5rem;
            }
            
            .main-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: var(--white);
                box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
                padding: 10px 20px;
                justify-content: space-around;
                z-index: 1000;
            }
            
            .main-nav a {
                flex-direction: column;
                font-size: 0.75rem;
                padding: 8px;
                gap: 4px;
                border-radius: var(--radius-md);
            }
            
            .main-nav a i {
                font-size: 1.2rem;
            }
            
            .main-nav a.active::after {
                bottom: -2px;
                width: 4px;
                height: 4px;
            }
            
            .user-profile-dropdown {
                margin-left: 0;
            }
            
            .user-profile-trigger .user-name {
                display: none;
            }
            
            .user-profile-trigger .chevron {
                display: none;
            }
            
            .user-profile-dropdown-content {
                min-width: 200px;
                right: -20px;
            }
            
            main {
                padding-bottom: 70px; /* Space for bottom nav */
            }
            
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 20px;
            }
            
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .footer-about {
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding-right: 16px;
                padding-left: 16px;
            }
            
            h1 { font-size: 2rem; }
            h2 { font-size: 1.75rem; }
            h3 { font-size: 1.5rem; }
            
            .btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
            
            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Header Navigation -->
    <header class="header-nav">
        <div class="container">
            <a href="{{ route('home') }}" class="logo-link">
                <img src="{{ asset('images/Jukung Lapakku.png') }}" alt="Lapakku Logo" class="logo-image">
                <span class="logo-text">Lapakku</span>
            </a>
            
            <nav class="main-nav">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('lahan.index') }}" class="{{ request()->routeIs('lahan.index') || request()->routeIs('lahan.show') ? 'active' : '' }}">
                    <i class="fas fa-search-location"></i>
                    <span>Cari Lahan</span>
                </a>
                <a href="{{ route('kontak.show') }}" class="{{ request()->routeIs('kontak.show') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    <span>Kontak</span>
                </a>
                <a href="{{ route('bantuan.show') }}" class="{{ request()->routeIs('bantuan.show') ? 'active' : '' }}">
                    <i class="fas fa-question-circle"></i>
                    <span>Bantuan</span>
                </a>
                
                @guest
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
                @else
                <div class="user-profile-dropdown" id="userProfileDropdown">
                    <a href="#" class="user-profile-trigger" onclick="toggleDropdown(event)">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto Profil {{ Auth::user()->name }}">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down chevron"></i>
                    </a>
                    <div class="user-profile-dropdown-content">
                        <a href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-circle icon"></i>
                            <span>Edit Profil</span>
                        </a>
                        @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" style="color: var(--primary-dark) !important; font-weight:600;">
                            <i class="fas fa-cog icon"></i>
                            <span>Panel Admin</span>
                        </a>
                        @else
                        <a href="{{ route('lahanbaru.tambah') }}">
                            <i class="fas fa-plus-circle icon"></i>
                            <span>Tambah Lahan</span>
                        </a>
                        <a href="{{ route('pemilik.dashboard') }}">
                            <i class="fas fa-tachometer-alt icon"></i>
                            <span>Dashboard</span>
                        </a>
                        @endif
                        <hr>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt icon"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    </div>
                </div>
                @endguest
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <a href="{{ route('home') }}" class="footer-logo">
                        <img src="{{ asset('images/Jukung Lapakku.png') }}" alt="Lapakku Logo">
                        <span class="footer-logo-text">Lapakku</span>
                    </a>
                    <p>Platform terpercaya untuk menemukan dan menyewakan tempat usaha di seluruh Indonesia. Memberikan solusi terbaik untuk kebutuhan bisnis Anda.</p>
                    <div class="footer-social">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h3>Perusahaan</h3>
                    <ul>
                        <li><a href="{{ route('tentang-kami.show') }}"><i class="fas fa-chevron-right"></i> Tentang Kami</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Karir</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Blog</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Press Kit</a></li>
                    </ul>
                </div>
                
                <div class="footer-links">
                    <h3>Layanan</h3>
                    <ul>
                        <li><a href="{{ route('lahan.index') }}"><i class="fas fa-chevron-right"></i> Cari Lahan</a></li>
                        <li><a href="{{ route('lahanbaru.tambah') }}"><i class="fas fa-chevron-right"></i> Pasang Iklan</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Mitra Kami</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Panduan</a></li>
                    </ul>
                </div>
                
                <div class="footer-links">
                    <h3>Dukungan</h3>
                    <ul>
                        <li><a href="{{ route('bantuan.show') }}"><i class="fas fa-chevron-right"></i> Pusat Bantuan</a></li>
                        <li><a href="{{ route('kontak.show') }}"><i class="fas fa-chevron-right"></i> Hubungi Kami</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Kebijakan Privasi</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Syarat & Ketentuan</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Lapakku.com. All rights reserved. | 
                    <a href="#">Kebijakan Privasi</a> | 
                    <a href="#">Syarat & Ketentuan</a> | 
                    <a href="#">Peta Situs</a>
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <script>
        // Dropdown Toggle Function
        function toggleDropdown(event) {
            event.preventDefault();
            const dropdown = document.getElementById('userProfileDropdown');
            if (dropdown) {
                dropdown.classList.toggle('open');
            }
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userProfileDropdown');
            if (dropdown && !dropdown.contains(event.target) && !event.target.closest('.user-profile-trigger')) {
                dropdown.classList.remove('open');
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    const headerHeight = document.querySelector('.header-nav').offsetHeight;
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Add animation class when elements come into view
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.product-card, .card, .testimonial-card');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.2;
                
                if (elementPosition < screenPosition) {
                    element.classList.add('animate__animated', 'animate__fadeInUp');
                }
            });
        };
        
        // Run once on page load
        window.addEventListener('load', animateOnScroll);
        
        // Run on scroll
        window.addEventListener('scroll', animateOnScroll);
    </script>
</body>
</html>