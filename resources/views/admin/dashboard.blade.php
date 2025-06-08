@extends('layouts.admin')

@section('title', 'Admin Dashboard - Lapakku')
@section('page-title', 'Dashboard Utama')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="border-left: 5px solid #00796B;">
        <h4 style="color:#00796B; margin-top:0;">Total Listing</h4>
        <p style="font-size: 2em; font-weight: bold;">{{ $adminStats['totalListing'] ?? 0 }}</p>
    </div>
    <div class="card" style="border-left: 5px solid #FFA000;">
        <h4 style="color:#FFA000; margin-top:0;">Listing Menunggu</h4>
        <p style="font-size: 2em; font-weight: bold;">{{ $adminStats['listingMenunggu'] ?? 0 }}</p>
    </div>
    <div class="card" style="border-left: 5px solid #4CAF50;">
        <h4 style="color:#4CAF50; margin-top:0;">Listing Disetujui</h4>
        <p style="font-size: 2em; font-weight: bold;">{{ $adminStats['listingDisetujui'] ?? 0 }}</p>
    </div>
    <div class="card" style="border-left: 5px solid #D32F2F;">
        <h4 style="color:#D32F2F; margin-top:0;">Listing Ditolak</h4>
        <p style="font-size: 2em; font-weight: bold;">{{ $adminStats['listingDitolak'] ?? 0 }}</p>
    </div>
    <div class="card" style="border-left: 5px solid #0288D1;">
        <h4 style="color:#0288D1; margin-top:0;">Total User</h4>
        <p style="font-size: 2em; font-weight: bold;">{{ $adminStats['totalUser'] ?? 0 }}</p>
    </div>
    <div class="card" style="border-left: 5px solid #7B1FA2;">
        <h4 style="color:#7B1FA2; margin-top:0;">Rating Terkumpul</h4>
        <p style="font-size: 2em; font-weight: bold;">{{ $adminStats['ratingTerkumpul'] ?? 0 }}</p>
    </div>
</div>

<div class="card mb-3">
    <div style="display:flex; justify-content: space-between; align-items: center;">
        <h3 style="color:#00796B; margin-top:0;">Manajemen Listing Terbaru</h3>
        <a href="{{ route('admin.lahan.index') }}" class="btn btn-primary btn-sm">Lihat Semua Listing</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Pemilik</th>
                    <th>Status</th>
                    <th>Tanggal Posting</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentListings ?? [] as $lahan)
                <tr>
                    <td>{{ Str::limit($lahan->judul, 30) }}</td>
                    <td>{{ $lahan->user->name ?? 'N/A' }}</td>
                    <td>
                        <span style="padding: 3px 8px; border-radius: 10px; color:white;
                            background-color: {{ $lahan->status == 'Disetujui' ? '#4CAF50' : ($lahan->status == 'Menunggu' ? '#FFA000' : '#D32F2F') }}">
                            {{ $lahan->status }}
                        </span>
                    </td>
                    <td>{{ $lahan->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.lahan.edit', $lahan) }}" class="btn btn-sm btn-warning">Edit</a>
                        {{-- Tambahkan tombol approve/reject jika status Menunggu --}}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada listing.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-3">
     <div style="display:flex; justify-content: space-between; align-items: center;">
        <h3 style="color:#00796B; margin-top:0;">Rating Terbaru</h3>
        <a href="{{ route('admin.ratings.index') }}" class="btn btn-primary btn-sm">Lihat Semua Rating</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Lahan</th>
                    <th>Pemberi</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                 @forelse($recentRatings ?? [] as $rating)
                <tr>
                    <td>{{ Str::limit($rating->lahan->judul ?? 'Lahan Dihapus', 25) }}</td>
                    <td>{{ $rating->user->name ?? 'N/A' }}</td>
                    <td>
                        @for ($i = 1; $i <= 5; $i++) {{ $i <= $rating->rating ? '★' : '☆' }} @endfor
                    </td>
                    <td>{{ Str::limit($rating->komentar, 30) }}</td>
                    <td>{{ $rating->created_at->format('d M Y') }}</td>
                    <td>
                        <form action="{{ route('admin.ratings.destroy', $rating) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus rating ini?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada rating.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div style="display:flex; justify-content: space-between; align-items: center;">
        <h3 style="color:#00796B; margin-top:0;">Pesan Masuk Terbaru</h3>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-primary btn-sm">Lihat Semua Pesan</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Pesan (Singkat)</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentMessages ?? [] as $message)
                <tr style="{{ !$message->is_read ? 'font-weight:bold;' : '' }}">
                    <td>{{ $message->nama ?? ($message->user->name ?? 'Tamu') }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ Str::limit($message->pesan, 30) }}</td>
                    <td>{{ $message->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $message->is_read ? 'Dibaca' : 'Baru' }}</td>
                    <td>
                        <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-info btn-sm">Lihat</a>
                         <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus pesan ini?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                 <tr>
                    <td colspan="6" class="text-center">Tidak ada pesan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
{{-- Tambahkan Chart.js atau library grafik lain jika diperlukan untuk statistik --}}
@endpush