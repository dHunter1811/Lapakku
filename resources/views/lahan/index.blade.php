@extends('layouts.app')

@section('title', 'Daftar Lahan Tersedia - Lapakku')

@section('content')
<div class="property-listing-container">
    <!-- Hero Section -->
    <section class="listing-hero">
        <div class="container">
            <h1 class="hero-title">Temukan Lahan Usaha Ideal Anda</h1>
            <p class="hero-subtitle">Jelajahi berbagai pilihan lokasi strategis di Banjarmasin</p>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="container">
            <div class="filter-card">
                <form action="{{ route('lahan.index') }}" method="GET" id="filterForm">
                    <div class="filter-grid">
                        <!-- Search Input -->
                        <div class="filter-group">
                            <div class="input-with-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input type="text" name="search" id="search" placeholder="Cari nama lahan, alamat..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Property Type -->
                        <div class="filter-group">
                            <div class="select-wrapper">
                                <select name="tipe_lahan" id="tipe_lahan">
                                    <option value="">Semua Tipe</option>
                                    <option value="Ruko" {{ request('tipe_lahan') == 'Ruko' ? 'selected' : '' }}>Ruko</option>
                                    <option value="Kios" {{ request('tipe_lahan') == 'Kios' ? 'selected' : '' }}>Kios</option>
                                    <option value="Pasar" {{ request('tipe_lahan') == 'Pasar' ? 'selected' : '' }}>Tempat di Pasar</option>
                                    <option value="Lahan Terbuka" {{ request('tipe_lahan') == 'Lahan Terbuka' ? 'selected' : '' }}>Lahan Terbuka</option>
                                    <option value="Lainnya" {{ request('tipe_lahan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="filter-group">
                            <div class="select-wrapper">
                                <select name="lokasi" id="lokasi">
                                    <option value="">Semua Lokasi</option>
                                    <option value="Banjarmasin Selatan" {{ request('lokasi') == 'Banjarmasin Selatan' ? 'selected' : '' }}>Banjarmasin Selatan</option>
                                    <option value="Banjarmasin Timur" {{ request('lokasi') == 'Banjarmasin Timur' ? 'selected' : '' }}>Banjarmasin Timur</option>
                                    <option value="Banjarmasin Barat" {{ request('lokasi') == 'Banjarmasin Barat' ? 'selected' : '' }}>Banjarmasin Barat</option>
                                    <option value="Banjarmasin Tengah" {{ request('lokasi') == 'Banjarmasin Tengah' ? 'selected' : '' }}>Banjarmasin Tengah</option>
                                    <option value="Banjarmasin Utara" {{ request('lokasi') == 'Banjarmasin Utara' ? 'selected' : '' }}>Banjarmasin Utara</option>
                                </select>
                                <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                        </div>

                        <!-- Sort -->
                        <div class="filter-group">
                            <div class="select-wrapper">
                                <select name="sort_by" id="sort_by">
                                    <option value="terbaru" {{ request('sort_by') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="termurah" {{ request('sort_by') == 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                                    <option value="termahal" {{ request('sort_by') == 'termahal' ? 'selected' : '' }}>Harga Termahal</option>
                                </select>
                                <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-filter">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="4" y1="21" x2="4" y2="14"></line>
                                    <line x1="4" y1="10" x2="4" y2="3"></line>
                                    <line x1="12" y1="21" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12" y2="3"></line>
                                    <line x1="20" y1="21" x2="20" y2="16"></line>
                                    <line x1="20" y1="12" x2="20" y2="3"></line>
                                    <line x1="1" y1="14" x2="7" y2="14"></line>
                                    <line x1="9" y1="8" x2="15" y2="8"></line>
                                    <line x1="17" y1="16" x2="23" y2="16"></line>
                                </svg>
                                Terapkan Filter
                            </button>
                            <a href="{{ route('lahan.index') }}" class="btn btn-reset">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10"></polyline>
                                    <polyline points="23 20 23 14 17 14"></polyline>
                                    <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                                </svg>
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Results Section -->
    <section class="results-section">
        <div class="container">
            @if(isset($lahanList) && $lahanList->total() > 0)
            <div class="results-info">
                <p>Menampilkan <span>{{ $lahanList->firstItem() }}-{{ $lahanList->lastItem() }}</span> dari <span>{{ $lahanList->total() }}</span> properti</p>
            </div>
            @endif

            <div class="property-grid">
                @forelse ($lahanList ?? [] as $lahan)
                <div class="property-card">
                    <div class="property-badge">{{ $lahan->tipe_lahan }}</div>
                    <div class="property-image-container">
                        <a href="{{ route('lahan.show', $lahan) }}" class="product-card-image-link">
                            <img src="{{ $lahan->gambar_utama ? Storage::url($lahan->gambar_utama) : 'https://placehold.co/400x300/e2e8f0/94a3b8?text=Lapakku' }}" alt="{{ $lahan->judul }}">
                        </a>
                        <button class="favorite-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="property-details">
                        <div class="property-location">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            {{ $lahan->lokasi }}
                        </div>
                        <h3 class="property-title">
                            <a href="{{ route('lahan.show', $lahan) }}">{{ Str::limit($lahan->judul, 45) }}</a>
                        </h3>
                        <div class="property-price">
                            Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }} <span>/bulan</span>
                        </div>

                        <div class="property-rating">
                            @if($lahan->ratings_count > 0)
                            <div class="stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <=round($lahan->ratings_avg_rating))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#FFC107" stroke="#FFC107" stroke-width="1">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#E0E0E0" stroke-width="1">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                    @endif
                                    @endfor
                            </div>
                            <span class="rating-text">{{ number_format($lahan->ratings_avg_rating, 1) }} ({{ $lahan->ratings_count }} ulasan)</span>
                            @else
                            <span class="no-rating">Belum ada ulasan</span>
                            @endif
                        </div>

                        <div class="property-footer">
                            <span class="time-posted">Tayang {{ $lahan->created_at->diffForHumans() }}</span>
                            <a href="{{ route('lahan.show', $lahan) }}" class="btn btn-detail">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <img src="{{ asset('images/no-results.svg') }}" alt="No results found">
                    <h3>Tidak ada lahan yang ditemukan</h3>
                    <p>Coba ubah kriteria pencarian Anda atau <a href="{{ route('lahan.index') }}">reset filter</a></p>
                </div>
                @endforelse
            </div>

            @if(isset($lahanList) && $lahanList->hasPages())
            <div class="pagination-wrapper">
                {{ $lahanList->appends(request()->query())->links('pagination::custom') }}
            </div>
            @endif
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    :root {
        --primary: #00796B;
        --primary-dark: #00695C;
        --primary-light: #B2DFDB;
        --accent: #FFC107;
        --text: #2D3748;
        --text-light: #4A5568;
        --text-lighter: #718096;
        --background: #F8FAFC;
        --white: #FFFFFF;
        --gray-100: #EDF2F7;
        --gray-200: #E2E8F0;
        --gray-300: #CBD5E0;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
        --radius-sm: 4px;
        --radius-md: 8px;
        --radius-lg: 12px;
        --radius-xl: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Base Styles */
    .property-listing-container {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--text);
        line-height: 1.6;
    }

    /* Hero Section */
    .listing-hero {
        background: linear-gradient(rgba(0, 121, 107, 0.9), rgba(0, 105, 92, 0.9)),
        url('{{ asset(' images/city-bg.jpg') }}');
        background-size: cover;
        background-position: center;
        color: var(--white);
        padding: 80px 0;
        text-align: center;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        max-width: 700px;
        margin: 0 auto;
    }

    /* Filter Section */
    .filter-section {
        padding: 40px 0 20px;
        background-color: var(--white);
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: var(--shadow-sm);
    }

    .filter-card {
        background-color: var(--white);
        border-radius: var(--radius-md);
        padding: 20px;
        box-shadow: var(--shadow-md);
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        align-items: flex-end;
    }

    .input-with-icon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-with-icon svg {
        position: absolute;
        left: 12px;
        color: var(--text-light);
    }

    .input-with-icon input {
        width: 100%;
        padding: 12px 16px 12px 40px;
        border: 1px solid var(--gray-300);
        border-radius: var(--radius-md);
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .input-with-icon input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 121, 107, 0.1);
    }

    .select-wrapper {
        position: relative;
    }

    .select-wrapper select {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid var(--gray-300);
        border-radius: var(--radius-md);
        appearance: none;
        font-size: 0.95rem;
        background-color: var(--white);
        cursor: pointer;
    }

    .select-arrow {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .filter-actions {
        display: flex;
        gap: 12px;
    }

    .btn {
        padding: 12px 20px;
        border-radius: var(--radius-md);
        font-weight: 500;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: var(--transition);
        border: none;
    }

    .btn-filter {
        background-color: var(--primary);
        color: var(--white);
        flex: 1;
    }

    .btn-filter:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
    }

    .btn-reset {
        background-color: var(--gray-100);
        color: var(--text);
        flex: 1;
    }

    .btn-reset:hover {
        background-color: var(--gray-200);
        transform: translateY(-2px);
    }

    /* Results Section */
    .results-section {
        padding: 40px 0 80px;
        background-color: var(--background);
    }

    .results-info {
        margin-bottom: 24px;
        color: var(--text-light);
        font-size: 0.95rem;
    }

    .results-info span {
        font-weight: 600;
        color: var(--text);
    }

    /* Property Grid */
    .property-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }

    .property-card {
        background-color: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        position: relative;
    }

    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .property-badge {
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

    .property-image-container {
        position: relative;
        padding-top: 75%;
        /* 4:3 aspect ratio */
        overflow: hidden;
    }

    .property-image-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .property-card:hover .property-image-container img {
        transform: scale(1.05);
    }

    .favorite-button {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 36px;
        height: 36px;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        color: var(--text-light);
        box-shadow: var(--shadow-sm);
        z-index: 2;
    }

    .favorite-button:hover {
        background-color: var(--white);
        color: var(--primary);
        transform: scale(1.1);
    }

    .property-details {
        padding: 20px;
    }

    .property-location {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--text-light);
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .property-location svg {
        color: var(--primary);
    }

    .property-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 12px;
        line-height: 1.4;
    }

    .property-title a {
        color: inherit;
        text-decoration: none;
        transition: var(--transition);
    }

    .property-title a:hover {
        color: var(--primary);
    }

    .property-price {
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--primary);
        margin-bottom: 12px;
    }

    .property-price span {
        font-size: 0.9rem;
        font-weight: 400;
        color: var(--text-light);
    }

    .property-rating {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
    }

    .stars {
        display: flex;
        gap: 2px;
    }

    .rating-text {
        font-size: 0.85rem;
        color: var(--text-light);
    }

    .no-rating {
        font-size: 0.85rem;
        color: var(--text-light);
        font-style: italic;
    }

    .property-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid var(--gray-200);
    }

    .time-posted {
        font-size: 0.8rem;
        color: var(--text-light);
    }

    .btn-detail {
        background-color: var(--primary);
        color: var(--white);
        padding: 8px 16px;
        font-size: 0.9rem;
        border-radius: var(--radius-sm);
    }

    .btn-detail:hover {
        background-color: var(--primary-dark);
    }

    /* Empty State */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state img {
        max-width: 300px;
        margin-bottom: 24px;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        margin-bottom: 12px;
        color: var(--text);
    }

    .empty-state p {
        color: var(--text-light);
        margin-bottom: 0;
    }

    .empty-state a {
        color: var(--primary);
        font-weight: 500;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 40px;
    }

    /* Responsive Adjustments */
    @media (max-width: 1024px) {
        .filter-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            margin-top: 8px;
        }

        .property-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }

    @media (max-width: 480px) {
        .listing-hero {
            padding: 60px 0;
        }

        .hero-title {
            font-size: 1.8rem;
        }

        .property-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Favorite button functionality
        document.querySelectorAll('.favorite-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const isPressed = this.getAttribute('aria-pressed') === 'true';
                this.setAttribute('aria-pressed', !isPressed);
                this.classList.toggle('active', !isPressed);
                console.log('Favorite toggled for:', this.closest('.property-card').querySelector('.property-title a').textContent);
            });
        });

        // Filter form submission enhancements (no changes needed for basic functionality)
        const filterForm = document.getElementById('filterForm');
        if (filterForm) {
            filterForm.addEventListener('submit', function(e) {});
        }
    });
</script>
@endpush