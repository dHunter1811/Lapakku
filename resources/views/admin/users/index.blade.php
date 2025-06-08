@extends('layouts.admin')

@section('title', 'Manajemen Pengguna - Admin Lapakku')
@section('page-title', 'Daftar Pengguna Terdaftar')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 style="margin:0;">Semua Pengguna Sistem</h4>
        {{-- <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">Tambah User Baru</a> --}}
    </div>
    <div class="card-body">
        {{-- Filter Form (Opsional) --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
            <div style="display: flex; gap: 10px; align-items: flex-end;">
                <div style="flex-grow:1;">
                    <label for="search_nama_email" class="form-label">Cari Nama/Email</label>
                    <input type="text" name="search_nama_email" id="search_nama_email" class="form-control form-control-sm" value="{{ request('search_nama_email') }}" placeholder="Masukkan nama atau email...">
                </div>
                <div style="min-width: 150px;">
                    <label for="search_role" class="form-label">Role Pengguna</label>
                    <select name="search_role" id="search_role" class="form-select form-select-sm">
                        <option value="">Semua Role</option>
                        <option value="user" {{ request('search_role') == 'user' ? 'selected' : '' }}>User Biasa</option>
                        <option value="admin" {{ request('search_role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                        {{-- Tambahkan role lain jika ada --}}
                    </select>
                </div>
                <button type="submit" class="btn btn-info btn-sm" style="height: fit-content; padding-bottom: 0.45rem; padding-top: 0.45rem;">Filter</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm" style="height: fit-content; padding-bottom: 0.45rem; padding-top: 0.45rem;">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tgl Registrasi</th>
                        <th>Listing Dimiliki</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users ?? [] as $index => $user)
                    <tr>
                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span style="padding: 3px 8px; border-radius: 10px; color:white; font-size:0.8em;
                                background-color: {{ $user->role == 'admin' ? '#00796B' : '#607D8B' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                        <td>{{ $user->lahan_count ?? $user->lahan()->count() }} Lahan</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm" title="Lihat Detail User">👁️</a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Edit User">✏️</a>
                            @if(Auth::id() !== $user->id) {{-- Admin tidak bisa hapus diri sendiri --}}
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('PERHATIAN: Menghapus user ini akan menghapus semua data terkait (listing, rating, dll). Anda yakin?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus User">🗑️</button>
                            </form>
                            @else
                                <button class="btn btn-secondary btn-sm" title="Tidak bisa hapus diri sendiri" disabled>🗑️</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Tidak ada data pengguna ditemukan.</td>
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
    .form-label { font-size: 0.85em; margin-bottom: 0.2rem; }
    .form-control-sm, .form-select-sm { font-size: 0.85rem; padding: 0.25rem 0.5rem; }
    .btn-sm { padding: 0.2rem 0.5rem; font-size: 0.8rem; }
    th, td { vertical-align: middle; }
</style>
@endpush
