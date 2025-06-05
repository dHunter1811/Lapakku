@extends('layouts.admin')

@section('title', 'Pesan Masuk - Admin Lapakku')
@section('page-title', 'Kotak Pesan Masuk')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 style="margin:0;">Daftar Semua Pesan Pengguna</h4>
    </div>
    <div class="card-body">
        {{-- Filter Form (Opsional) --}}
        <form method="GET" action="{{ route('admin.messages.index') }}" class="mb-3">
            <div style="display: flex; gap: 10px; align-items: flex-end;">
                <div style="flex-grow:1;">
                    <label for="search_pengirim" class="form-label">Cari Nama/Email Pengirim</label>
                    <input type="text" name="search_pengirim" id="search_pengirim" class="form-control form-control-sm" value="{{ request('search_pengirim') }}" placeholder="Masukkan nama atau email...">
                </div>
                <div style="min-width: 150px;">
                    <label for="search_status_baca" class="form-label">Status Baca</label>
                    <select name="search_status_baca" id="search_status_baca" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="0" {{ request('search_status_baca') == '0' ? 'selected' : '' }}>Belum Dibaca</option>
                        <option value="1" {{ request('search_status_baca') == '1' ? 'selected' : '' }}>Sudah Dibaca</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-info btn-sm" style="height: fit-content; padding-bottom: 0.45rem; padding-top: 0.45rem;">Filter</button>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary btn-sm" style="height: fit-content; padding-bottom: 0.45rem; padding-top: 0.45rem;">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pengirim</th>
                        <th>Email</th>
                        <th>Subjek/Pesan Singkat</th>
                        <th>Tanggal Kirim</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages ?? [] as $index => $message)
                    <tr style="{{ !$message->is_read ? 'font-weight:bold; background-color: #f0f8ff;' : '' }}">
                        <td>{{ ($messages->currentPage() - 1) * $messages->perPage() + $index + 1 }}</td>
                        <td>{{ $message->nama ?? ($message->user->name ?? 'Tamu') }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ Str::limit($message->pesan, 50) }}</td>
                        <td>{{ $message->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            @if($message->is_read)
                                <span style="color: green;">Sudah Dibaca</span>
                            @else
                                <span style="color: orange;">Belum Dibaca</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.messages.show', $message->id) }}" class="btn btn-info btn-sm" title="Lihat Detail Pesan">👁️ Baca</a>
                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus pesan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus Pesan">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Tidak ada pesan masuk.</td>
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
    .form-label { font-size: 0.85em; margin-bottom: 0.2rem; }
    .form-control-sm, .form-select-sm { font-size: 0.85rem; padding: 0.25rem 0.5rem; }
    .btn-sm { padding: 0.2rem 0.5rem; font-size: 0.8rem; }
    th, td { vertical-align: middle; }
</style>
@endpush
