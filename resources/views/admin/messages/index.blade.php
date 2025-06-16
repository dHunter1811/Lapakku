@extends('layouts.admin')

@section('title', 'Pesan Masuk - Admin Lapakku')
@section('page-title', 'Kotak Pesan Masuk')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 style="margin:0; font-size: 1.2em; font-weight: 600;">Daftar Semua Pesan Pengguna</h4>
        {{-- Tombol Ekspor Ditambahkan Di Sini --}}
        <div class="export-buttons">
            <a href="{{ route('admin.messages.export', array_merge(request()->query(), ['format' => 'xlsx'])) }}" class="btn btn-success btn-sm">
                <span class="icon">📄</span> Ekspor ke Excel
            </a>
            <a href="{{ route('admin.messages.export', array_merge(request()->query(), ['format' => 'pdf'])) }}" class="btn btn-danger btn-sm">
                <span class="icon">📕</span> Ekspor ke PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        {{-- Filter Form --}}
        <form method="GET" action="{{ route('admin.messages.index') }}" class="filter-form mb-4">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="search_pengirim" class="form-label">Cari Nama/Email Pengirim</label>
                    <input type="text" name="search_pengirim" id="search_pengirim" class="form-control form-control-sm" value="{{ request('search_pengirim') }}" placeholder="Masukkan nama atau email...">
                </div>
                <div class="filter-group">
                    <label for="search_status_baca" class="form-label">Status Baca</label>
                    <select name="search_status_baca" id="search_status_baca" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="0" {{ request('search_status_baca') == '0' ? 'selected' : '' }}>Belum Dibaca</option>
                        <option value="1" {{ request('search_status_baca') == '1' ? 'selected' : '' }}>Sudah Dibaca</option>
                    </select>
                </div>
                <div class="filter-buttons">
                    <button type="submit" class="btn btn-info btn-sm">
                        <span class="icon">🔍</span> Filter
                    </button>
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary btn-sm">
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
                        <th>Pengirim</th>
                        <th>Email</th>
                        <th>Pesan Singkat</th>
                        <th>Tanggal Kirim</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages ?? [] as $index => $message)
                    <tr style="{{ !$message->is_read ? 'font-weight:bold; background-color: #f8fafc;' : '' }}" class="{{ !$message->is_read ? 'unread-message' : '' }}">
                        <td>{{ ($messages->currentPage() - 1) * $messages->perPage() + $index + 1 }}</td>
                        <td>
                            @if($message->user)
                                <a href="{{ route('admin.users.show', $message->user_id) }}" class="table-link">{{ $message->nama ?? $message->user->name }}</a> <span class="badge status-badge status-user" style="background-color: #64748b;">User</span>
                            @else
                                {{ $message->nama ?? 'Tamu' }}
                            @endif
                        </td>
                        <td><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></td>
                        <td>{{ Str::limit($message->pesan, 50) }}</td>
                        <td>{{ $message->created_at->format('d M Y') }}<br><small class="text-muted">{{$message->created_at->format('H:i')}}</small></td>
                        <td class="text-center">
                            @if($message->is_read)
                                <span class="badge status-badge status-dibaca">Sudah Dibaca</span>
                            @else
                                <span class="badge status-badge status-belum-dibaca">Belum Dibaca</span>
                            @endif
                        </td>
                        <td class="text-center action-buttons-cell">
                            <a href="{{ route('admin.messages.show', $message->id) }}" class="btn btn-info btn-sm" title="Lihat Detail Pesan"><span class="icon">👁️</span> Baca</a>
                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus pesan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus Pesan"><span class="icon">🗑️</span></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">Tidak ada pesan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($messages) && $messages->hasPages())
        <div style="margin-top: 20px; display:flex; justify-content:center;">
            {{ $messages->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Mengambil style dari layout admin yang relevan */
    .form-label { font-size: 0.875em; margin-bottom: 0.3rem; color: #4b5563; font-weight: 500; }
    .form-control-sm, .form-select-sm { font-size: 0.9rem; border-radius: 0.3rem; }
    .filter-form .filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; align-items: flex-end; }
    .filter-form .filter-group { display: flex; flex-direction: column; }
    .filter-form .filter-buttons { display: flex; gap: 10px; }
    .filter-form .filter-buttons .btn { flex-grow: 1; }
    .admin-table th { background-color: #f9fafb; color: #374151; font-weight: 600; font-size: 0.9em; text-transform: uppercase; letter-spacing: 0.5px; }
    .admin-table td { font-size: 0.9em; color: #4b5563; vertical-align: middle; }
    .admin-table tbody tr:hover { background-color: #f1f5f9; }
    .unread-message td { font-weight: 600; color: #1e293b; }
    .text-muted { color: #6b7280 !important; }
    .table-link { color: #1d4ed8; font-weight: 500; text-decoration: none; }
    .table-link:hover { text-decoration: underline; }

    /* Styling badge status */
    .status-badge { padding: 0.3em 0.6em; font-size: 0.75em; font-weight: 600; border-radius: 0.25rem; color: white; }
    .status-dibaca { background-color: #64748b; }
    .status-belum-dibaca { background-color: #f59e0b; }

    .action-buttons-cell .btn-sm { padding: 0.3rem 0.6rem; display: inline-flex; align-items: center; justify-content: center; }
    .action-buttons-cell .icon { margin-right: 4px; }
    .action-buttons-cell .btn-sm[title] .icon { margin-right: 0; }
    .d-inline { display: inline-block !important; }

    /* CSS untuk tombol ekspor */
    .card-header { display: flex; justify-content: space-between; align-items: center; }
    .export-buttons { display: flex; gap: 10px; }
    .export-buttons .btn-sm { font-size: 0.85em; padding: 8px 12px; }
    .export-buttons .btn-sm .icon { margin-right: 5px; }
</style>
@endpush
