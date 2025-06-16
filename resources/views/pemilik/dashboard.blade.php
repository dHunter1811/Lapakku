@extends('layouts.app')

@section('title', 'Dashboard Pemilik Lahan - Lapakku')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    :root {
        --primary-color: #00796B;
        --primary-hover: #00695C;
        --secondary-color: #6c757d;
        --secondary-hover: #5a6268;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --info-color: #0ea5e9;
        --light-gray: #f8f9fa;
        --medium-gray: #e9ecef;
        --dark-gray: #334155;
        --text-color: #2d3748;
        --text-light: #64748b;
        --border-radius: 8px;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --transition: all 0.3s ease;
    }

    .dashboard-container {
        padding: 2rem 0;
    }

    .dashboard-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .dashboard-header {
        background-color: var(--primary-color);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .dashboard-title {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 700;
    }

    .dashboard-subtitle {
        margin: 0.25rem 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .btn-add-land {
        background-color: white;
        color: var(--primary-color);
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add-land:hover {
        background-color: rgba(255,255,255,0.9);
        color: var(--primary-hover);
        transform: translateY(-1px);
    }

    .dashboard-section {
        margin-bottom: 2.5rem;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--medium-gray);
    }

    .section-title {
        margin: 0;
        color: var(--dark-gray);
        font-size: 1.4rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .filter-select {
        border-radius: var(--border-radius);
        padding: 0.375rem 0.75rem;
        border: 1px solid var(--medium-gray);
        font-size: 0.875rem;
        max-width: 200px;
    }

    .btn-filter {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }

    .empty-state {
        border: 1px dashed #d1d5db;
        background-color: #f9fafb;
        padding: 2rem;
        text-align: center;
        border-radius: var(--border-radius);
    }

    .empty-state p {
        font-size: 1.1rem;
        margin-bottom: 1rem;
        color: var(--text-light);
    }

    .table-responsive {
        overflow-x: auto;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
    }

    .table {
        width: 100%;
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    .table thead th {
        background-color: var(--light-gray);
        color: var(--dark-gray);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        padding: 0.75rem 1rem;
        border-bottom: 2px solid var(--medium-gray);
    }

    .table tbody td {
        padding: 0.75rem 1rem;
        vertical-align: middle;
        color: var(--text-color);
        border-top: 1px solid var(--medium-gray);
    }

    .table tbody tr:hover {
        background-color: rgba(0, 121, 107, 0.05);
    }

    .land-link {
        color: var(--primary-color);
        font-weight: 500;
        text-decoration: none;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .land-link:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }

    .land-thumbnail {
        width: 60px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid var(--medium-gray);
    }

    .status-badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75rem;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 50rem;
    }

    .status-waiting {
        background-color: var(--warning-color);
        color: white;
    }

    .status-approved {
        background-color: var(--success-color);
        color: white;
    }

    .status-rejected {
        background-color: var(--danger-color);
        color: white;
    }

    .status-canceled {
        background-color: var(--secondary-color);
        color: white;
    }

    .status-completed {
        background-color: var(--info-color);
        color: white;
    }

    .action-btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        border-radius: 4px;
        transition: var(--transition);
    }

    .action-btn i {
        font-size: 0.9em;
    }

    .btn-view {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    .btn-view:hover {
        background-color: #bbdefb;
    }

    .btn-edit {
        background-color: #fff8e1;
        color: #ff8f00;
    }

    .btn-edit:hover {
        background-color: #ffecb3;
    }

    .btn-approve {
        background-color: #e8f5e9;
        color: var(--success-color);
    }

    .btn-approve:hover {
        background-color: #c8e6c9;
    }

    .btn-reject {
        background-color: #ffebee;
        color: var(--danger-color);
    }

    .btn-reject:hover {
        background-color: #ffcdd2;
    }

    .btn-whatsapp {
        background-color: #e8f5e9;
        color: #25D366;
    }

    .btn-whatsapp:hover {
        background-color: #c8e6c9;
    }

    .user-info {
        display: flex;
        flex-direction: column;
    }

    .user-phone {
        font-size: 0.8rem;
        color: var(--text-light);
    }

    .message-preview {
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .divider {
        margin: 2rem 0;
        border-top: 1px solid var(--medium-gray);
    }

    .pagination-container {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
    }

    .page-link {
        color: var(--primary-color);
        border: 1px solid var(--medium-gray);
    }

    .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .page-link:hover {
        color: var(--primary-hover);
        background-color: var(--light-gray);
    }

    .alert {
        border-radius: var(--border-radius);
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .filter-form {
            width: 100%;
        }
        
        .filter-select {
            max-width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container dashboard-container">
    <div class="card dashboard-card">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Dashboard Pemilik Lahan</h1>
                <p class="dashboard-subtitle">Kelola lahan dan pengajuan sewa untuk properti Anda</p>
            </div>
            <a href="{{ route('lahanbaru.tambah') }}" class="btn btn-add-land">
                <i class="fas fa-plus"></i> Tambah Lahan Baru
            </a>
        </div>
        
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif
            @if (session('info'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>{{ session('info') }}
                </div>
            @endif

            {{-- MY LANDS SECTION --}}
            <div class="dashboard-section">
                <div class="section-header">
                    <h4 class="section-title">
                        <i class="fas fa-map-marked-alt"></i> Lahan Milik Saya
                    </h4>
                </div>

                @if(!isset($lahanMilikUser) || $lahanMilikUser->isEmpty())
                    <div class="empty-state">
                        <p>Anda belum mendaftarkan lahan apapun</p>
                        <a href="{{ route('lahanbaru.tambah') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i> Daftarkan Lahan Pertama Anda
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Lahan</th>
                                    <th class="text-center">Status</th>
                                    <th>Tipe</th>
                                    <th>Lokasi</th>
                                    <th>Harga/bln</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lahanMilikUser as $index => $lahan)
                                <tr>
                                    <td>{{ ($lahanMilikUser->currentPage() - 1) * $lahanMilikUser->perPage() + $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('lahan.show', $lahan->id) }}" target="_blank" class="land-link">
                                            @if($lahan->gambar_utama)
                                                <img src="{{ Storage::url($lahan->gambar_utama) }}" alt="Thumbnail" class="land-thumbnail">
                                            @endif
                                            {{ Str::limit($lahan->judul, 30) }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <span class="status-badge status-{{ Str::slug($lahan->status) }}">
                                            {{ $lahan->status }}
                                        </span>
                                    </td>
                                    <td>{{ $lahan->tipe_lahan ?? '-' }}</td>
                                    <td>{{ $lahan->lokasi ?? '-' }}</td>
                                    <td class="font-weight-bold">Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('lahan.show', $lahan->id) }}" target="_blank" class="action-btn btn-view" title="Lihat Detail Publik">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                        <a href="{{ route('lahan.edit', $lahan->id) }}" class="action-btn btn-edit" title="Edit Lahan">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($lahanMilikUser->hasPages())
                    <div class="pagination-container">
                        {{ $lahanMilikUser->appends(['status_pengajuan' => request('status_pengajuan')])->links('pagination::bootstrap-4') }}
                    </div>
                    @endif
                @endif
            </div>

            <div class="divider"></div>

            {{-- RENTAL APPLICATIONS SECTION --}}
            <div class="dashboard-section">
                <div class="section-header">
                    <h4 class="section-title">
                        <i class="fas fa-clipboard-list"></i> Pengajuan Sewa Masuk
                    </h4>
                    <form method="GET" action="{{ route('pemilik.dashboard') }}" class="filter-form">
                        <select name="status_pengajuan" id="status_pengajuan" class="filter-select">
                            <option value="">Semua Status</option>
                            <option value="Menunggu Persetujuan" {{ request('status_pengajuan') == 'Menunggu Persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                            <option value="Disetujui" {{ request('status_pengajuan') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ request('status_pengajuan') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="Dibatalkan Penyewa" {{ request('status_pengajuan') == 'Dibatalkan Penyewa' ? 'selected' : '' }}>Dibatalkan Penyewa</option>
                            <option value="Selesai" {{ request('status_pengajuan') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-filter">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('pemilik.dashboard') }}" class="btn btn-secondary btn-filter">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                    </form>
                </div>

                @if(!isset($pengajuanMasuk) || $pengajuanMasuk->isEmpty())
                    <div class="empty-state">
                        <p>Belum ada pengajuan sewa untuk lahan Anda</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
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
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuanMasuk as $index => $pengajuan)
                                <tr>
                                    <td>{{ ($pengajuanMasuk->currentPage() - 1) * $pengajuanMasuk->perPage() + $index + 1 }}</td>
                                    <td>
                                        @if($pengajuan->lahan)
                                            <a href="{{ route('lahan.show', $pengajuan->lahan_id) }}" target="_blank" class="land-link">
                                                {{ Str::limit($pengajuan->lahan->judul, 25) }}
                                            </a>
                                        @else
                                            <span class="text-muted">Lahan Dihapus</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <span>{{ $pengajuan->penyewa->name ?? 'User Dihapus' }}</span>
                                            @if($pengajuan->penyewa)
                                                <span class="user-phone">
                                                    {{ $pengajuan->penyewa->no_telepon ?? $pengajuan->penyewa->email }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $pengajuan->durasi_sewa_bulan }} bulan</td>
                                    <td class="font-weight-bold">Rp {{ number_format($pengajuan->total_harga, 0, ',', '.') }}</td>
                                    <td class="message-preview" title="{{ $pengajuan->pesan_penyewa }}">
                                        {{ Str::limit($pengajuan->pesan_penyewa, 25) ?: '-' }}
                                        @if(strlen($pengajuan->pesan_penyewa) > 25)
                                        <button type="button" class="action-btn btn-view" onclick="showFullMessage(this)" data-fullmessage="{{ e($pengajuan->pesan_penyewa) }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $pengajuan->created_at->format('d M Y') }}
                                        <div class="user-phone">{{ $pengajuan->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="status-badge status-{{ Str::slug($pengajuan->status) }}">
                                            {{ $pengajuan->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($pengajuan->status == 'Menunggu Persetujuan')
                                        <form action="{{ route('pemilik.pengajuan.setujui', $pengajuan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin MENYETUJUI pengajuan ini?')">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="action-btn btn-approve" title="Setujui Pengajuan">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('pemilik.pengajuan.tolak', $pengajuan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin MENOLAK pengajuan ini?')">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="action-btn btn-reject" title="Tolak Pengajuan">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                        @elseif($pengajuan->status == 'Disetujui')
                                        <span class="text-success font-weight-bold">Telah Disetujui</span>
                                        @elseif($pengajuan->status == 'Ditolak')
                                        <span class="text-danger font-weight-bold">Telah Ditolak</span>
                                        @else
                                        <span class="text-muted">{{ $pengajuan->status }}</span>
                                        @endif
                                        
                                        @if($pengajuan->penyewa && $pengajuan->penyewa->no_telepon)
                                        <a href="https://wa.me/+62{{ $pengajuan->penyewa->no_telepon }}" target="_blank" class="action-btn btn-whatsapp" title="Hubungi via WhatsApp">
                                            <i class="fab fa-whatsapp"></i> WhatsApp
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($pengajuanMasuk->hasPages())
                    <div class="pagination-container">
                        {{ $pengajuanMasuk->appends(['lahan_page' => request('lahan_page')])->links('pagination::bootstrap-4') }}
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal for Full Message -->
<div id="pesanLengkapModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pesan Lengkap</h5>
                <button type="button" class="close" onclick="closeModal('pesanLengkapModal')">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="isiPesanLengkap"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('pesanLengkapModal')">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showFullMessage(buttonElement) {
        const fullMessage = buttonElement.dataset.fullmessage;
        document.getElementById('isiPesanLengkap').textContent = fullMessage;
        
        // Using Bootstrap modal if available, otherwise fallback to basic modal
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modal = new bootstrap.Modal(document.getElementById('pesanLengkapModal'));
            modal.show();
        } else {
            document.getElementById('pesanLengkapModal').style.display = 'block';
        }
    }

    function closeModal(modalId) {
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
            modal.hide();
        } else {
            document.getElementById(modalId).style.display = 'none';
        }
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target == document.getElementById('pesanLengkapModal')) {
            closeModal('pesanLengkapModal');
        }
    });
</script>
@endpush