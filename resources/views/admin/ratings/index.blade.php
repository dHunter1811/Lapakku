@extends('layouts.admin')

@section('title', 'Daftar Rating & Ulasan - Admin Lapakku')
@section('page-title', 'Daftar Rating & Ulasan')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 style="margin:0; font-size: 1.2em; font-weight: 600;">Semua Rating dan Ulasan Pengguna</h4>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.ratings.index') }}" class="filter-form mb-4">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="search_lahan" class="form-label">Cari Nama Lahan</label>
                    <input type="text" name="search_lahan" id="search_lahan" class="form-control form-control-sm" value="{{ request('search_lahan') }}" placeholder="Masukkan nama lahan...">
                </div>
                <div class="filter-group">
                    <label for="search_user" class="form-label">Cari Nama User</label>
                    <input type="text" name="search_user" id="search_user" class="form-control form-control-sm" value="{{ request('search_user') }}" placeholder="Nama atau email user...">
                </div>
                <div class="filter-group">
                    {{-- Mengganti filter Min. Rating menjadi Rating Tepat --}}
                    <label for="exact_rating" class="form-label">Rating Bintang</label>
                    <select name="exact_rating" id="exact_rating" class="form-select form-select-sm">
                        <option value="">Semua Rating</option>
                        <option value="5" {{ request('exact_rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Bintang)</option>
                        <option value="4" {{ request('exact_rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Bintang)</option>
                        <option value="3" {{ request('exact_rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3 Bintang)</option>
                        <option value="2" {{ request('exact_rating') == '2' ? 'selected' : '' }}>⭐⭐ (2 Bintang)</option>
                        <option value="1" {{ request('exact_rating') == '1' ? 'selected' : '' }}>⭐ (1 Bintang)</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="sort_by" class="form-label">Urutkan</label>
                    <select name="sort_by" id="sort_by" class="form-select form-select-sm">
                        <option value="terbaru" {{ request('sort_by', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort_by', 'terlama') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="rating_tinggi" {{ request('sort_by') == 'rating_tinggi' ? 'selected' : '' }}>Rating Tertinggi</option>
                        <option value="rating_rendah" {{ request('sort_by') == 'rating_rendah' ? 'selected' : '' }}>Rating Terendah</option>
                    </select>
                </div>
                <div class="filter-buttons">
                    <button type="submit" class="btn btn-info btn-sm">
                        <span class="icon">🔍</span> Filter
                    </button>
                    <a href="{{ route('admin.ratings.index') }}" class="btn btn-secondary btn-sm">
                        <span class="icon">🔄</span> Reset
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lahan</th>
                        <th>Pemberi Rating</th>
                        <th style="width:120px;">Rating</th>
                        <th>Komentar</th>
                        <th>Tanggal</th>
                        <th style="width:100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ratings ?? [] as $index => $rating)
                    <tr>
                        <td>{{ ($ratings->currentPage() - 1) * $ratings->perPage() + $index + 1 }}</td>
                        <td>
                            @if($rating->lahan)
                            <a href="{{ route('lahan.show', $rating->lahan->id) }}" target="_blank" class="table-link" title="{{$rating->lahan->judul}}">{{ Str::limit($rating->lahan->judul, 30) }}</a>
                            @else
                            <span class="text-muted">Lahan telah dihapus</span>
                            @endif
                        </td>
                        <td>
                            @if($rating->user)
                            {{ $rating->user->name }} <br><small class="text-muted">({{ $rating->user->email }})</small>
                            @else
                            <span class="text-muted">User telah dihapus</span>
                            @endif
                        </td>
                        <td style="color: #f59e0b; white-space:nowrap;">
                            @for ($i = 1; $i <= 5; $i++)
                                {{ $i <= $rating->rating ? '★' : '☆' }}
                            @endfor
                            <span class="text-muted">({{ $rating->rating }})</span>
                        </td>
                        <td>{{ Str::limit($rating->komentar, 45) ?: '-' }}</td>
                        <td>{{ $rating->created_at->format('d M Y') }}<br><small class="text-muted">{{$rating->created_at->format('H:i')}}</small></td>
                        <td>
                            <div class="action-buttons">
                                {{-- <a href="#" class="btn btn-info btn-sm" title="Lihat Detail Komentar">👁️</a> --}}
                                <form action="{{ route('admin.ratings.destroy', $rating->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus rating ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Rating"><span class="icon">🗑️</span></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">Tidak ada data rating ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
         @if(isset($ratings) && $ratings->hasPages())
        <div style="margin-top: 20px; display:flex; justify-content:center;">
            {{ $ratings->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Style dari admin/lahan/index.blade.php bisa digunakan di sini atau di layout admin */
    .form-label { font-size: 0.875em; margin-bottom: 0.3rem; color: #4b5563; font-weight: 500; }
    .form-control-sm, .form-select-sm { font-size: 0.9rem; border-radius: 0.3rem; }
    .filter-form .filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: flex-end; }
    .filter-form .filter-group { display: flex; flex-direction: column; }
    .filter-form .filter-buttons { display: flex; gap: 10px; }
    .filter-form .filter-buttons .btn { flex-grow: 1; }

    .admin-table { border: 1px solid #e5e7eb; }
    .admin-table th { background-color: #f9fafb; color: #374151; font-weight: 600; font-size: 0.9em; text-transform: uppercase; letter-spacing: 0.5px; }
    .admin-table td { font-size: 0.9em; color: #4b5563; }
    .table-link { color: #1d4ed8; font-weight: 500; text-decoration: none; }
    .table-link:hover { text-decoration: underline; }
    .text-muted { color: #6b7280 !important; }
    .action-buttons { display: flex; gap: 5px; align-items: center; }
    .action-buttons .btn-sm { padding: 0.3rem 0.6rem; display: inline-flex; align-items: center; justify-content: center; }
    .action-buttons .icon { margin-right: 0; font-size: 1em; }
    .d-inline { display: inline-block !important; }
</style>
@endpush
