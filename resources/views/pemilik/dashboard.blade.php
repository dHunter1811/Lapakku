@extends('layouts.app')

@section('title', 'Dashboard Pemilik Lahan - Lapakku')

@section('content')
<div class="container dashboard-pemilik-container">
    <div class="card dashboard-pemilik-card">
        <div class="card-header dashboard-header">
            <div>
                <h1 class="dashboard-title">Dashboard Pemilik Lahan</h1>
                <p class="dashboard-subtitle">Kelola lahan dan pengajuan sewa untuk properti Anda.</p>
            </div>
            {{-- PERUBAHAN DI SINI: Mengarah ke route lahanbaru.tambah --}}
            <a href="{{ route('lahanbaru.tambah') }}" class="btn btn-success btn-sm dashboard-action-button">
                <span class="icon">➕</span> Tambah Lahan Baru
            </a>
        </div>
        <div class="card-body" style="padding: 25px;">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif

            {{-- SEKSI LAHAN MILIK SAYA --}}
            <div class="dashboard-section">
                <div class="dashboard-section-header">
                    <h4>Lahan Milik Saya</h4>
                </div>

                @if(!isset($lahanMilikUser) || $lahanMilikUser->isEmpty())
                    <div class="alert alert-light text-center empty-state">
                        <p style="font-size: 1.1em; margin-bottom:10px;">Anda belum mendaftarkan lahan apapun.</p>
                        {{-- Tombol ini juga harus mengarah ke lahanbaru.tambah --}}
                        <a href="{{ route('lahanbaru.tambah') }}" class="btn btn-primary btn-sm">Daftarkan Lahan Pertama Anda</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-dashboard table-lahan-saya">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Lahan</th>
                                    <th class="text-center">Status</th>
                                    <th>Tipe</th>
                                    <th>Lokasi</th>
                                    <th>Harga/bln</th>
                                    <th class="text-center" style="min-width: 160px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lahanMilikUser as $index => $lahan)
                                <tr>
                                    <td>{{ ($lahanMilikUser->currentPage() - 1) * $lahanMilikUser->perPage() + $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('lahan.show', $lahan->id) }}" target="_blank" class="table-link-lahan" title="{{ $lahan->judul }}">
                                            {{ Str::limit($lahan->judul, 30) }}
                                        </a>
                                        @if($lahan->gambar_utama)
                                            <img src="{{ Storage::url($lahan->gambar_utama) }}" alt="Thumb" class="table-thumbnail-inline">
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge status-badge status-{{ Str::slug($lahan->status) }}">{{ $lahan->status }}</span>
                                    </td>
                                    <td>{{ $lahan->tipe_lahan ?? '-' }}</td>
                                    <td>{{ $lahan->lokasi ?? '-' }}</td>
                                    <td class="font-weight-bold">Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }}</td>
                                    <td class="text-center action-buttons-cell">
                                        <a href="{{ route('lahan.show', $lahan->id) }}" target="_blank" class="btn btn-info btn-xs" title="Lihat Detail Publik">👁️ Lihat</a>
                                        {{-- Link edit lahan tetap menggunakan route('lahan.edit') yang ditangani LahanController --}}
                                        <a href="{{ route('lahan.edit', $lahan->id) }}" class="btn btn-warning btn-xs" title="Edit Lahan">✏️ Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($lahanMilikUser->hasPages())
                    <div style="margin-top: 20px; display:flex; justify-content:center;">
                        {{ $lahanMilikUser->appends(['status_pengajuan' => request('status_pengajuan')])->links('pagination::bootstrap-4') }}
                    </div>
                    @endif
                @endif
            </div>

            <hr class="dashboard-divider">

            {{-- SEKSI PENGAJUAN SEWA MASUK (tetap sama) --}}
            <div class="dashboard-section">
                <div class="dashboard-section-header">
                    <h4>Pengajuan Sewa Masuk</h4>
                    <form method="GET" action="{{ route('pemilik.dashboard') }}" class="filter-form-inline">
                        <label for="status_pengajuan" class="form-label sr-only">Filter Status:</label>
                        <select name="status_pengajuan" id="status_pengajuan" class="form-control form-control-sm">
                            <option value="">Semua Status Pengajuan</option>
                            <option value="Menunggu Persetujuan" {{ request('status_pengajuan') == 'Menunggu Persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                            <option value="Disetujui" {{ request('status_pengajuan') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ request('status_pengajuan') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="Dibatalkan Penyewa" {{ request('status_pengajuan') == 'Dibatalkan Penyewa' ? 'selected' : '' }}>Dibatalkan Penyewa</option>
                            <option value="Selesai" {{ request('status_pengajuan') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <button type="submit" class="btn btn-info btn-sm">Filter</button>
                        <a href="{{ route('pemilik.dashboard') }}" class="btn btn-secondary btn-sm">Reset</a>
                    </form>
                </div>

                @if(!isset($pengajuanMasuk) || $pengajuanMasuk->isEmpty())
                    <div class="alert alert-light text-center empty-state">
                        <p style="font-size: 1.1em; margin-bottom:5px;">Belum ada pengajuan sewa untuk lahan Anda.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-dashboard">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lahan Diajukan</th>
                                    <th>Diajukan Oleh</th>
                                    <th>Durasi</th>
                                    <th>Total Harga</th>
                                    <th style="min-width: 150px;">Pesan Penyewa</th>
                                    <th>Tgl Pengajuan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="min-width: 200px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuanMasuk as $index => $pengajuan)
                                <tr>
                                    <td>{{ ($pengajuanMasuk->currentPage() - 1) * $pengajuanMasuk->perPage() + $index + 1 }}</td>
                                    <td>
                                        @if($pengajuan->lahan)
                                            <a href="{{ route('lahan.show', $pengajuan->lahan_id) }}" target="_blank" class="table-link-lahan" title="{{ $pengajuan->lahan->judul }}">{{ Str::limit($pengajuan->lahan->judul, 25) }}</a>
                                        @else
                                            <span class="text-muted-light">Lahan Dihapus</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pengajuan->penyewa)
                                            <span title="{{$pengajuan->penyewa->email}}">{{ $pengajuan->penyewa->name }}</span><br>
                                            <small class="text-muted-light">{{ $pengajuan->penyewa->no_telepon ?? $pengajuan->penyewa->email }}</small>
                                        @else
                                            <span class="text-muted-light">User Dihapus</span>
                                        @endif
                                    </td>
                                    <td>{{ $pengajuan->durasi_sewa_bulan }} bulan</td>
                                    <td class="font-weight-bold">Rp {{ number_format($pengajuan->total_harga, 0, ',', '.') }}</td>
                                    <td title="{{ $pengajuan->pesan_penyewa }}" class="pesan-penyewa-tooltip">
                                        {{ Str::limit($pengajuan->pesan_penyewa, 25) ?: '-' }}
                                        @if(strlen($pengajuan->pesan_penyewa) > 25)
                                        <button type="button" class="btn btn-outline-info btn-xs" title="Lihat Pesan Lengkap" onclick="showFullMessage(this)" data-fullmessage="{{ e($pengajuan->pesan_penyewa) }}" style="margin-left: 5px; padding: 1px 4px;">👁️</button>
                                        @endif
                                    </td>
                                    <td>{{ $pengajuan->created_at->format('d M Y') }}<br><small class="text-muted-light">{{$pengajuan->created_at->format('H:i')}}</small></td>
                                    <td class="text-center">
                                        <span class="badge status-badge status-{{ Str::slug($pengajuan->status) }}">{{ $pengajuan->status }}</span>
                                    </td>
                                    <td class="text-center action-buttons-cell">
                                        @if ($pengajuan->status == 'Menunggu Persetujuan')
                                        <form action="{{ route('pemilik.pengajuan.setujui', $pengajuan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin MENYETUJUI pengajuan ini?')">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-xs" title="Setujui Pengajuan">✔️ Setujui</button>
                                        </form>
                                        <form action="{{ route('pemilik.pengajuan.tolak', $pengajuan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin MENOLAK pengajuan ini?')">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-danger btn-xs" title="Tolak Pengajuan">❌ Tolak</button>
                                        </form>
                                        <a href="https://wa.me/{{ $pengajuan->penyewa->no_telepon }}" target="_blank" class="btn btn-success btn-xs">
                                            💬 WhatsApp
                                        </a>
                                        @elseif($pengajuan->status == 'Disetujui')
                                        <span class="text-success font-weight-bold">Telah Disetujui</span>
                                        @elseif($pengajuan->status == 'Ditolak')
                                        <span class="text-danger font-weight-bold">Telah Ditolak</span>
                                        @else
                                        <span class="text-muted">{{ $pengajuan->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($pengajuanMasuk->hasPages())
                    <div style="margin-top: 25px; display:flex; justify-content:center;">
                        {{ $pengajuanMasuk->appends(['lahan_page' => request('lahan_page')])->links('pagination::bootstrap-4') }}
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal untuk menampilkan pesan lengkap (tetap sama) --}}
{{-- ... (kode modal) ... --}}
@endsection

@push('styles')
{{-- Menambahkan link CDN untuk Bootstrap 5 CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" xintegrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<style>
    /* ... (CSS Anda yang sudah ada dari respons sebelumnya) ... */
    .dashboard-pemilik-container { padding-top: 10px; padding-bottom: 30px; }
    .dashboard-pemilik-card .card-header.dashboard-header {
        background-color: #00695C; color: white; padding: 20px 25px;
        border-bottom: none; display: flex; justify-content: space-between; align-items: center;
        border-top-left-radius: .5rem; border-top-right-radius: .5rem;
    }
    .dashboard-title { margin:0; font-size: 1.6em; font-weight: 600; }
    .dashboard-subtitle { margin: 4px 0 0; font-size: 0.9em; opacity: 0.9; }
    .dashboard-header .dashboard-action-button { font-size: 0.9em; padding: 8px 15px; font-weight:500; }
    .dashboard-header .dashboard-action-button .icon { margin-right: 5px; }

    .card-body { padding: 25px; }

    .dashboard-section { margin-bottom: 35px; }
    .dashboard-section:last-child { margin-bottom: 0; }
    .dashboard-section-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #e9ecef;
    }
    .dashboard-section-header h4 { margin: 0; color: #334155; font-size: 1.2em; font-weight: 600; }
    .filter-form-inline { display: flex; gap: 8px; align-items: center; }
    .filter-form-inline .form-control-sm { max-width: 180px; font-size:0.85rem; padding: .3rem .6rem; }
    .filter-form-inline .btn-sm { font-size:0.85rem; padding: .3rem .75rem; }
    .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }

    .table-dashboard { font-size: 0.88em; }
    .table-dashboard thead th {
        background-color: #f8f9fa; color: #495057; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.8em; padding: 10px 12px;
        border-bottom-width: 2px;
    }
    .table-dashboard tbody td { padding: 10px 12px; vertical-align: middle; color: #4b5563; }
    .table-lahan-saya tbody td { padding: 8px 12px; }
    .table-dashboard tbody tr:hover { background-color: #f1f5f9; }
    .table-link-lahan { color: #00796B; font-weight: 500; text-decoration: none; }
    .table-link-lahan:hover { text-decoration: underline; color: #004d40; }
    .table-thumbnail-inline { width: 60px; height: 40px; object-fit: cover; border-radius: 4px; margin-left: 10px; vertical-align: middle; border: 1px solid #ddd;}
    .text-muted-light { color: #6c757d; }
    .font-weight-bold { font-weight: 600 !important; }

    .badge.status-badge { display: inline-block; padding: .4em .7em; font-size: .75em; font-weight: 700; line-height: 1; color: #fff; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .3rem; }
    .status-menunggu-persetujuan { background-color: #f59e0b; color: white;}
    .status-disetujui { background-color: #10b981; }
    .status-ditolak { background-color: #ef4444; }
    .status-dibatalkan-penyewa { background-color: #64748b; }
    .status-selesai { background-color: #0ea5e9; }

    .action-buttons-cell .btn-xs { margin-right: 5px; padding: .25rem .5rem; font-size: .8rem; line-height:1.2; display: inline-flex; align-items: center; gap: 3px;}
    .action-buttons-cell .btn-xs:last-child { margin-right: 0; }
    .pesan-penyewa-tooltip { cursor: help; }
    .empty-state { border: 1px dashed #d1d5db; background-color: #f9fafb; padding: 30px; }
    .empty-state .btn-sm { font-size:0.9em; padding: 8px 15px; }
    hr.dashboard-divider { margin: 35px 0; border-top: 1px solid #e0e0e0; }

    .pagination-container { margin-top: 25px; display:flex; justify-content:center; }
    /* === PERBAIKAN UNTUK PAGINASI === */
    /* Pastikan .pagination dari Bootstrap bisa di-override jika perlu */
    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
    }
    .page-link {
        position: relative;
        display: block;
        padding: .5rem .75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #00796B; /* Warna link paginasi sesuai tema */
        background-color: #fff;
        border: 1px solid #dee2e6;
    }
    .page-link:hover {
        z-index: 2;
        color: #004d40;
        text-decoration: none;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #00796B; /* Warna background link aktif */
        border-color: #00796B;
    }
    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }
    /* ============================== */
</style>
@endpush

@push('scripts')
<script>
    function showFullMessage(buttonElement) {
        const fullMessage = buttonElement.dataset.fullmessage;
        document.getElementById('isiPesanLengkap').textContent = fullMessage;
        document.getElementById('pesanLengkapModal').style.display = 'block';
    }
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
    function closeModalOnClickOutside(event, modalId) {
        if (event.target == document.getElementById(modalId)) {
            closeModal(modalId);
        }
    }
</script>
@endpush
