@extends('layouts.app')

@section('title', 'Selamat Datang di Lapakku')

@section('content')
<div class="landing-container">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Temukan Lahan Usaha Terbaik untuk Bisnis Anda</h1>
                <p class="hero-subtitle">Platform terpercaya untuk menyewa dan menyewakan properti komersial</p>
            </div>
            
            <div class="hero-search">
                <form action="{{ route('lahan.index') }}" method="GET" class="search-form">
                    <div class="search-input-group">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z"/>
                        </svg>
                        <input type="text" name="search" placeholder="Cari lokasi, ruko, kios, atau area..." class="search-input" value="{{ request('search') }}">
                        <button type="submit" class="search-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="margin-right:8px;">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                            Cari
                        </button>
                    </div>
                </form>
                
                <div class="search-tags">
                    <span>Populer:</span>
                    <a href="{{ route('lahan.index', ['tipe_lahan' => 'ruko']) }}">Ruko</a>
                    <a href="{{ route('lahan.index', ['tipe_lahan' => 'kios']) }}">Kios Pasar</a>
                    <a href="{{ route('lahan.index', ['tipe_lahan' => 'lahan-terbuka']) }}">Lahan Kosong</a>
                </div>
            </div>
        </div>
        
        <div class="hero-image">
            <img src="{{ asset('images/hero-property.jpg') }}" onerror="this.onerror=null;this.src='https://placehold.co/600x400/D3D3D3/000000?text=Lapakku+Property';" alt="Properti Komersial">
        </div>
    </section>

    <!-- Trust Badges -->
    <div class="trust-badges">
        <div class="trust-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
            </svg>
            <span>Proses Cepat</span>
        </div>
        <div class="trust-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
            </svg>
            <span>Transaksi Aman</span>
        </div>
        <div class="trust-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
            </svg>
            <span>Kontrak Resmi</span>
        </div>
        <div class="trust-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
            </svg>
            <span>Data Terlindungi</span>
        </div>
    </div>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="section-header">
            <h2 class="section-title">Temukan Berdasarkan Kategori</h2>
            <p class="section-subtitle">Pilih jenis properti yang sesuai dengan kebutuhan bisnis Anda</p>
        </div>
        
        <div class="categories-grid">
            @php
            // Contoh data kategori jika belum ada dari controller
            $categories = $categories ?? [
                ['name' => 'Ruko', 'icon' => '🏢', 'value' => 'ruko'],
                ['name' => 'Kios', 'icon' => '🏪', 'value' => 'kios'],
                ['name' => 'Area Pasar', 'icon' => '🛍️', 'value' => 'area-pasar'],
                ['name' => 'Lahan Terbuka', 'icon' => '🌳', 'value' => 'lahan-terbuka'],
                ['name' => 'Gudang', 'icon' => '🏭', 'value' => 'gudang'],
                ['name' => 'Kantor', 'icon' => '🏢', 'value' => 'kantor'],
            ];
            @endphp
            @foreach($categories as $category)
            <a href="{{ route('lahan.index', ['tipe_lahan' => $category['value']]) }}" class="category-card">
                <div class="category-icon">{{ $category['icon'] }}</div>
                <h3>{{ $category['name'] }}</h3>
                <div class="property-count">{{ rand(500, 2000) }}+ Properti</div> {{-- Placeholder count --}}
                <div class="explore-link">
                    Jelajahi
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                    </svg>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    <!-- Featured Properties Section -->
    <section class="featured-section">
        <div class="section-header">
            <h2 class="section-title">Rekomendasi Lahan Terbaik</h2>
            <p class="section-subtitle">Properti pilihan dengan lokasi strategis dan harga kompetitif</p>
        </div>
        
        <div class="properties-grid">
            @forelse ($rekomendasiLahan ?? [] as $lahan)
            <div class="property-card">
                <div class="property-badge">Rekomendasi</div>
                <div class="property-image-container">
                    <a href="{{ route('lahan.show', $lahan) }}" class="property-image-link">
                        <img src="{{ $lahan->gambar_utama ? Storage::url($lahan->gambar_utama) : 'https://placehold.co/400x250/C0C0C0/333333?text=Lapakku+Lahan' }}" alt="{{ $lahan->judul }}" class="property-image">
                        <div class="property-overlay">
                            <span>Lihat Detail</span>
                        </div>
                    </a>
                    <div class="property-actions">
                        <button class="wishlist-button" title="Tambah ke Wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                            </svg>
                        </button>
                        <button class="share-button" title="Bagikan">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="property-details">
                    <h3><a href="{{ route('lahan.show', $lahan) }}">{{ Str::limit($lahan->judul, 45) }}</a></h3>
                    <div class="property-location">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                        </svg>
                        {{ $lahan->lokasi }}
                    </div>
                    <div class="property-features">
                        <div class="feature">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                            </svg>
                            {{ $lahan->luas }} m²
                        </div>
                        <div class="feature">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                            </svg>
                            Tayang {{ $lahan->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="property-price">
                        Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }}<span>/bulan</span>
                    </div>
                    <div class="property-rating">
                        @if(isset($lahan->ratings_avg_rating) && $lahan->ratings_avg_rating > 0)
                        <div class="stars">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= round($lahan->ratings_avg_rating))
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="rating-text">{{ number_format($lahan->ratings_avg_rating, 1) }} ({{ $lahan->ratings_count }} ulasan)</span>
                        @else
                        <span class="no-rating">Belum ada ulasan</span>
                        @endif
                    </div>
                    <a href="{{ route('lahan.show', $lahan) }}" class="view-button">Lihat Detail</a>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <img src="{{ asset('images/no-properties.svg') }}" onerror="this.onerror=null;this.src='https://placehold.co/150x150/EEEEEE/333333?text=Tidak+Ada+Properti';" alt="No properties" class="empty-image">
                <h3>Belum ada lahan yang tersedia</h3>
                <p>Silakan coba lagi nanti atau pasang iklan lahan Anda</p>
                <a href=# class="primary-button">Pasang Iklan</a>
            </div>
            @endforelse
        </div>
        
        <div class="section-footer">
            <a href="{{ route('lahan.index') }}" class="view-all-button">Lihat Semua Lahan Tersedia</a>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="section-header">
            <h2 class="section-title">Cara Kerja Lapakku</h2>
            <p class="section-subtitle">Temukan atau sewakan properti komersial dalam 3 langkah mudah</p>
        </div>
        
        <div class="steps-container">
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </div>
                <h3>Cari Properti</h3>
                <p>Temukan properti yang sesuai dengan kebutuhan bisnis Anda menggunakan filter canggih kami</p>
            </div>
            
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                    </svg>
                </div>
                <h3>Hubungi Pemilik</h3>
                <p>Ajukan pertanyaan atau negosiasi langsung melalui sistem pesan kami</p>
            </div>
            
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                </div>
                <h3>Selesaikan Transaksi</h3>
                <p>Lakukan pembayaran dan tanda tangan kontrak secara aman melalui platform kami</p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="section-header">
            <h2 class="section-title">Apa Kata Pengguna Kami?</h2>
            <p class="section-subtitle">Testimonial dari pemilik dan penyewa lahan</p>
        </div>
        
        <div class="testimonials-slider">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="quote-icon">"</div>
                    <p>Saya berhasil menemukan tempat usaha yang strategis di sini, prosesnya juga cepat dan aman. Dalam 2 minggu toko saya sudah bisa beroperasi.</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">R</div>
                    <div class="author-info">
                        <strong>Rizky Santoso</strong>
                        <span>Pemilik Toko Baju</span>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="quote-icon">"</div>
                    <p>Lapakku memudahkan saya untuk memasarkan lahan kosong yang saya miliki. Dalam 1 bulan sudah ada 5 calon penyewa yang menghubungi.</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">F</div>
                    <div class="author-info">
                        <strong>Bapak Farros</strong>
                        <span>Pemilik Lahan</span>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="quote-icon">"</div>
                    <p>Sistem pembayaran yang transparan dan proses sewa yang mudah membuat saya nyaman menggunakan platform ini untuk mencari lokasi usaha.</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">S</div>
                    <div class="author-info">
                        <strong>Ibu Siti</strong>
                        <span>Pemilik Warung Makan</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2>Siap Memulai Bisnis Anda?</h2>
            <p>Bergabunglah dengan ribuan pengguna yang telah menemukan lokasi sempurna untuk bisnis mereka</p>
            <div class="cta-buttons">
                <a href="{{ route('lahan.index') }}" class="primary-button">Cari Lahan</a>
                <a href=# class="secondary-button">Pasang Iklan</a> <!--lahan.create -->
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    /* Base Styles */
    :root {
        --primary-color: #00695C;
        --primary-light: #4DB6AC;
        --primary-dark: #004D40;
        --secondary-color: #FF8F00; /* Orange for accents */
        --secondary-light: #FFC107;
        --dark-color: #263238; /* Dark gray for text */
        --light-color: #F5F5F5; /* Light gray background */
        --gray-color: #757575; /* Medium gray for subtitles/details */
        --light-gray: #E0E0E0; /* Lighter gray for borders/dividers */
        --white: #FFFFFF;
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 8px 16px rgba(0, 0, 0, 0.12);
        --radius: 8px;
        --transition: all 0.3s ease;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Inter', sans-serif; /* Menggunakan Inter sesuai saran sebelumnya */
        line-height: 1.6;
        color: var(--dark-color);
        background-color: var(--light-color);
    }

    .landing-container {
        max-width: 1440px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Section Header */
    .section-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 2.2rem; /* Sedikit lebih besar dari 2rem */
        color: var(--dark-color);
        margin-bottom: 10px;
        font-weight: 700;
    }

    .section-subtitle {
        color: var(--gray-color);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Hero Section */
    .hero-section {
        display: flex;
        align-items: center;
        padding: 80px 0;
        gap: 40px;
        background-color: var(--white); /* Latar belakang putih untuk hero */
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 60px;
    }

    .hero-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 30px;
        padding-left: 40px; /* Padding di kiri untuk konten */
    }

    .hero-text {
        max-width: 600px;
    }

    .hero-title {
        font-size: 2.8rem;
        color: var(--primary-color); /* Warna hijau untuk judul hero */
        margin-bottom: 15px;
        line-height: 1.2;
        font-weight: 800;
    }

    .hero-subtitle {
        font-size: 1.3rem;
        color: var(--gray-color);
        margin-bottom: 25px;
    }

    .hero-stats {
        display: flex;
        gap: 30px;
        flex-wrap: wrap; /* Agar responsif */
    }

    .stat-item {
        display: flex;
        flex-direction: column;
    }

    .stat-number {
        font-size: 2.2rem; /* Sedikit lebih besar */
        font-weight: 700;
        color: var(--primary-dark); /* Lebih gelap */
        line-height: 1;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--gray-color);
    }

    .hero-search {
        width: 100%;
        max-width: 500px; /* Batasi lebar search form di hero */
        margin-right: 40px; /* Margin di kanan untuk search form */
    }

    .hero-image {
        flex: 1;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        margin-right: 40px; /* Pastikan gambar tidak terlalu ke tepi */
        min-width: 400px; /* Pastikan gambar punya ukuran minimal */
    }

    .hero-image img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.5s ease; /* Transisi untuk efek hover */
    }

    .hero-image:hover img {
        transform: scale(1.05); /* Efek zoom in pada hover */
    }

    /* Search Form */
    .search-form {
        width: 100%;
    }

    .search-input-group {
        display: flex;
        background: var(--white);
        border-radius: 50px; /* Lebih bulat */
        overflow: hidden;
        box-shadow: var(--shadow);
        border: 1px solid var(--light-gray);
    }

    .search-icon {
        width: 20px;
        height: 20px;
        margin: 15px;
        color: var(--gray-color);
    }

    .search-input {
        flex: 1;
        border: none;
        padding: 15px 10px;
        font-size: 1rem;
        outline: none;
        color: var(--dark-color);
    }

    .search-input::placeholder {
        color: var(--gray-color);
    }

    .search-button {
        display: flex;
        align-items: center;
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 0 25px;
        font-weight: 600; /* Lebih tebal */
        cursor: pointer;
        transition: var(--transition);
        border-radius: 0 50px 50px 0; /* Hanya sisi kanan yang bulat */
    }

    .search-button svg {
        fill: white;
    }

    .search-button:hover {
        background-color: var(--primary-dark);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .search-tags {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 15px;
        font-size: 0.9rem;
        color: var(--gray-color);
    }

    .search-tags a {
        color: var(--primary-color);
        text-decoration: none;
        padding: 5px 12px;
        border: 1px solid var(--primary-color);
        border-radius: 20px;
        transition: var(--transition);
    }

    .search-tags a:hover {
        background-color: var(--primary-color);
        color: var(--white);
        transform: translateY(-2px);
    }

    /* Buttons */
    .primary-button {
        display: inline-block;
        background-color: var(--primary-color);
        color: white;
        padding: 14px 30px; /* Lebih besar */
        border-radius: 50px; /* Lebih bulat */
        text-decoration: none;
        font-weight: 600; /* Lebih tebal */
        transition: var(--transition);
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0, 105, 92, 0.3); /* Shadow untuk tombol */
    }

    .primary-button:hover {
        background-color: var(--primary-dark);
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 105, 92, 0.4);
    }

    .secondary-button {
        display: inline-block;
        background-color: var(--white);
        color: var(--primary-color);
        padding: 14px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        border: 2px solid var(--primary-color); /* Border lebih tebal */
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .secondary-button:hover {
        background-color: rgba(0, 105, 92, 0.1);
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Trust Badges */
    .trust-badges {
        display: flex;
        justify-content: space-around;
        align-items: center;
        background-color: var(--white);
        padding: 30px; /* Lebih banyak padding */
        border-radius: var(--radius);
        margin: 40px 0;
        box-shadow: var(--shadow);
        flex-wrap: wrap;
        gap: 20px; /* Jarak antar item */
    }

    .trust-item {
        display: flex;
        flex-direction: column; /* Ikon di atas teks */
        align-items: center;
        gap: 8px;
        font-weight: 500;
        color: var(--dark-color);
        text-align: center;
    }

    .trust-item svg {
        color: var(--primary-color);
        width: 32px; /* Ikon lebih besar */
        height: 32px;
    }

    .trust-item span {
        font-size: 1rem;
    }

    /* Categories Section */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 25px; /* Jarak lebih besar */
        margin-bottom: 60px;
    }

    .category-card {
        padding: 25px 20px;
        border-radius: var(--radius);
        text-align: center;
        transition: var(--transition);
        text-decoration: none;
        color: var(--dark-color);
        background-color: var(--white);
        box-shadow: var(--shadow);
        display: flex; /* Menggunakan flexbox untuk layout internal */
        flex-direction: column;
        justify-content: space-between; /* Menarik konten ke atas dan bawah */
        min-height: 180px; /* Tinggi minimum untuk konsistensi */
    }

    .category-card:hover {
        transform: translateY(-8px); /* Efek hover lebih menonjol */
        box-shadow: var(--shadow-hover);
        border: 1px solid var(--primary-light); /* Border tipis saat hover */
    }

    .category-icon {
        font-size: 3rem; /* Ikon lebih besar */
        margin-bottom: 15px;
    }

    .category-card h3 {
        margin-bottom: 8px; /* Lebih kecil */
        font-size: 1.2rem; /* Lebih besar */
        font-weight: 600;
    }

    .property-count {
        font-size: 0.9rem; /* Lebih besar */
        color: var(--gray-color);
        margin-bottom: 10px;
    }

    .explore-link {
        display: inline-flex;
        align-items: center;
        font-size: 0.95rem; /* Lebih besar */
        color: var(--primary-color);
        font-weight: 500;
    }

    .explore-link svg {
        margin-left: 5px;
        transition: var(--transition);
    }

    .category-card:hover .explore-link svg {
        transform: translateX(5px);
    }

    /* Properties Section */
    .properties-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); /* Ukuran kartu lebih fleksibel */
        gap: 30px; /* Jarak lebih besar */
        margin-bottom: 40px;
    }

    .property-card {
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        position: relative;
    }

    .property-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
    }

    .property-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: var(--secondary-color);
        color: white;
        padding: 6px 12px; /* Padding lebih besar */
        border-radius: 20px; /* Lebih bulat */
        font-size: 0.85rem; /* Lebih besar */
        font-weight: 600;
        z-index: 10; /* Pastikan di atas overlay */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .property-image-container {
        position: relative;
        height: 220px; /* Tinggi gambar lebih besar */
        overflow: hidden;
    }

    .property-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .property-card:hover .property-image {
        transform: scale(1.05); /* Efek zoom pada gambar */
    }

    .property-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 105, 92, 0.6); /* Overlay hijau transparan */
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .property-card:hover .property-overlay {
        opacity: 1; /* Muncul saat hover */
    }

    .property-actions {
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        z-index: 10;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .property-card:hover .property-actions {
        opacity: 1;
    }

    .wishlist-button, .share-button {
        background-color: rgba(255, 255, 255, 0.8); /* Latar belakang putih transparan */
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
    }

    .wishlist-button svg, .share-button svg {
        color: var(--primary-color);
        width: 20px;
        height: 20px;
        transition: var(--transition);
    }

    .wishlist-button:hover, .share-button:hover {
        background-color: var(--primary-color);
    }

    .wishlist-button:hover svg, .share-button:hover svg {
        fill: white;
    }

    .property-details {
        padding: 15px 20px 20px; /* Padding lebih proporsional */
    }

    .property-details h3 {
        font-size: 1.3rem; /* Judul lebih besar */
        margin-bottom: 10px;
        font-weight: 700;
        line-height: 1.4;
        height: 3.2em; /* Tinggi tetap untuk 2 baris teks */
        overflow: hidden;
    }

    .property-details h3 a {
        text-decoration: none;
        color: var(--dark-color);
        transition: var(--transition);
    }

    .property-details h3 a:hover {
        color: var(--primary-color);
    }

    .property-location {
        display: flex;
        align-items: center;
        color: var(--gray-color);
        font-size: 0.95rem;
        margin-bottom: 10px;
    }

    .property-location svg {
        margin-right: 5px;
        color: var(--primary-light); /* Warna ikon lokasi */
    }

    .property-features {
        display: flex;
        gap: 15px;
        margin-bottom: 10px;
    }

    .feature {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        color: var(--gray-color);
    }

    .feature svg {
        margin-right: 5px;
        color: var(--primary-light);
    }

    .property-price {
        font-size: 1.8rem; /* Harga lebih besar */
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 15px;
    }

    .property-price span {
        font-size: 1rem;
        font-weight: 500;
        color: var(--gray-color);
    }

    .property-rating {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .property-rating .stars svg {
        fill: var(--secondary-color); /* Warna bintang */
        width: 18px;
        height: 18px;
        margin-right: 2px;
    }

    .property-rating .rating-text {
        font-size: 0.95rem;
        color: var(--gray-color);
        margin-left: 5px;
    }

    .property-rating .no-rating {
        font-size: 0.95rem;
        color: var(--gray-color);
    }

    .view-button {
        display: block;
        width: 100%;
        text-align: center;
        background-color: var(--primary-color);
        color: white;
        padding: 12px 0;
        border-radius: var(--radius);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .view-button:hover {
        background-color: var(--primary-dark);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .empty-state {
        grid-column: 1 / -1; /* Mengambil seluruh lebar grid */
        text-align: center;
        padding: 50px;
        background-color: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
    }

    .empty-image {
        width: 150px;
        height: auto;
        margin-bottom: 20px;
        opacity: 0.8;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        color: var(--dark-color);
        margin-bottom: 10px;
    }

    .empty-state p {
        color: var(--gray-color);
        margin-bottom: 20px;
    }

    /* How It Works Section */
    .how-it-works {
        padding: 80px 0;
        background-color: var(--white); /* Latar belakang untuk section ini */
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 60px;
    }

    .steps-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        padding: 0 40px;
    }

    .step {
        text-align: center;
        padding: 30px;
        background-color: var(--light-color);
        border-radius: var(--radius);
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--light-gray);
    }

    .step:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--primary-light);
    }

    .step-number {
        position: absolute;
        top: 15px;
        left: 15px;
        font-size: 2.5rem;
        font-weight: 800;
        color: rgba(0, 105, 92, 0.1); /* Warna transparan */
        line-height: 1;
        z-index: 0;
    }

    .step-icon {
        font-size: 3rem; /* Ikon lebih besar */
        color: var(--primary-color);
        margin-bottom: 20px;
        position: relative; /* Agar di atas nomor */
        z-index: 1;
    }

    .step h3 {
        font-size: 1.4rem;
        color: var(--dark-color);
        margin-bottom: 10px;
        font-weight: 600;
        position: relative;
        z-index: 1;
    }

    .step p {
        color: var(--gray-color);
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
    }

    /* Testimonials Section */
    .testimonials-section {
        margin-bottom: 60px;
    }

    .testimonials-slider {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .testimonial-card {
        background-color: var(--white);
        padding: 30px;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 250px; /* Tinggi minimum testimonial */
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
        border-left: 5px solid var(--primary-color); /* Border kiri saat hover */
    }

    .testimonial-content {
        margin-bottom: 20px;
        position: relative;
    }

    .quote-icon {
        font-size: 3rem;
        color: var(--primary-light);
        position: absolute;
        top: -15px;
        left: -10px;
        opacity: 0.2;
        font-family: serif;
    }

    .testimonial-content p {
        font-style: italic;
        color: var(--dark-color);
        font-size: 1.05rem;
        line-height: 1.8;
        padding-top: 15px; /* Menjaga jarak dari ikon kutip */
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 15px;
    }

    .author-avatar {
        width: 50px;
        height: 50px;
        background-color: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .author-info {
        display: flex;
        flex-direction: column;
    }

    .author-info strong {
        font-size: 1.1rem;
        color: var(--dark-color);
        font-weight: 700;
    }

    .author-info span {
        font-size: 0.9rem;
        color: var(--gray-color);
    }

    /* CTA Section */
    .cta-section {
        background-color: var(--primary-color);
        color: white;
        padding: 80px 40px;
        border-radius: var(--radius);
        text-align: center;
        margin-bottom: 60px;
        box-shadow: var(--shadow-hover);
    }

    .cta-content h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .cta-content p {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 40px;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .cta-buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .cta-buttons .primary-button,
    .cta-buttons .secondary-button {
        color: var(--primary-color); /* Warna tombol kedua di CTA */
        border-color: var(--white);
        background-color: var(--white);
    }

    .cta-buttons .primary-button:hover,
    .cta-buttons .secondary-button:hover {
        background-color: var(--primary-dark);
        color: var(--white);
        border-color: var(--primary-dark);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Section Footer (View All Button) */
    .section-footer {
        text-align: center;
        margin-top: 40px;
    }

    .view-all-button {
        display: inline-flex;
        align-items: center;
        background-color: var(--primary-color);
        color: white;
        padding: 15px 35px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        transition: var(--transition);
        box-shadow: 0 4px 10px rgba(0, 105, 92, 0.3);
    }

    .view-all-button svg {
        margin-left: 10px;
        transition: var(--transition);
    }

    .view-all-button:hover {
        background-color: var(--primary-dark);
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 105, 92, 0.4);
    }

    .view-all-button:hover svg {
        transform: translateX(5px);
    }


    /* Responsive Adjustments */
    @media (max-width: 1024px) {
        .hero-section {
            flex-direction: column;
            text-align: center;
            padding: 60px 20px;
        }

        .hero-content {
            padding-left: 0;
            align-items: center;
        }

        .hero-image {
            margin-right: 0;
            min-width: unset;
            max-width: 80%; /* Batasi ukuran gambar di tablet */
            margin-top: 40px;
        }

        .hero-search {
            margin-right: 0;
            max-width: 100%;
        }

        .section-title {
            font-size: 2rem;
        }

        .testimonials-slider, .properties-grid, .steps-container {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        .trust-badges {
            padding: 25px;
            gap: 15px;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.2rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .hero-stats {
            justify-content: center;
            gap: 20px;
        }

        .search-input-group {
            flex-direction: column; /* Input dan tombol di tumpuk */
            border-radius: var(--radius);
        }

        .search-input {
            border-radius: var(--radius) var(--radius) 0 0;
            padding: 12px 15px;
        }

        .search-button {
            width: 100%;
            border-radius: 0 0 var(--radius) var(--radius);
            padding: 12px 15px;
            justify-content: center;
        }

        .search-icon {
            display: none; /* Sembunyikan ikon di mobile search */
        }

        .search-tags {
            justify-content: center;
            flex-wrap: wrap;
        }

        .primary-button, .secondary-button {
            width: 100%;
            text-align: center;
        }

        .trust-badges {
            flex-direction: column;
            gap: 20px;
        }

        .section-title {
            font-size: 1.8rem;
        }

        .testimonials-slider, .properties-grid, .steps-container {
            grid-template-columns: 1fr; /* Satu kolom di mobile */
        }

        .cta-content h2 {
            font-size: 2rem;
        }

        .cta-content p {
            font-size: 1rem;
        }

        .cta-buttons {
            flex-direction: column;
        }
    }
</style>
@endpush
