@extends('layouts.app')

@section('title', 'Selamat Datang di Lapakku')

@section('content')
<div class="container">
    {{-- Hero Section --}}
    <div style="background-color: #e7f4e5; padding: 40px 20px; text-align: center; border-radius: 8px; margin-bottom: 30px;">
        <h1 style="color: #00695C; font-size: 2.5em; margin-bottom: 10px;">Cari Lahan Usaha Jadi Lebih Mudah</h1>
        <p style="font-size: 1.2em; color: #333; margin-bottom: 20px;">Temukan lokasi strategis untuk bisnis UMKM Anda, mulai dari ruko, kios, hingga lahan terbuka.</p>
        <form action="{{ route('lahan.index') }}" method="GET" class="form-group" style="max-width: 600px; margin: 0 auto 20px auto; display:flex;">
            <input type="text" name="search" class="filter-control" placeholder="Cari lahan, ruko, kios..." style="flex-grow:1; border-radius: 4px 0 0 4px; padding: .5rem .75rem; font-size: 1rem; border: 1px solid #ced4da;">
            <button type="submit" class="btn btn-primary" style="border-radius: 0 4px 4px 0; background-color:#00796B; border-color:#00796B; padding: .5rem 1rem;">Cari</button>
        </form>
        <a href="{{ route('lahan.index') }}" class="btn btn-secondary" style="background-color:#6c757d; border-color:#6c757d; color:white;">Lihat Semua Lahan</a>
    </div>

    {{-- Kategori Populer --}}
    <section class="mb-3">
        <h2 style="color: #00695C; text-align:center; margin-bottom:20px; font-size:1.8em;">Kategori Populer</h2>
        <div style="display: flex; justify-content: space-around; text-align: center; flex-wrap:wrap;">
            {{-- Loop $categories dari controller --}}
            @foreach($categories as $category)
            <div class="category-card" style="margin: 10px; padding:15px; background-color:white; border-radius:8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); width:150px; min-width:130px;">
                <div style="font-size: 2.5em; margin-bottom: 8px; color: #00796B;">{{ $category['icon'] }}</div>
                {{-- Menggunakan $category['value'] untuk parameter tipe_lahan --}}
                <a href="{{ route('lahan.index', ['tipe_lahan' => $category['value']]) }}" style="color: #333; text-decoration:none; font-weight:500;">{{ $category['name'] }}</a>
            </div>
            @endforeach
        </div>
    </section>

    {{-- Rekomendasi Lahan --}}
    <section class="mb-3">
        <h2 style="color: #00695C; text-align:center; margin-bottom:20px; margin-top: 40px; font-size:1.8em;">Rekomendasi Lahan Untuk Anda</h2>
        <div class="product-grid">
            @forelse ($rekomendasiLahan ?? [] as $lahan)
                <div class="product-card">
                    <a href="{{ route('lahan.show', $lahan) }}">
                        <img src="{{ $lahan->gambar_utama ? Storage::url($lahan->gambar_utama) : 'https://via.placeholder.com/300x200.png?text=Lapakku' }}" alt="{{ $lahan->judul }}">
                    </a>
                    <div class="product-card-content">
                        <h3><a href="{{ route('lahan.show', $lahan) }}" style="text-decoration:none; color: #333;">{{ Str::limit($lahan->judul, 45) }}</a></h3>
                        <div class="price">Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }} / bulan</div>
                        <div class="location" style="font-size:0.85em; color:#555; margin-bottom: 5px;">
                             <span class="badge-tipe">{{ $lahan->tipe_lahan }}</span> - {{ $lahan->lokasi }}
                        </div>
                        <div class="rating" style="font-size:0.9em; margin-bottom: 5px; color: #E67E22;">
                            @if(isset($lahan->ratings_avg_rating) && $lahan->ratings_avg_rating > 0)
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($lahan->ratings_avg_rating))
                                        ★ <!-- Bintang terisi -->
                                    @else
                                        ☆ <!-- Bintang kosong -->
                                    @endif
                                @endfor
                                ({{ number_format($lahan->ratings_avg_rating, 1) }})
                                <span style="color:#777; font-size:0.9em;">- {{ $lahan->ratings_count }} ulasan</span>
                            @else
                                <span style="color:#777;">Belum ada ulasan</span>
                            @endif
                        </div>
                        <div class="time" style="font-size:0.8em; color:#777;">Tayang {{ $lahan->created_at->diffForHumans() }}</div>
                        <a href="{{ route('lahan.show', $lahan) }}" class="btn btn-primary btn-sm" style="width:100%; text-align:center; margin-top:10px; background-color:#00796B; border-color:#00796B;">Lihat Detail</a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align:center; padding: 20px;" class="card">
                    <p>Belum ada lahan yang direkomendasikan saat ini.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Apa Kata Mereka (Testimonial) --}}
    <section class="mb-3">
        <h2 style="color: #00695C; text-align:center; margin-bottom:20px; margin-top: 40px; font-size:1.8em;">Apa Kata Mereka?</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            <div class="card" style="padding:20px;">
                <p style="font-style: italic; color: #555;">"Saya berhasil menemukan tempat usaha yang strategis di sini, prosesnya juga cepat dan aman."</p>
                <footer style="font-weight: bold; color: #333; text-align:right; margin-top:10px;">- Rizky, Pemilik Toko Baju</footer>
            </div>
            <div class="card" style="padding:20px;">
                <p style="font-style: italic; color: #555;">"Lapakku memudahkan saya untuk memasarkan lahan kosong yang saya miliki, sangat membantu!"</p>
                <footer style="font-weight: bold; color: #333; text-align:right; margin-top:10px;">- Bapak Farros, Pemilik Lahan</footer>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    /* Anda mungkin sudah memiliki style ini dari halaman index, pastikan konsisten */
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
    .product-card { border: 1px solid #eee; border-radius: 8px; overflow: hidden; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.07); display: flex; flex-direction: column; }
    .product-card img { width: 100%; height: 180px; object-fit: cover; }
    .product-card-content { padding: 15px; display: flex; flex-direction: column; flex-grow: 1; }
    .product-card-content h3 { margin-top: 0; font-size: 1.1em; margin-bottom: 8px; height: 40px; overflow:hidden; line-height: 1.2; }
    .product-card-content .price { font-weight: bold; color: #00796B; margin-bottom: 5px; }
    .product-card-content .location { margin-bottom: 5px; }
    .badge-tipe { display: inline-block; padding: .25em .6em; font-size: 75%; font-weight: 700; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .25rem; background-color: #6c757d; color: white; }
    .btn-sm { padding: .3rem .6rem; font-size: .875rem; }
    .category-card:hover { transform: translateY(-3px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.2s ease-in-out; }
</style>
@endpush
