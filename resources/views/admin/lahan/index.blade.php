@extends('layouts.admin')

@section('title', 'Manajemen Listing Lahan - Admin Lapakku')
@section('page-title', 'Manajemen Listing Lahan')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 style="margin:0; font-size: 1.2em; font-weight: 600;">Daftar Semua Lahan</h4>
        
        {{-- === TOMBOL EKSPOR DITAMBAHKAN DI SINI === --}}
        <div class="export-buttons">
            {{-- Tombol ini akan mengarahkan ke route export dengan format 'xlsx' --}}
            {{-- array_merge akan menggabungkan filter yang sedang aktif dengan parameter format --}}
            <a href="{{ route('admin.lahan.export', array_merge(request()->query(), ['format' => 'xlsx'])) }}" class="btn btn-success btn-sm">
                <span class="icon">📄</span> Ekspor ke Excel
            </a>
            <a href="{{ route('admin.lahan.export', array_merge(request()->query(), ['format' => 'pdf'])) }}" class="btn btn-danger btn-sm">
                <span class="icon">📕</span> Ekspor ke PDF
            </a>
        </div>
        {{-- ====================================== --}}

    </div>
    <div class="card-body">
        {{-- Filter Form --}}
        <form method="GET" action="{{ route('admin.lahan.index') }}" class="filter-form mb-4">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="search_judul" class="form-label">Cari Judul/Pemilik</label>
                    <input type="text" name="search_query" id="search_judul" class="form-control form-control-sm" value="{{ request('search_query') }}" placeholder="Judul, nama/email pemilik...">
                </div>
                <div class="filter-group">
                    <label for="search_status" class="form-label">Status</label>
                    <select name="search_status" id="search_status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" {{ request('search_status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Disetujui" {{ request('search_status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ request('search_status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="sort_by" class="form-label">Urutkan</label>
                    <select name="sort_by" id="sort_by" class="form-select form-select-sm">
                        <option value="terbaru" {{ request('sort_by', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort_by') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="judul_asc" {{ request('sort_by') == 'judul_asc' ? 'selected' : '' }}>Judul (A-Z)</option>
                        <option value="judul_desc" {{ request('sort_by') == 'judul_desc' ? 'selected' : '' }}>Judul (Z-A)</option>
                    </select>
                </div>
                <div class="filter-buttons">
                    <button type="submit" class="btn btn-info btn-sm">
                        <span class="icon">🔍</span> Filter
                    </button>
                    <a href="{{ route('admin.lahan.index') }}" class="btn btn-secondary btn-sm">
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
                        <th>Thumbnail</th>
                        <th>Judul Lahan</th>
                        <th>Pemilik</th>
                        <th>Harga Sewa</th>
                        <th>Status</th>
                        <th>Tipe/Lokasi</th>
                        <th>Tgl Posting</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lahanList ?? [] as $index => $lahan)
                    <tr>
                        <td>{{ ($lahanList->currentPage() - 1) * $lahanList->perPage() + $index + 1 }}</td>
                        <td>
                            @if($lahan->gambar_utama)
                                <img src="{{ Storage::url($lahan->gambar_utama) }}" alt="Thumbnail" class="table-thumbnail">
                            @else
                                <div class="table-thumbnail-placeholder">?</div>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('lahan.show', $lahan->id) }}" target="_blank" class="table-link" title="{{$lahan->judul}}">
                                {{ Str::limit($lahan->judul, 35) }}
                            </a>
                        </td>
                        <td>
                            {{ $lahan->user->name ?? 'N/A' }}<br>
                            <small class="text-muted">({{ $lahan->user->email ?? 'N/A' }})</small>
                        </td>
                        <td>Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }}</td>
                        <td>
                            <span class="status-badge status-{{ Str::slug($lahan->status) }}">
                                {{ $lahan->status }}
                            </span>
                        </td>
                        <td>
                            <small>{{ $lahan->tipe_lahan ?? '-' }}<br>{{ $lahan->lokasi ?? '-' }}</small>
                        </td>
                        <td>{{ $lahan->created_at->format('d M Y') }}<br><small>{{ $lahan->created_at->format('H:i') }}</small></td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.lahan.edit', $lahan->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <span class="icon">✏️</span> Edit
                                </a>
                                @if($lahan->status == 'Menunggu')
                                    <form action="{{ route('admin.lahan.approve', $lahan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menyetujui lahan ini?')">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm" title="Setujui"><span class="icon">✔️</span></button>
                                    </form>
                                    <form action="{{ route('admin.lahan.reject', $lahan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menolak lahan ini?')">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-secondary btn-sm" title="Tolak"><span class="icon">❌</span></button>
                                    </form>
                                @elseif($lahan->status == 'Disetujui')
                                    <form action="{{ route('admin.lahan.reject', $lahan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Menolak lahan ini akan mengubah statusnya. Lanjutkan?')">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-secondary btn-sm" title="Tolak (Tarik Persetujuan)"><span class="icon">❌</span></button>
                                    </form>
                                @elseif($lahan->status == 'Ditolak')
                                     <form action="{{ route('admin.lahan.approve', $lahan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Menyetujui lahan yang ditolak ini?')">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm" title="Setujui Kembali"><span class="icon">✔️</span></button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.lahan.destroy', $lahan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('PERHATIAN: Menghapus lahan ini bersifat permanen. Anda yakin?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Permanen"><span class="icon">🗑️</span></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 20px;">Tidak ada data lahan ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($lahanList) && $lahanList->hasPages())
        <div style="margin-top: 20px; display:flex; justify-content:center;">
            {{ $lahanList->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ... (Style Anda yang sudah ada dari admin.blade.php atau style sebelumnya) ... */
    .form-label {
        font-size: 0.875em;
        margin-bottom: 0.3rem;
        color: #4b5563;
        font-weight: 500;
    }
    .form-control-sm, .form-select-sm {
        font-size: 0.9rem;
        border-radius: 0.3rem;
    }
    .filter-form .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        align-items: flex-end;
    }
    .filter-form .filter-group {
        display: flex;
        flex-direction: column;
    }
    .filter-form .filter-buttons {
        display: flex;
        gap: 10px;
    }
    .filter-form .filter-buttons .btn {
        flex-grow: 1;
    }

    .admin-table th {
        background-color: #f9fafb;
        color: #374151;
        font-weight: 600;
        font-size: 0.9em;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .admin-table td {
        font-size: 0.9em;
        color: #4b5563;
    }
    .table-thumbnail {
        width: 70px;
        height: 45px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #e5e7eb;
    }
    .table-thumbnail-placeholder {
        width: 70px;
        height: 45px;
        background-color: #e5e7eb;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #9ca3af;
    }
    .table-link {
        color: #1d4ed8;
        font-weight: 500;
        text-decoration: none;
    }
    .table-link:hover {
        text-decoration: underline;
    }
    .text-muted {
        color: #6b7280 !important;
    }
    .status-badge {
        padding: 0.25em 0.6em; font-size: 0.75em; font-weight: 600; border-radius: 0.25rem; color: white; text-transform: capitalize;
    }
    .status-disetujui { background-color: #10b981; }
    .status-menunggu { background-color: #f59e0b; }
    .status-ditolak { background-color: #ef4444; }
    .action-buttons { display: flex; gap: 5px; align-items: center; }
    .action-buttons .btn-sm { padding: 0.3rem 0.6rem; display: inline-flex; align-items: center; justify-content: center; }
    .action-buttons .icon { margin-right: 0; font-size: 1em; }
    .action-buttons .btn-sm[title] .icon + span { display: none; }
    .action-buttons .btn-sm[title] { min-width: 30px; }
    .action-buttons .btn-warning .icon { margin-right: 4px; }
    .d-inline { display: inline-block !important; }

    /* === CSS BARU UNTUK TOMBOL EKSPOR === */
    .card-header .export-buttons {
        display: flex;
        gap: 10px;
    }
    .export-buttons .btn-sm {
        font-size: 0.85em; /* Ukuran font tombol ekspor */
        padding: 8px 12px;
    }
    .export-buttons .btn-sm .icon {
        margin-right: 5px;
    }
</style>
@endpush
