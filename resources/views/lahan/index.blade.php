@extends('layouts.app')

@section('title', 'Daftar Lahan Tersedia - Lapakku')

@section('content')
<div class="container">
    <h1 style="color: #00695C; text-align:center; margin-bottom: 25px; margin-top: 20px; font-size:2em;">Temukan Lahan Impian Anda</h1>

    <div class="card mb-4 filter-card">
        <form action="{{ route('lahan.index') }}" method="GET" id="filterForm">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="search" class="filter-label">Kata Kunci</label>
                    <input type="text" name="search" id="search" class="filter-control" placeholder="Nama lahan, alamat..." value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <label for="tipe_lahan" class="filter-label">Tipe Lahan</label>
                    <select name="tipe_lahan" id="tipe_lahan" class="filter-control">
                        <option value="">Semua Tipe</option>
                        <option value="Ruko" {{ request('tipe_lahan') == 'Ruko' ? 'selected' : '' }}>Ruko</option>
                        <option value="Kios" {{ request('tipe_lahan') == 'Kios' ? 'selected' : '' }}>Kios</option>
                        <option value="Pasar" {{ request('tipe_lahan') == 'Pasar' ? 'selected' : '' }}>Tempat di Pasar</option>
                        <option value="Lahan Terbuka" {{ request('tipe_lahan') == 'Lahan Terbuka' ? 'selected' : '' }}>Lahan Terbuka</option>
                        <option value="Lainnya" {{ request('tipe_lahan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="lokasi" class="filter-label">Lokasi</label>
                    <select name="lokasi" id="lokasi" class="filter-control">
                        <option value="">Semua Lokasi</option>
                        <option value="Banjarmasin Selatan" {{ request('lokasi') == 'Banjarmasin Selatan' ? 'selected' : '' }}>Banjarmasin Selatan</option>
                        <option value="Banjarmasin Timur" {{ request('lokasi') == 'Banjarmasin Timur' ? 'selected' : '' }}>Banjarmasin Timur</option>
                        <option value="Banjarmasin Barat" {{ request('lokasi') == 'Banjarmasin Barat' ? 'selected' : '' }}>Banjarmasin Barat</option>
                        <option value="Banjarmasin Tengah" {{ request('lokasi') == 'Banjarmasin Tengah' ? 'selected' : '' }}>Banjarmasin Tengah</option>
                        <option value="Banjarmasin Utara" {{ request('lokasi') == 'Banjarmasin Utara' ? 'selected' : '' }}>Banjarmasin Utara</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sort_by" class="filter-label">Urutkan</label>
                    <select name="sort_by" id="sort_by" class="filter-control">
                        <option value="terbaru" {{ request('sort_by') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="termurah" {{ request('sort_by') == 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                        <option value="termahal" {{ request('sort_by') == 'termahal' ? 'selected' : '' }}>Harga Termahal</option>
                    </select>
                </div>

                <div class="filter-group-button">
                    <button type="submit" class="btn btn-primary btn-filter">Filter</button>
                    <a href="{{ route('lahan.index') }}" class="btn btn-secondary btn-reset">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="search-results-info">
        @if(isset($lahanList) && $lahanList->total() > 0)
            <p>Menampilkan <strong>{{ $lahanList->firstItem() }}</strong>-<strong>{{ $lahanList->lastItem() }}</strong> dari <strong>{{ $lahanList->total() }}</strong> hasil ditemukan.</p>
        @endif
    </div>

    <div class="product-grid">
        @forelse ($lahanList ?? [] as $lahan)
            <div class="product-card">
                 <a href="{{ route('lahan.show', $lahan) }}" class="product-card-image-link">
                    <img src="{{ $lahan->gambar_utama ? Storage::url($lahan->gambar_utama) : 'https://placehold.co/400x300/e2e8f0/94a3b8?text=Lapakku' }}" alt="{{ $lahan->judul }}">
                 </a>
                <div class="product-card-content">
                    <div class="location">
                        <span class="badge-tipe">{{ $lahan->tipe_lahan }}</span> {{ $lahan->lokasi }}
                    </div>
                    <h3><a href="{{ route('lahan.show', $lahan) }}">{{ Str::limit($lahan->judul, 45) }}</a></h3>
                    <div class="price">Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }} / bulan</div>
                    
                    {{-- === BAGIAN RATING DITAMBAHKAN DI SINI === --}}
                    <div class="rating">
                        @if($lahan->ratings_count > 0)
                            <span class="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($lahan->ratings_avg_rating))
                                        ★ <!-- Bintang terisi -->
                                    @else
                                        ☆ <!-- Bintang kosong -->
                                    @endif
                                @endfor
                            </span>
                            <span class="rating-text">
                                {{ number_format($lahan->ratings_avg_rating, 1) }} ({{ $lahan->ratings_count }} ulasan)
                            </span>
                        @else
                            <span class="rating-text no-rating">Belum ada ulasan</span>
                        @endif
                    </div>
                    {{-- ======================================= --}}

                    <div class="time">Tayang {{ $lahan->created_at->diffForHumans() }}</div>
                     <a href="{{ route('lahan.show', $lahan) }}" class="btn btn-primary btn-sm btn-detail">Lihat Detail</a>
                </div>
            </div>
        @empty
            <div class="empty-state-card">
                <p><strong>Tidak ada lahan yang ditemukan.</strong></p>
                <p>Coba ubah atau reset filter pencarian Anda.</p>
                <a href="{{ route('lahan.index') }}" class="btn btn-secondary mt-3">Reset Filter</a>
            </div>
        @endforelse
    </div>

    @if(isset($lahanList) && $lahanList->hasPages())
    <div class="pagination-container">
        {{ $lahanList->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Styling untuk form filter */
    .filter-card { padding: 20px 25px; background-color: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; }
    .filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 18px; align-items: flex-end; }
    .filter-label { display: block; margin-bottom: .4rem; font-size: 0.85em; color: #555; font-weight: 500; }
    .filter-control { width: 100%; padding: .5rem .75rem; font-size: 0.95rem; border: 1px solid #ced4da; border-radius: 6px; box-sizing: border-box; }
    .filter-group-button { display: flex; gap: 10px; }
    .btn-filter, .btn-reset { flex-grow: 1; padding: .5rem .75rem; font-size: 0.95rem; color: white; border: none; border-radius: 6px; cursor: pointer; text-align: center; text-decoration: none; }
    .btn-filter { background-color: #00796B; } .btn-filter:hover { background-color: #00695C; }
    .btn-reset { background-color: #6c757d; } .btn-reset:hover { background-color: #5a6268; }
    .search-results-info { margin-bottom: 20px; font-size: 0.95em; color: #64748b; }

    /* === PERBAIKAN GRID CARD LAHAN === */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Ukuran kartu disesuaikan */
        gap: 25px;
        /* Hapus justify-content: center; agar rata kiri-kanan jika tidak penuh */
    }
    .product-card {
        border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; background: white;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -1px rgba(0,0,0,0.04);
        display:flex; flex-direction:column;
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }
    .product-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        transform: translateY(-3px);
    }
    /* ============================== */

    .product-card-image-link { display: block; }
    .product-card img { width: 100%; height: 200px; object-fit: cover; }
    .product-card-content { padding: 18px; flex-grow:1; display:flex; flex-direction:column; }
    .product-card-content h3 { margin-top: 5px; font-size: 1.1em; margin-bottom: 10px; color:#334155; line-height:1.3; height:auto; min-height:44px; }
    .product-card-content h3 a {text-decoration:none; color:inherit;}
    .product-card-content .price { font-weight: 700; font-size:1.1em; color: #00796B; margin-bottom: 8px; }
    .product-card-content .location { margin-bottom: 5px; font-size: 0.85em; color:#555; }
    .badge-tipe { display: inline-block; padding: .3em .6em; font-size: 75%; font-weight: 600; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .25rem; background-color: #6c757d; color: white; }

    /* === CSS BARU UNTUK RATING === */
    .product-card-content .rating {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9em;
        color: #64748b;
        margin-bottom: 8px;
    }
    .rating-stars {
        color: #f59e0b; /* Warna kuning bintang */
        font-size: 1.1em;
        line-height: 1;
    }
    .rating-text.no-rating {
        font-style: italic;
    }
    /* ============================ */

    .product-card-content .time { font-size: 0.8em; color: #777; margin-top: auto; padding-top: 10px; }
    .product-card-content .btn-detail { width:100%; text-align:center; margin-top:12px; font-size:0.9em; padding: 8px 10px;}
    .empty-state-card { grid-column: 1 / -1; text-align: center; padding: 40px; background-color: #f8fafc; border: 1px dashed #d1d5db; border-radius: 8px; }
    .pagination-container { margin-top: 30px; display: flex; justify-content: center; }
</style>
@endpush
