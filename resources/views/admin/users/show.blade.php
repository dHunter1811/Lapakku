@extends('layouts.admin')

@section('title', 'Detail Pengguna: ' . ($user->name ?? 'User') . ' - Admin Lapakku')
@section('page-title', 'Detail Informasi Pengguna')

@section('content')
<div class="user-profile-card">
    @if(!isset($user))
        <div class="alert alert-danger text-center">Data pengguna tidak ditemukan.</div>
    @else
        <div class="profile-header">
            <img src="{{ $user->profile_photo_url }}" alt="Avatar {{ $user->name }}" class="profile-avatar">
            <div class="profile-header-info">
                <h2 class="profile-name">{{ $user->name }}</h2>
                <span class="profile-role badge status-badge status-{{ Str::slug($user->role) }}">{{ ucfirst($user->role) }}</span>
                <p class="profile-email text-muted-light">{{ $user->email }}</p>
            </div>
            <div class="profile-actions">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                    <span class="icon">✏️</span> Edit Pengguna
                </a>
                @if(Auth::id() !== $user->id)
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('PERHATIAN: Menghapus user ini akan menghapus semua data terkait (listing, rating, dll). Anda yakin?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <span class="icon">🗑️</span> Hapus Pengguna
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="profile-details-grid">
            <div class="detail-section">
                <h5 class="section-title">Informasi Akun</h5>
                <table class="table table-borderless table-profile-details">
                    <tr>
                        <th>ID Pengguna</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Email</th>
                        <td>
                            {{ $user->email }}
                            @if($user->email_verified_at)
                                <span class="verification-badge verified" title="Email Terverifikasi pada {{ $user->email_verified_at->format('d M Y H:i') }}">✔️</span>
                            @else
                                <span class="verification-badge not-verified" title="Email Belum Diverifikasi">❌</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Nomor Telepon</th>
                        <td>{{ $user->no_telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $user->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Registrasi</th>
                        <td>{{ $user->created_at->format('d F Y, H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Profil Diperbarui</th>
                        <td>{{ $user->updated_at->format('d F Y, H:i:s') }}</td>
                    </tr>
                </table>
            </div>

            <div class="detail-section">
                <h5 class="section-title">Aktivitas Lahan</h5>
                <p class="total-lahan">Total Lahan Dimiliki: <strong>{{ $user->lahan_count ?? $user->lahan()->count() }} Lahan</strong></p>
                @if(($user->lahan_count ?? $user->lahan()->count()) > 0)
                    <ul class="list-group list-group-flush lahan-activity-list">
                        @foreach($user->lahan()->latest()->take(5)->get() as $lahan)
                        <li class="list-group-item">
                            <a href="{{ route('lahan.show', $lahan->id) }}" target="_blank" class="lahan-link">{{ Str::limit($lahan->judul, 40) }}</a>
                            <span class="status-badge status-{{ Str::slug($lahan->status) }} float-end">{{ $lahan->status }}</span>
                        </li>
                        @endforeach
                        @if(($user->lahan_count ?? $user->lahan()->count()) > 5)
                        <li class="list-group-item text-center">
                            {{-- Anda mungkin perlu menyesuaikan route dan parameter filter ini --}}
                            <a href="{{ route('admin.lahan.index', ['search_pemilik_id' => $user->id]) }}" class="view-all-lahan-link">Lihat semua lahan milik user ini...</a>
                        </li>
                        @endif
                    </ul>
                @else
                    <p class="text-muted-light">User ini belum memiliki listing lahan.</p>
                @endif
            </div>
        </div>

        <div class="profile-footer-actions">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <span class="icon">⬅️</span> Kembali ke Daftar Pengguna
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .user-profile-card {
        background-color: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px; /* Radius lebih besar */
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        overflow: hidden; /* Untuk memastikan border-radius card header */
    }
    .profile-header {
        display: flex;
        align-items: center;
        padding: 25px 30px; /* Padding lebih besar */
        background-color: #f8fafc; /* Warna background header sedikit berbeda */
        border-bottom: 1px solid #e2e8f0;
    }
    .profile-avatar {
        width: 100px; /* Ukuran avatar lebih besar */
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 25px;
        border: 4px solid #fff; /* Border putih tebal */
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .profile-header-info {
        flex-grow: 1;
    }
    .profile-name {
        font-size: 1.75em; /* Nama lebih besar */
        font-weight: 600;
        color: #1e293b;
        margin-top: 0;
        margin-bottom: 5px;
    }
    .profile-role { /* Menggunakan .status-badge untuk styling */
        font-size: 0.9em !important; /* Override jika perlu */
        margin-bottom: 8px;
        display: inline-block; /* Agar margin-bottom bekerja */
    }
    .profile-email {
        font-size: 0.95em;
    }
    .profile-actions {
        display: flex;
        gap: 10px; /* Jarak antar tombol aksi di header */
    }
    .profile-actions .btn-sm {
        font-size: 0.85em;
        padding: 8px 12px;
    }

    .profile-details-grid {
        display: grid;
        grid-template-columns: 1fr; /* Default 1 kolom */
        gap: 30px; /* Jarak antar section */
        padding: 25px 30px;
    }
    @media (min-width: 992px) { /* Layar besar (lg) */
        .profile-details-grid {
            grid-template-columns: 1.5fr 1fr; /* Rasio kolom disesuaikan */
        }
    }
    .detail-section .section-title {
        font-size: 1.25em;
        font-weight: 600;
        color: #00695C; /* Warna tema Anda */
        margin-top: 0;
        margin-bottom: 18px;
        padding-bottom: 8px;
        border-bottom: 2px solid #e0f2f1; /* Aksen warna tema */
    }
    .table-profile-details {
        width: 100%;
        border: none !important; /* Hapus border default tabel */
        font-size: 0.95em;
    }
    .table-profile-details th, .table-profile-details td {
        border: none !important; /* Hapus border default cell */
        padding: 8px 0; /* Padding vertikal saja */
        vertical-align: top;
    }
    .table-profile-details th {
        width: 170px; /* Lebar tetap untuk header kolom */
        font-weight: 500;
        color: #4a5568;
    }
    .table-profile-details td {
        color: #334155;
    }
    .verification-badge {
        font-size: 0.8em;
        margin-left: 5px;
        padding: 2px 5px;
        border-radius: 3px;
        color: white;
    }
    .verified { background-color: #10b981; /* Hijau */ }
    .not-verified { background-color: #f59e0b; /* Kuning */ }

    .total-lahan {
        font-size: 1em;
        color: #4a5568;
        margin-bottom: 15px;
    }
    .lahan-activity-list .list-group-item {
        padding: 10px 0; /* Padding pada item list */
        border-bottom: 1px solid #f1f5f9; /* Pemisah antar item lebih halus */
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .lahan-activity-list .list-group-item:last-child {
        border-bottom: none;
    }
    .lahan-link {
        color: #2563eb; /* Link biru */
        text-decoration: none;
        font-weight: 500;
    }
    .lahan-link:hover {
        text-decoration: underline;
    }
    .view-all-lahan-link {
        font-size: 0.9em;
        color: #00796B;
    }
    .status-badge { /* Style dari admin/lahan/index bisa dipakai di sini */
        padding: 0.3em 0.65em; font-size: 0.75em; font-weight: 600; border-radius: 0.3rem; color: white; text-transform: capitalize;
    }
    .status-disetujui { background-color: #10b981; }
    .status-menunggu { background-color: #f59e0b; }
    .status-ditolak { background-color: #ef4444; }
    .float-end { float: right; } /* Utility jika belum ada */

    .profile-footer-actions {
        padding: 20px 30px;
        text-align: right; /* Tombol ke kanan */
        border-top: 1px solid #e2e8f0;
        background-color: #f8fafc;
    }
    .profile-footer-actions .btn {
        font-size: 0.95em;
    }

    .text-muted-light { color: #718096; }
    /* Styling untuk d-inline dan ikon di tombol bisa diambil dari layout admin jika sudah ada */
    .d-inline { display: inline-block !important; }
    .icon { margin-right: 5px; }

</style>
@endpush
