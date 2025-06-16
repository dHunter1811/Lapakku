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
                <div class="product-card bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300 flex flex-col">
                    <a href="{{ route('lahan.show', $lahan) }}" class="block overflow-hidden rounded-t-xl">
                        <img src="{{ $lahan->gambar_utama ? Storage::url($lahan->gambar_utama) : 'https://placehold.co/400x250/E5E7EB/4B5563?text=Lapakku' }}" 
                             alt="{{ $lahan->judul }}" 
                             class="w-full h-48 object-cover transition duration-300 hover:scale-105"
                             onerror="this.onerror=null;this.src='https://placehold.co/400x250/E5E7EB/4B5563?text=Lapakku';"
                             >
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="text-xl font-semibold text-gray-900 hover:text-emerald-700 mb-2 h-14 overflow-hidden leading-tight">
                            <a href="{{ route('lahan.show', $lahan) }}" class="block">{{ Str::limit($lahan->judul, 45) }}</a>
                        </h3>
                        <div class="text-2xl font-bold text-emerald-600 mb-2">
                            Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }} / bulan
                        </div>
                        <div class="text-sm text-gray-600 mb-3 flex items-center">
                            <span class="inline-block bg-gray-500 text-white text-xs px-2 py-1 rounded-full font-medium mr-2">{{ $lahan->tipe_lahan }}</span>
                            <svg class="w-4 h-4 text-gray-500 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                            {{ $lahan->lokasi }}
                        </div>
                        <div class="text-sm mb-3 flex items-center text-yellow-500">
                            @if(isset($lahan->ratings_avg_rating) && $lahan->ratings_avg_rating > 0)
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($lahan->ratings_avg_rating))
                                        &#9733; {{-- Filled star --}}
                                    @else
                                        &#9734; {{-- Empty star --}}
                                    @endif
                                @endfor
                                <span class="ml-2 font-semibold text-gray-700">({{ number_format($lahan->ratings_avg_rating, 1) }})</span>
                                <span class="text-gray-500 ml-1">({{ $lahan->ratings_count }} ulasan)</span>
                            @else
                                <span class="text-gray-500">Belum ada ulasan</span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 mb-4">
                            Tayang {{ $lahan->created_at->diffForHumans() }}
                        </div>
                        <a href="{{ route('lahan.show', $lahan) }}" class="mt-auto w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-lg text-center transition duration-300 ease-in-out shadow-md hover:shadow-lg">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-8 rounded-xl shadow-lg text-center text-gray-600">
                    <p class="text-lg">Belum ada lahan yang direkomendasikan saat ini.</p>
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
    /* Custom CSS for patterns or specific overrides if needed */
    body {
        font-family: 'Inter', sans-serif;
        @apply bg-gray-50 text-gray-800; /* Apply default background and text color */
    }

    /* Subtle background pattern for hero section */
    .bg-pattern {
        background-image: radial-gradient(circle at center, rgba(0, 121, 107, 0.05) 1px, transparent 1px);
        background-size: 20px 20px;
    }

    /* Basic responsiveness for inputs if not fully covered by Tailwind */
    input[type="text"].focus\:ring-emerald-500:focus {
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.45); /* Equivalent of ring-2 and ring-emerald-500 */
    }

    /* Hide scrollbar for overflow-hidden elements but allow content to be there */
    .h-14 {
        line-height: 1.2; /* Adjust line-height for better text wrapping */
    }

    /* Ensure a smooth transition on images when hovered */
    .product-card img {
        transition: transform 0.3s ease-in-out;
    }
    
</style>
@endpush
