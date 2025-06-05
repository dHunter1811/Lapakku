@extends('layouts.app')

@section('title', 'Dashboard Pemilik Lahan - Lapakku')

@section('content')
<div class="container">
    <div class="card dashboard-pemilik-card" style="margin-top: 30px;">
        <div class="card-header dashboard-header">
            <div>
                <h1 class="dashboard-title">Dashboard Pemilik Lahan</h1>
                <p class="dashboard-subtitle">Kelola pengajuan sewa untuk semua lahan Anda.</p>
            </div>
            {{-- Tambahkan ringkasan jika perlu, mis. Total Lahan Aktif, Total Pengajuan Menunggu --}}
            {{-- <div class="header-stats">
                <div class="stat-item"><strong>Lahan Aktif:</strong> 5</div>
                <div class="stat-item"><strong>Pengajuan Baru:</strong> 2</div>
            </div> --}}
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

            <div class="dashboard-section-header">
                <h4>Daftar Pengajuan Sewa Masuk</h4>
                {{-- Form Filter Status Pengajuan --}}
                <form method="GET" action="{{ route('pemilik.dashboard') }}" class="filter-form-inline">
                    <label for="status_pengajuan" class="form-label sr-only">Filter Status:</label>
                    <select name="status_pengajuan" id="status_pengajuan" class="form-control form-control-sm">
                        <option value="">Semua Status</option>
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
                    <p style="color:#777;">Saat ada yang mengajukan sewa, informasinya akan muncul di sini.</p>
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
                                <th>Pesan Penyewa</th>
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
                                        <a href="{{ route('lahan.show', $pengajuan->lahan_id) }}" target="_blank" class="table-link-lahan" title="{{ $pengajuan->lahan->judul }}">
                                            {{ Str::limit($pengajuan->lahan->judul, 25) }}
                                        </a>
                                    @else
                                        <span class="text-muted-light">Lahan Dihapus</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pengajuan->penyewa)
                                        <span title="{{$pengajuan->penyewa->email}}">{{ $pengajuan->penyewa->name }}</span>
                                        <br>
                                        <small class="text-muted-light">{{ $pengajuan->penyewa->no_telepon ?? $pengajuan->penyewa->email }}</small>
                                    @else
                                        <span class="text-muted-light">User Dihapus</span>
                                    @endif
                                </td>
                                <td>{{ $pengajuan->durasi_sewa_bulan }} bulan</td>
                                <td class="font-weight-bold">Rp {{ number_format($pengajuan->total_harga, 0, ',', '.') }}</td>
                                <td title="{{ $pengajuan->pesan_penyewa }}" class="pesan-penyewa-tooltip">
                                    {{ Str::limit($pengajuan->pesan_penyewa, 25) ?: '-' }}
                                </td>
                                <td>{{ $pengajuan->created_at->format('d M Y') }}<br><small class="text-muted-light">{{$pengajuan->created_at->format('H:i')}}</small></td>
                                <td class="text-center">
                                    <span class="badge status-badge status-{{ Str::slug($pengajuan->status) }}">{{ $pengajuan->status }}</span>
                                </td>
                                <td class="text-center action-buttons-cell">
                                    @if ($pengajuan->status == 'Menunggu Persetujuan')
                                    <form action="{{ route('pemilik.pengajuan.setujui', $pengajuan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin MENYETUJUI pengajuan ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-xs" title="Setujui Pengajuan">✔️ Setujui</button>
                                    </form>
                                    <form action="{{ route('pemilik.pengajuan.tolak', $pengajuan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin MENOLAK pengajuan ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger btn-xs" title="Tolak Pengajuan">❌ Tolak</button>
                                    </form>
                                    @elseif($pengajuan->status == 'Disetujui')
                                        <span class="text-success font-weight-bold">Telah Disetujui</span>
                                        {{-- Bisa tambahkan tombol 'Tandai Selesai' atau 'Batalkan Persetujuan' (dengan hati-hati) --}}
                                    @elseif($pengajuan->status == 'Ditolak')
                                        <span class="text-danger font-weight-bold">Telah Ditolak</span>
                                    @else
                                         <span class="text-muted">{{ $pengajuan->status }}</span>
                                    @endif
                                    {{-- Tombol lihat detail pesan jika pesan panjang --}}
                                    @if(strlen($pengajuan->pesan_penyewa) > 25)
                                    <button type="button" class="btn btn-outline-info btn-xs" title="Lihat Pesan Lengkap" onclick="showFullMessage(this)" data-fullmessage="{{ e($pengajuan->pesan_penyewa) }}">👁️</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($pengajuanMasuk->hasPages())
                <div style="margin-top: 25px; display:flex; justify-content:center;">
                    {{ $pengajuanMasuk->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

{{-- Modal untuk menampilkan pesan lengkap --}}
<div id="pesanLengkapModal" class="modal" onclick="closeModalOnClickOutside(event, 'pesanLengkapModal')">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pesan Lengkap dari Penyewa</h5>
                <button type="button" class="close-button" onclick="closeModal('pesanLengkapModal')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="isiPesanLengkap" style="white-space: pre-wrap;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('pesanLengkapModal')">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .dashboard-pemilik-card .card-header {
        background-color: #00796B; /* Warna hijau tema */
        color: white;
        padding: 20px 25px;
        border-bottom: none;
        border-top-left-radius: .5rem; /* Sesuaikan dengan card */
        border-top-right-radius: .5rem;
    }
    .dashboard-title { margin:0; font-size: 1.75em; font-weight: 600; }
    .dashboard-subtitle { margin: 5px 0 0; font-size: 0.95em; opacity: 0.9; }

    .dashboard-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e2e8f0;
    }
    .dashboard-section-header h4 {
        margin: 0;
        color: #334155;
        font-size: 1.25em;
        font-weight: 600;
    }
    .filter-form-inline { display: flex; gap: 10px; align-items: center; }
    .filter-form-inline .form-control-sm { max-width: 200px; font-size:0.85rem; padding: .3rem .6rem; }
    .filter-form-inline .btn-sm { font-size:0.85rem; padding: .3rem .75rem; }

    .table-dashboard { font-size: 0.9em; }
    .table-dashboard thead th {
        background-color: #f1f5f9;
        color: #475569;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85em;
        padding: 10px 12px;
    }
    .table-dashboard tbody td {
        padding: 10px 12px;
        vertical-align: middle;
        color: #4b5563;
    }
    .table-dashboard tbody tr:hover { background-color: #f8fafc; }
    .table-link-lahan { color: #00796B; font-weight: 500; text-decoration: none; }
    .table-link-lahan:hover { text-decoration: underline; }
    .text-muted-light { color: #718096; }
    .font-weight-bold { font-weight: 600; }

    .badge { display: inline-block; padding: .4em .7em; font-size: .75em; font-weight: 700; line-height: 1; color: #fff; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .3rem; }
    .status-menunggu-persetujuan { background-color: #f59e0b; color: white;}
    .status-disetujui { background-color: #10b981; }
    .status-ditolak { background-color: #ef4444; }
    .status-dibatalkan-penyewa { background-color: #64748b; }
    .status-selesai { background-color: #0ea5e9; }

    .action-buttons-cell .btn-xs { margin-right: 5px; padding: .25rem .5rem; font-size: .8rem; }
    .action-buttons-cell .btn-xs:last-child { margin-right: 0; }

    .empty-state { border: 1px dashed #d1d5db; background-color: #f9fafb; padding: 30px; }

    /* Modal Styling (jika belum ada di layout atau app.css) */
    .modal { display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6); }
    .modal-dialog { position: relative; margin: .5rem auto; pointer-events: none; max-width: 500px; } /* Bootstrap-like .modal-dialog */
    @media (min-width: 576px) { .modal-dialog { max-width: 500px; margin: 1.75rem auto; } }
    .modal-content { position: relative; display: flex; flex-direction: column; width: 100%; pointer-events: auto; background-color: #fff; background-clip: padding-box; border: 1px solid rgba(0,0,0,.2); border-radius: .3rem; outline: 0; animation-name: animatetop; animation-duration: 0.4s }
    @keyframes animatetop { from {top: -300px; opacity: 0} to {top: 0; opacity: 1} }
    .modal-header { display: flex; align-items: flex-start; justify-content: space-between; padding: 1rem 1rem; border-bottom: 1px solid #dee2e6; border-top-left-radius: calc(.3rem - 1px); border-top-right-radius: calc(.3rem - 1px); }
    .modal-title { margin-bottom: 0; line-height: 1.5; font-size: 1.25rem; }
    .modal-body { position: relative; flex: 1 1 auto; padding: 1rem; }
    .modal-footer { display: flex; flex-wrap: wrap; align-items: center; justify-content: flex-end; padding: .75rem; border-top: 1px solid #dee2e6; border-bottom-right-radius: calc(.3rem - 1px); border-bottom-left-radius: calc(.3rem - 1px); }
    .modal-footer > :not(:first-child) { margin-left: .25rem; }
    .modal-footer > :not(:last-child) { margin-right: .25rem; }
    .close-button { padding: 1rem 1rem; margin: -1rem -1rem -1rem auto; background-color: transparent; border: 0; font-size: 1.5rem; font-weight: 700; line-height: 1; color: #000; text-shadow: 0 1px 0 #fff; opacity: .5; }
    .close-button:hover { opacity: .75; }
    .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }

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
