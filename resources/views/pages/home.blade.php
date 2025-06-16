@extends('layouts.app')

@section('title', 'Selamat Datang di Lapakku - Temukan Lahan Usaha Impian Anda')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Hero Section --}}
    <div class="relative bg-gradient-to-br from-emerald-50 to-teal-100 py-16 md:py-24 px-4 sm:px-6 lg:px-8 rounded-3xl mb-12 shadow-xl overflow-hidden">
        {{-- Subtle background pattern/illustration could be added here --}}
        <div class="absolute inset-0 bg-pattern opacity-10 pointer-events-none"></div>
        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-emerald-800 mb-4 leading-tight">
                Cari Lahan Usaha Jadi Lebih Mudah
            </h1>
            <p class="text-lg md:text-xl text-gray-700 mb-8 max-w-2xl mx-auto">
                Temukan lokasi strategis terbaik untuk bisnis UMKM Anda, mulai dari ruko, kios, hingga lahan terbuka yang ideal.
            </p>
            <form action="{{ route('lahan.index') }}" method="GET" class="flex max-w-xl mx-auto mb-6 shadow-lg rounded-full overflow-hidden">
                <input type="text" name="search" class="flex-grow px-6 py-3 border-none focus:ring-emerald-500 focus:border-transparent text-gray-700 placeholder-gray-400" placeholder="Cari lahan, ruko, kios, lokasi..." value="{{ request('search') }}">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-8 py-3 transition duration-300 ease-in-out">
                    Cari
                </button>
            </form>
            <a href="{{ route('lahan.index') }}" class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold px-10 py-4 rounded-full shadow-md hover:shadow-lg transition duration-300 ease-in-out">
                Lihat Semua Lahan
            </a>
        </div>
    </div>

    {{-- Kategori Populer --}}
    <section class="mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-emerald-800 text-center mb-10">
            Kategori Populer
        </h2>
        <div class="flex flex-wrap justify-center gap-6">
            {{-- Loop $categories dari controller --}}
            @foreach($categories as $category)
            <div class="category-card w-32 sm:w-40 p-6 bg-white rounded-xl shadow-md hover:shadow-xl transform hover:-translate-y-2 transition duration-300 ease-in-out text-center cursor-pointer">
                <div class="text-5xl mb-4 text-emerald-600">
                    {{ $category['icon'] }} {{-- Assuming this renders an emoji or simple icon --}}
                </div>
                <a href="{{ route('lahan.index', ['tipe_lahan' => $category['value']]) }}" class="text-lg font-semibold text-gray-800 hover:text-emerald-700 block">
                    {{ $category['name'] }}
                </a>
            </div>
            @endforeach
        </div>
    </section>

    {{-- Rekomendasi Lahan --}}
    <section class="mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-emerald-800 text-center mb-10 mt-16">
            Rekomendasi Lahan Untuk Anda
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
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
    <section class="mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-emerald-800 text-center mb-10 mt-16">
            Apa Kata Mereka?
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 flex flex-col justify-between">
                <p class="text-lg italic text-gray-700 leading-relaxed mb-6">
                    "Saya berhasil menemukan tempat usaha yang sangat strategis di Lapakku. Prosesnya juga cepat, aman, dan sangat membantu bisnis saya tumbuh pesat."
                </p>
                <footer class="text-right font-semibold text-gray-900 mt-auto">
                    - Rizky, Pemilik Toko Baju
                </footer>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 flex flex-col justify-between">
                <p class="text-lg italic text-gray-700 leading-relaxed mb-6">
                    "Lapakku benar-benar memudahkan saya untuk memasarkan lahan kosong yang saya miliki. Antarmukanya intuitif dan saya mendapatkan banyak calon penyewa. Sangat membantu!"
                </p>
                <footer class="text-right font-semibold text-gray-900 mt-auto">
                    - Bapak Farros, Pemilik Lahan
                </footer>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
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