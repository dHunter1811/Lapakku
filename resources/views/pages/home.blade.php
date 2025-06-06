@extends('layouts.app')

@section('title', 'Selamat Datang di Lapakku')

@section('content')
<div class="landing-container">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Temukan Lahan Usaha Ideal untuk Bisnis Anda</h1>
            <p class="hero-subtitle">Solusi tepat sewa ruko, kios, dan lahan terbuka untuk kebutuhan UMKM dengan lokasi strategis</p>
            
            <form action="{{ route('lahan.index') }}" method="GET" class="search-form">
                <div class="search-input-group">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z"/>
                    </svg>
                    <input type="text" name="search" placeholder="Cari lokasi, ruko, kios, atau area..." class="search-input">
                    <button type="submit" class="search-button">Cari Lahan</button>
                </div>
            </form>
            
            <div class="hero-actions">
                <a href="{{ route('lahan.index') }}" class="secondary-button" style="width: auto;">Lihat Semua Lahan</a>
                <a href="{{ route('lahan.create') }}" class="primary-button" style="width: auto;">Pasang Iklan Lahan</a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="section-header">
            <h2>Jelajahi Kategori</h2>
            <p>Temukan jenis lahan yang sesuai kebutuhan bisnis Anda</p>
        </div>
        
        <div class="categories-grid">
            @php
                $categories = [
                    ['name' => 'Ruko', 'icon' => '🏠', 'color' => '#E3F2FD'],
                    ['name' => 'Kios', 'icon' => '🏪', 'color' => '#E8F5E9'],
                    ['name' => 'Area Pasar', 'icon' => '🛒', 'color' => '#FFF8E1'],
                    ['name' => 'Lahan Terbuka', 'icon' => '🌳', 'color' => '#F1F8E9'],
                    ['name' => 'Gudang', 'icon' => '🏭', 'color' => '#F3E5F5'],
                    ['name' => 'Lainnya', 'icon' => '➕', 'color' => '#E0F7FA']
                ];
            @endphp
            
            @foreach($categories as $category)
            <a href="{{ route('lahan.index', ['kategori' => Str::slug($category['name'])]) }}" class="category-card" style="background-color: {{ $category['color'] }};">
                <div class="category-icon">{{ $category['icon'] }}</div>
                <h3>{{ $category['name'] }}</h3>
                <span class="category-link">Lihat Semua <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                </svg></span>
            </a>
            @endforeach
        </div>
    </section>

    <!-- Featured Properties Section -->
    <section class="featured-section">
        <div class="section-header">
            <h2>Rekomendasi Lahan Terbaik</h2>
            <p>Lahan-lahan pilihan dengan lokasi strategis</p>
        </div>
        
        <div class="properties-grid">
            @forelse ($rekomendasiLahan ?? [] as $lahan)
            <div class="property-card">
                <div class="property-badge">Rekomendasi</div>
                <a href="{{ route('lahan.show', $lahan) }}" class="property-image-link">
                    <img src="{{ $lahan->gambar_utama ? Storage::url($lahan->gambar_utama) : asset('images/default-property.jpg') }}" alt="{{ $lahan->judul }}" class="property-image">
                    <div class="property-overlay">
                        <span>Lihat Detail</span>
                    </div>
                </a>
                <div class="property-details">
                    <h3><a href="{{ route('lahan.show', $lahan) }}">{{ Str::limit($lahan->judul, 50) }}</a></h3>
                    <div class="property-location">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                        </svg>
                        {{ Str::limit($lahan->alamat_lengkap, 30) }}
                    </div>
                    <div class="property-price">Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }}<span>/bulan</span></div>
                    <div class="property-meta">
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                            </svg>
                                {{ $lahan->created_at->diffForHumans() }}
                        </div>
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            {{-- number_format($lahan->averageRating(), 1) --}} ({{-- $lahan->ratings_count --}} ulasan)
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <img src="{{ asset('images/no-properties.svg') }}" alt="No properties" class="empty-image">
                <h3>Belum ada lahan yang tersedia</h3>
                <p>Silakan coba lagi nanti atau pasang iklan lahan Anda</p>
                <a href="{{ route('lahan.create') }}" class="primary-button" style="width: auto;">Pasang Iklan</a>
            </div>
            @endforelse
        </div>
        
        <div class="section-footer">
            <a href="{{ route('lahan.index') }}" class="view-all-button">Lihat Semua Lahan Tersedia</a>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="section-header">
            <h2>Apa Kata Pengguna Kami?</h2>
            <p>Testimonial dari pemilik dan penyewa lahan</p>
        </div>
        
        <div class="testimonials-grid">
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
            <p>Temukan lokasi sempurna atau pasang iklan lahan Anda sekarang juga</p>
            <div class="cta-buttons">
                <a href="{{ route('lahan.index') }}" class="primary-button" style="width: auto;">Cari Lahan</a>
                <a href="{{ route('lahan.create') }}" class="secondary-button" style="width: auto;">Pasang Iklan</a>
            </div>
        </div>
    </section>
</div>
@endsection

<style>
    /* Base Styles */
    :root {
        --primary-color: #00695C;
        --primary-light: #4DB6AC;
        --secondary-color: #FF8F00;
        --dark-color: #263238;
        --light-color: #F5F5F5;
        --gray-color: #757575;
        --light-gray: #E0E0E0;
        --white: #FFFFFF;
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --radius: 8px;
        --transition: all 0.3s ease;
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

    .section-header h2 {
        font-size: 2rem;
        color: var(--dark-color);
        margin-bottom: 10px;
    }

    .section-header p {
        color: var(--gray-color);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #E7F4E5 0%, #B2DFDB 100%);
        border-radius: var(--radius);
        padding: 60px 20px;
        margin: 30px 0 60px;
        text-align: center;
    }

    .hero-title {
        font-size: 2.5rem;
        color: var(--dark-color);
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        color: var(--gray-color);
        max-width: 700px;
        margin: 0 auto 30px;
    }

    /* Search Form */
    .search-form {
        max-width: 700px;
        margin: 0 auto 30px;
    }

    .search-input-group {
        display: flex;
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
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
    }

    .search-input:focus {
        outline: none;
    }

    .search-button {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 0 25px;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
    }

    .search-button:hover {
        background-color: #00897B;
    }

    /* Buttons */
    .primary-button {
        display: inline-block;
        background-color: var(--primary-color);
        color: white;
        padding: 12px 25px;
        border-radius: var(--radius);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .primary-button:hover {
        background-color: #00897B;
        transform: translateY(-2px);
    }

    .secondary-button {
        display: inline-block;
        background-color: var(--white);
        color: var(--primary-color);
        padding: 12px 25px;
        border-radius: var(--radius);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
        border: 1px solid var(--primary-color);
    }

    .secondary-button:hover {
        background-color: rgba(0, 105, 92, 0.1);
        transform: translateY(-2px);
    }

    .hero-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    /* Categories Section */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 60px;
    }

    .category-card {
        padding: 25px 20px;
        border-radius: var(--radius);
        text-align: center;
        transition: var(--transition);
        text-decoration: none;
        color: var(--dark-color);
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
    }

    .category-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .category-card h3 {
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .category-link {
        display: inline-flex;
        align-items: center;
        font-size: 0.9rem;
        color: var(--gray-color);
    }

    .category-link svg {
        margin-left: 5px;
    }

    /* Properties Section */
    .properties-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .property-card {
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: var(--transition);
        position: relative;
    }

    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
    }

    .property-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: var(--secondary-color);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
        z-index: 1;
    }

    .property-image-link {
        display: block;
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .property-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .property-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: var(--transition);
    }

    .property-overlay span {
        color: white;
        font-weight: 500;
    }

    .property-image-link:hover .property-overlay {
        opacity: 1;
    }

    .property-image-link:hover .property-image {
        transform: scale(1.05);
    }

    .property-details {
        padding: 20px;
    }

    .property-details h3 {
        margin: 0 0 10px;
        font-size: 1.1rem;
    }

    .property-details h3 a {
        color: var(--dark-color);
        text-decoration: none;
    }

    .property-details h3 a:hover {
        color: var(--primary-color);
    }

    .property-location {
        display: flex;
        align-items: center;
        color: var(--gray-color);
        font-size: 0.9rem;
        margin-bottom: 15px;
    }

    .property-location svg {
        margin-right: 5px;
    }

    .property-price {
        font-weight: 600;
        font-size: 1.2rem;
        color: var(--primary-color);
        margin-bottom: 15px;
    }

    .property-price span {
        font-size: 0.9rem;
        color: var(--gray-color);
        font-weight: normal;
    }

    .property-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        color: var(--gray-color);
    }

    .meta-item {
        display: flex;
        align-items: center;
    }

    .meta-item svg {
        margin-right: 5px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        grid-column: 1 / -1;
        padding: 40px 0;
    }

    .empty-image {
        max-width: 300px;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: var(--dark-color);
        margin-bottom: 10px;
    }

    .empty-state p {
        color: var(--gray-color);
        margin-bottom: 20px;
    }

    /* Section Footer */
    .section-footer {
        text-align: center;
        margin-bottom: 60px;
    }

    .view-all-button {
        display: inline-block;
        padding: 12px 30px;
        background-color: var(--white);
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
        border-radius: var(--radius);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .view-all-button:hover {
        background-color: rgba(0, 105, 92, 0.1);
    }

    /* Testimonials Section */
    .testimonials-section {
        background-color: #F9F9F9;
        padding: 60px 0;
        margin-bottom: 60px;
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
    }

    .testimonial-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 30px;
        box-shadow: var(--shadow);
    }

    .testimonial-content {
        position: relative;
        margin-bottom: 25px;
    }

    .quote-icon {
        position: absolute;
        top: -15px;
        left: -10px;
        font-size: 3rem;
        color: rgba(0, 105, 92, 0.1);
        font-family: serif;
        line-height: 1;
    }

    .testimonial-content p {
        color: var(--gray-color);
        line-height: 1.6;
        font-style: italic;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
    }

    .author-avatar {
        width: 50px;
        height: 50px;
        background-color: var(--primary-light);
        color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 15px;
    }

    .author-info {
        display: flex;
        flex-direction: column;
    }

    .author-info strong {
        color: var(--dark-color);
    }

    .author-info span {
        color: var(--gray-color);
        font-size: 0.9rem;
    }

    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        border-radius: var(--radius);
        padding: 60px 20px;
        margin-bottom: 60px;
        text-align: center;
        color: white;
    }

    .cta-content h2 {
        font-size: 2rem;
        margin-bottom: 15px;
    }

    .cta-content p {
        max-width: 600px;
        margin: 0 auto 30px;
        opacity: 0.9;
    }

    .cta-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .cta-section .primary-button {
        background-color: white;
        color: var(--primary-color);
    }

    .cta-section .secondary-button {
        background-color: transparent;
        color: white;
        border-color: white;
    }

    .cta-section .secondary-button:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .search-input-group {
            flex-direction: column;
        }
        
        .search-input {
            width: 100%;
            border-radius: var(--radius) var(--radius) 0 0 !important;
        }
        
        .search-button {
            width: 100%;
            padding: 15px;
            border-radius: 0 0 var(--radius) var(--radius) !important;
        }
        
        .hero-actions {
            flex-direction: column;
            gap: 10px;
        }
        
        .primary-button, .secondary-button {
            width: 100%;
            text-align: center;
        }
        
        .categories-grid {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        }
        
        .cta-buttons {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .section-header h2 {
            font-size: 1.5rem;
        }
        
        .property-card {
            width: 100%;
        }
        
        .testimonials-grid {
            grid-template-columns: 1fr;
        }
    }
</style>