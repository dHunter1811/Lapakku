@extends('layouts.app')

@section('title', 'Selamat Datang di Lapakku')

@section('content')
<div class="container">
    <div style="background-color: #e7f4e5; padding: 40px 20px; text-align: center; border-radius: 8px; margin-bottom: 30px;">
        <h1 style="color: #00695C; font-size: 2.5em; margin-bottom: 10px;">Cari Lahan Usaha Jadi Lebih Mudah</h1>
        <p style="font-size: 1.2em; color: #333; margin-bottom: 20px;">Temukan lokasi strategis untuk bisnis UMKM Anda, mulai dari ruko, kios, hingga lahan terbuka.</p>
        <form action="{{ route('lahan.index') }}" method="GET" class="form-group" style="max-width: 600px; margin: 0 auto 20px auto; display:flex;">
            <input type="text" name="search" placeholder="Cari lahan, ruko, kios..." style="flex-grow:1; border-radius: 4px 0 0 4px;">
            <button type="submit" class="btn btn-primary" style="border-radius: 0 4px 4px 0;">Cari</button>
        </form>
        <a href="{{ route('lahan.index') }}" class="btn btn-secondary">Lihat Semua Lahan</a>
    </div>

    <section class="mb-3">
        <h2 style="color: #00695C; text-align:center; margin-bottom:20px;">Kategori Populer</h2>
        <div style="display: flex; justify-content: space-around; text-align: center; flex-wrap:wrap;">
            @php
                $categories = [
                    ['name' => 'Ruko', 'icon' => '🏠'],
                    ['name' => 'Kios', 'icon' => '🏪'],
                    ['name' => 'Pasar', 'icon' => '🛒'],
                    ['name' => 'Lahan Terbuka', 'icon' => '🌳'],
                    ['name' => 'Lainnya', 'icon' => '➕']
                ];
            @endphp
            @foreach($categories as $category)
            <div style="margin: 10px; padding:15px; background-color:white; border-radius:8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); width:150px;">
                <div style="font-size: 2em; margin-bottom: 5px;">{{ $category['icon'] }}</div>
                <a href="{{ route('lahan.index', ['kategori' => Str::slug($category['name'])]) }}" style="color: #333; text-decoration:none;">{{ $category['name'] }}</a>
            </div>
            @endforeach
        </div>
    </section>

    <section class="mb-3">
        <h2 style="color: #00695C; text-align:center; margin-bottom:20px;">Rekomendasi Lahan Untuk Anda</h2>
        <div class="product-grid">
            @forelse ($rekomendasiLahan ?? [] as $lahan)
                <div class="product-card">
                    <a href="{{ route('lahan.show', $lahan) }}">
                        <img src="{{ $lahan->gambar_utama ? Storage::url($lahan->gambar_utama) : 'https://via.placeholder.com/300x200.png?text=Lapakku' }}" alt="{{ $lahan->judul }}">
                    </a>
                    <div class="product-card-content">
                        <h3><a href="{{ route('lahan.show', $lahan) }}" style="text-decoration:none; color: #333;">{{ Str::limit($lahan->judul, 50) }}</a></h3>
                        <div class="price">Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }} / bulan</div>
                        <div class="location">{{ Str::limit($lahan->alamat_lengkap, 30) }}</div>
                        <div class="rating">⭐ {{-- number_format($lahan->averageRating(), 1) --}} ({{-- $lahan->ratings_count --}} ulasan)</div>
                        <div class="time">Tayang {{ $lahan->created_at->diffForHumans() }}</div>
                        <a href="{{ route('lahan.show', $lahan) }}" class="btn btn-primary btn-sm" style="width:100%; text-align:center; margin-top:10px;">Lihat Detail</a>
                    </div>
                </div>
            @empty
                <p>Belum ada lahan yang direkomendasikan saat ini.</p>
            @endforelse
        </div>
    </section>

    <section class="mb-3">
        <h2 style="color: #00695C; text-align:center; margin-bottom:20px;">Apa Kata Mereka?</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            <div class="card">
                <p>"Saya berhasil menemukan tempat usaha yang strategis di sini, prosesnya juga cepat dan aman."</p>
                <footer style="font-weight: bold; color: #555;">- Rizky, Pemilik Toko Baju</footer>
            </div>
            <div class="card">
                <p>"Lapakku memudahkan saya untuk memasarkan lahan kosong yang saya miliki, sangat membantu!"</p>
                <footer style="font-weight: bold; color: #555;">- Bapak Farros, Pemilik Lahan</footer>
            </div>
            {{-- Tambahkan testimonial lain jika ada --}}
        </div>
    </section>
</div>
@endsection