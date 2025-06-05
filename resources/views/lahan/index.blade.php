@extends('layouts.app')

@section('title', 'Daftar Lahan Tersedia - Lapakku')

@section('content')
<div class="container">
    <h1 style="color: #00695C; text-align:center; margin-bottom: 25px; margin-top: 20px; font-size:2em;">Temukan Lahan Impian Anda</h1>

    <div class="card mb-4" style="padding: 20px 25px; background-color: #f8f9fa; border-radius: 8px;">
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

                {{-- Modifikasi di sini untuk tombol Filter dan Reset --}}
                <div class="filter-group-button">
                    <button type="submit" class="btn btn-primary btn-filter">Filter</button>
                    <a href="{{ route('lahan.index') }}" class="btn btn-secondary btn-reset">Reset</a>
                </div>
            </div>
        </form>
    </div>

    {{-- ... kode untuk menampilkan $lahanList ... --}}
    <div class="product-grid">
        @forelse ($lahanList ?? [] as $lahan)
            <div class="product-card">
                 <a href="{{ route('lahan.show', $lahan) }}">
                    <img src="{{ $lahan->gambar_utama ? Storage::url($lahan->gambar_utama) : 'https://via.placeholder.com/300x200.png?text=Lapakku' }}" alt="{{ $lahan->judul }}">
                 </a>
                <div class="product-card-content">
                    <h3><a href="{{ route('lahan.show', $lahan) }}" style="text-decoration:none; color: #333;">{{ Str::limit($lahan->judul, 45) }}</a></h3>
                    <div class="price">Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }} / bulan</div>
                    <div class="location" style="font-size:0.85em; color:#555;">
                        <span class="badge-tipe">{{ $lahan->tipe_lahan }}</span> - {{ $lahan->lokasi }}
                    </div>
                    <div class="time" style="font-size:0.8em; color:#777;">Tayang {{ $lahan->created_at->diffForHumans() }}</div>
                     <a href="{{ route('lahan.show', $lahan) }}" class="btn btn-primary btn-sm" style="width:100%; text-align:center; margin-top:10px;">Lihat Detail</a>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px;" class="card">
                <p>Tidak ada lahan yang ditemukan sesuai kriteria Anda.</p>
                <a href="{{ route('lahan.index') }}" class="btn btn-secondary">Lihat Semua Lahan</a>
            </div>
        @endforelse
    </div>

    @if(isset($lahanList) && $lahanList->hasPages())
    <div style="margin-top: 30px; display: flex; justify-content: center;">
        {{ $lahanList->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .filter-grid {
        display: grid;
        /* Membuat kolom terakhir (untuk tombol) memiliki lebar yang cukup untuk dua tombol jika perlu,
           atau Anda bisa membuat kolom tombol ini span lebih dari satu kolom grid jika diperlukan.
           Untuk auto-fit, kita bisa biarkan dan atur tombol di dalam filter-group-button dengan flexbox.
        */
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
        align-items: flex-end;
    }

    .filter-label {
        display: block;
        margin-bottom: .3rem;
        font-size: 0.9em;
        color: #555;
        font-weight: 500;
    }

    .filter-control {
        width: 100%;
        padding: .5rem .75rem;
        font-size: 0.95rem;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        box-sizing: border-box;
    }

    .filter-group-button {
        display: flex; /* Menggunakan flexbox untuk menata tombol */
        gap: 10px; /* Jarak antara tombol Filter dan Reset */
        /* Jika filter-grid membuat kolom ini terlalu sempit, Anda mungkin perlu:
           grid-column: span 2; (jika Anda ingin kolom tombol ini mengambil 2 slot grid)
           atau sesuaikan minmax pada grid-template-columns
        */
    }

    .btn-filter, .btn-reset {
        flex-grow: 1; /* Membuat kedua tombol berbagi ruang secara merata */
        padding: .5rem .75rem;
        font-size: 0.95rem;
        color: white;
        border: none;
        border-radius: .25rem;
        cursor: pointer;
        text-align: center; /* Untuk tag <a> yang dijadikan tombol */
        text-decoration: none; /* Untuk tag <a> */
    }

    .btn-filter {
        background-color: #00796B;
    }
    .btn-filter:hover {
        background-color: #00695C;
    }

    .btn-reset {
        background-color: #6c757d; /* Warna abu-abu untuk reset */
    }
    .btn-reset:hover {
        background-color: #5a6268;
    }


    /* Style lain yang sudah ada */
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top:30px; }
    .product-card { border: 1px solid #eee; border-radius: 8px; overflow: hidden; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.07); }
    .product-card img { width: 100%; height: 180px; object-fit: cover; }
    .product-card-content { padding: 15px; }
    .product-card-content h3 { margin-top: 0; font-size: 1.1em; margin-bottom: 8px; height: 40px; overflow:hidden; }
    .product-card-content .price { font-weight: bold; color: #00796B; margin-bottom: 5px; }
    .product-card-content .location { margin-bottom: 5px; }
    .badge-tipe { display: inline-block; padding: .25em .6em; font-size: 75%; font-weight: 700; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .25rem; background-color: #6c757d; color: white; }
    .form-group { margin-bottom: 1rem; }
</style>
@endpush
