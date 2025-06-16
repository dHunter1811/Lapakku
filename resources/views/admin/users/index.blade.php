@extends('layouts.admin')

@section('title', 'Manajemen Pengguna - Admin Lapakku')
@section('page-title', 'Daftar Pengguna Terdaftar')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 style="margin:0; font-size: 1.2em; font-weight: 600;">Semua Pengguna Sistem</h4>
        {{-- Tombol Ekspor Ditambahkan Di Sini --}}
        <div class="export-buttons">
            <a href="{{ route('admin.users.export', array_merge(request()->query(), ['format' => 'xlsx'])) }}" class="btn btn-success btn-sm">
                <span class="icon">📄</span> Ekspor ke Excel
            </a>
            <a href="{{ route('admin.users.export', array_merge(request()->query(), ['format' => 'pdf'])) }}" class="btn btn-danger btn-sm">
                <span class="icon">📕</span> Ekspor ke PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        {{-- Filter Form --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="filter-form mb-4">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="search_nama_email" class="form-label">Cari Nama/Email</label>
                    <input type="text" name="search_nama_email" id="search_nama_email" class="form-control form-control-sm" value="{{ request('search_nama_email') }}" placeholder="Masukkan nama atau email...">
                </div>
                <div class="filter-group">
                    <label for="search_role" class="form-label">Role Pengguna</label>
                    <select name="search_role" id="search_role" class="form-select form-select-sm">
                        <option value="">Semua Role</option>
                        <option value="user" {{ request('search_role') == 'user' ? 'selected' : '' }}>User Biasa</option>
                        <option value="admin" {{ request('search_role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                </div>
                <div class="filter-buttons">
                    <button type="submit" class="btn btn-info btn-sm">
                        <span class="icon">🔍</span> Filter
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
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
                        <th style="min-width: 180px;">Nama Pengguna</th>
                        <th>Email</th>
                        <th class="text-center">Role</th>
                        <th>Tgl Registrasi</th>
                        <th class="text-center">Listing</th>
                        <th class="text-center" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users ?? [] as $index => $user)
                    <tr>
                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="{{ $user->profile_photo_url }}" alt="Foto {{ $user->name }}" class="table-avatar">
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            <span class="status-badge role-{{ Str::slug($user->role) }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                        <td class="text-center">{{ $user->lahan_count ?? $user->lahan()->count() }}</td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm" title="Lihat Detail User">👁️</a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Edit User">✏️</a>
                                @if(Auth::id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('PERHATIAN: Menghapus user ini akan menghapus semua data terkait. Anda yakin?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus User">🗑️</button>
                                </form>
                                @else
                                    <button class="btn btn-secondary btn-sm" title="Tidak bisa hapus diri sendiri" disabled>🗑️</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">Tidak ada data pengguna ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($users) && $users->hasPages())
        <div style="margin-top: 20px; display:flex; justify-content:center;">
            {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Mengambil style dari layout admin yang relevan */
    .card-header { display: flex; justify-content: space-between; align-items: center; }
    .export-buttons { display: flex; gap: 10px; }
    .export-buttons .btn-sm { font-size: 0.85em; padding: 8px 12px; }
    .export-buttons .btn-sm .icon { margin-right: 5px; }

    .form-label { font-size: 0.875em; margin-bottom: 0.3rem; color: #4b5563; font-weight: 500; }
    .form-control-sm, .form-select-sm { font-size: 0.9rem; border-radius: 0.3rem; }
    .filter-form .filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; align-items: flex-end; }
    .filter-form .filter-group { display: flex; flex-direction: column; }
    .filter-form .filter-buttons { display: flex; gap: 10px; }
    .filter-form .filter-buttons .btn { flex-grow: 1; }

    .admin-table th { background-color: #f9fafb; color: #374151; font-weight: 600; font-size: 0.9em; text-transform: uppercase; letter-spacing: 0.5px; }
    .admin-table td { font-size: 0.9em; color: #4b5563; vertical-align: middle; }
    .admin-table tbody tr:hover { background-color: #f1f5f9; }
    .table-avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb; }

    .status-badge { padding: 0.3em 0.65em; font-size: 0.75em; font-weight: 600; border-radius: 0.25rem; color: white; text-transform: capitalize; }
    .role-admin { background-color: #00796B; } /* Hijau tua */
    .role-user { background-color: #64748b; } /* Abu-abu */

    .action-buttons { display: flex; gap: 5px; align-items: center; justify-content: center; }
    .action-buttons .btn-sm { padding: 0.3rem 0.6rem; display: inline-flex; align-items: center; justify-content: center; }
    .action-buttons .icon { margin-right: 0; font-size: 1em; }
    .d-inline { display: inline-block !important; }
</style>
@endpush
