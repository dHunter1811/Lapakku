@extends('layouts.app')

@section('title', ($lahan->judul ?? 'Detail Lahan') . ' - Lapakku')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" integrity="sha256-ZKX+BvQihRJPA8CROKBhDNVoc2KDAnalGrRwdLI9BGr2wLCRTTFPsy9GXoG8YhNE+JQUIY9RBpFhdNAHxTciA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    :root {
        --primary-color: #00796B;
        --primary-hover: #00695C;
        --secondary-color: #6c757d;
        --secondary-hover: #5a6268;
        --success-color: #198754;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --light-gray: #f8f9fa;
        --medium-gray: #e9ecef;
        --dark-gray: #343a40;
        --text-color: #2d3748;
        --text-light: #718096;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        --border-radius: 8px;
        --transition: all 0.3s ease;
    }

    body {
        color: var(--text-color);
        background-color: #f5f7fa;
    }

    .container {
        max-width: 1200px;
        padding: 0 15px;
    }

    /* Card styling */
    .card {
        background: white;
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        transition: var(--transition);
    }

    .card:hover {
        box-shadow: var(--shadow-md);
    }

    /* Layout */
    .lahan-detail-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
        padding: 20px;
    }

    @media (min-width: 992px) {
        .lahan-detail-container {
            grid-template-columns: minmax(0, 2.5fr) minmax(0, 1.5fr);
        }
    }

    /* Main content */
    .lahan-detail-main {
        padding: 20px;
    }

    /* Sidebar */
    .lahan-detail-sidebar {
        background-color: white;
        padding: 25px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        height: fit-content;
    }

    /* Typography */
    .lahan-title {
        color: var(--primary-color);
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .section-title {
        color: var(--primary-color);
        font-size: 1.5rem;
        font-weight: 600;
        margin: 30px 0 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--medium-gray);
        position: relative;
    }

    .section-title:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 50px;
        height: 2px;
        background: var(--primary-color);
    }

    .sidebar-subtitle {
        color: var(--primary-color);
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .lahan-text-block {
        line-height: 1.7;
        color: var(--text-color);
        font-size: 1rem;
    }

    /* Price styling */
    .lahan-harga {
        color: var(--primary-color);
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .harga-suffix {
        font-size: 0.8rem;
        color: var(--text-light);
        font-weight: 400;
    }

    /* Image styling */
    .lahan-gambar-utama {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: var(--border-radius);
        margin-bottom: 25px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .lahan-gambar-utama:hover {
        box-shadow: var(--shadow-md);
    }

    /* Gallery */
    .galeri-grid-sidebar {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 25px;
    }

    .galeri-thumbnail-link {
        display: block;
        position: relative;
        overflow: hidden;
        border-radius: var(--border-radius);
        height: 100px;
        box-shadow: var(--shadow-sm);
    }

    .galeri-thumbnail-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .galeri-thumbnail-link:hover .galeri-thumbnail-img {
        transform: scale(1.1);
    }

    .galeri-placeholder {
        width: 100%;
        height: 100px;
        background-color: var(--medium-gray);
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
        font-size: 0.9rem;
    }

    /* Map */
    #mapDisplay {
        height: 300px;
        width: 100%;
        border-radius: var(--border-radius);
        margin-bottom: 25px;
        box-shadow: var(--shadow-sm);
    }

    .map-placeholder {
        width: 100%;
        height: 300px;
        background-color: var(--medium-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--border-radius);
        color: var(--text-light);
        font-size: 0.9rem;
    }

    /* Contact info */
    .kontak-pemilik-info {
        background: var(--light-gray);
        padding: 15px;
        border-radius: var(--border-radius);
        margin-bottom: 20px;
    }

    .kontak-pemilik-info p {
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .kontak-pemilik-info strong {
        color: var(--text-color);
        font-weight: 600;
    }

    /* Buttons */
    .action-buttons-group {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }

    .action-buttons-group .btn {
        flex: 1;
        padding: 12px;
        font-size: 1rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--border-radius);
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }

    .action-buttons-group .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .action-buttons-group .btn .icon {
        margin-right: 8px;
        font-size: 1.1rem;
    }

    .btn-whatsapp {
        background-color: #25D366;
        color: white !important;
        border: none;
    }

    .btn-whatsapp:hover {
        background-color: #1DA851;
        color: white;
    }

    .btn-ajukan-sewa-sistem {
        background-color: var(--primary-color);
        color: white;
        border: none;
    }

    .btn-ajukan-sewa-sistem:hover {
        background-color: var(--primary-hover);
        color: white;
    }

    .btn-edit-lahan {
        background-color: var(--secondary-color);
        color: white;
        border: none;
        margin-top: 15px;
        padding: 10px;
        width: 100%;
        border-radius: var(--border-radius);
        transition: var(--transition);
    }

    .btn-edit-lahan:hover {
        background-color: var(--secondary-hover);
        color: white;
    }

    /* Rating section */
    .lahan-rating-section {
        margin-top: 40px;
        padding: 25px;
        border-top: 1px solid var(--medium-gray);
    }

    .rating-form-card {
        padding: 20px;
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        margin-bottom: 25px;
    }

    .user-rating-card {
        padding: 20px;
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        margin-bottom: 15px;
    }

    .rating-stars {
        color: var(--warning-color);
        margin-left: 10px;
    }

    .rating-comment {
        margin: 10px 0;
        line-height: 1.6;
        color: var(--text-color);
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: white;
        margin: 8% auto;
        padding: 0;
        border-radius: var(--border-radius);
        width: 90%;
        max-width: 550px;
        box-shadow: var(--shadow-lg);
        animation: modalFadeIn 0.4s;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid var(--medium-gray);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h4 {
        margin: 0;
        font-size: 1.4rem;
        color: var(--primary-color);
        font-weight: 600;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid var(--medium-gray);
        text-align: right;
        background-color: var(--light-gray);
        border-bottom-left-radius: var(--border-radius);
        border-bottom-right-radius: var(--border-radius);
    }

    .close-button {
        color: var(--text-light);
        font-size: 1.8rem;
        font-weight: bold;
        cursor: pointer;
        transition: var(--transition);
    }

    .close-button:hover {
        color: var(--text-color);
    }

    /* Form elements */
    .form-group {
        margin-bottom: 1.2rem;
    }

    .form-control {
        border: 1px solid var(--medium-gray);
        border-radius: var(--border-radius);
        padding: 10px 15px;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 121, 107, 0.25);
    }

    /* Utility classes */
    .text-muted {
        color: var(--text-light) !important;
    }

    .text-success {
        color: var(--success-color) !important;
    }

    .text-danger {
        color: var(--danger-color) !important;
    }

    .text-sm {
        font-size: 0.875rem !important;
    }

    .alert {
        padding: 15px;
        border-radius: var(--border-radius);
        margin-bottom: 20px;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: var(--danger-color);
        border: 1px solid #f5c6cb;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .lahan-title {
            font-size: 1.6rem;
        }
        
        .section-title {
            font-size: 1.3rem;
        }
        
        .action-buttons-group {
            flex-direction: column;
        }
        
        .galeri-grid-sidebar {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    @if(isset($lahan))
    <div class="card">
        <div class="lahan-detail-container">
            {{-- Main Content Column --}}
            <div class="lahan-detail-main">
                <h1 class="lahan-title">{{ $lahan->judul }}</h1>
                
                <img src="{{ $lahan->gambar_utama ? asset($lahan->gambar_utama) : 'https://placehold.co/1200x800/e2e8f0/94a3b8?text=Gambar+Utama' }}" 
                    alt="Gambar Utama {{ $lahan->judul }}" 
                    class="lahan-gambar-utama">
                
                <h3 class="section-title">Deskripsi Lokasi</h3>
                <div class="lahan-text-block">
                    {!! nl2br(e($lahan->deskripsi)) !!}
                </div>
                
                <h3 class="section-title">Keuntungan Lokasi Ini</h3>
                @if(!empty($lahan->keuntungan_lokasi) && is_array($lahan->keuntungan_lokasi) && count(array_filter($lahan->keuntungan_lokasi)) > 0)
                    <ul class="lahan-keuntungan-list">
                        @foreach ($lahan->keuntungan_lokasi as $keuntungan)
                            @if(!empty(trim($keuntungan)))
                            <li><i class="fas fa-check-circle text-success mr-2"></i>{{ e($keuntungan) }}</li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-light">
                        <i class="fas fa-info-circle mr-2"></i>Informasi keuntungan lokasi belum tersedia.
                    </div>
                @endif
            </div>


            {{-- Sidebar Column --}}
            <div class="lahan-detail-sidebar">
                <h2 class="lahan-harga">Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }} <span class="harga-suffix">/ bulan</span></h2>
                
                <hr class="sidebar-divider">
                
                <h4 class="sidebar-subtitle"><i class="fas fa-images mr-2"></i>Galeri Lokasi</h4>
                <div class="galeri-grid-sidebar">
                    @php 
                        $galeriImages = []; 
                        if ($lahan->galeri_1) $galeriImages[] = $lahan->galeri_1; 
                        if ($lahan->galeri_2) $galeriImages[] = $lahan->galeri_2; 
                        if ($lahan->galeri_3) $galeriImages[] = $lahan->galeri_3; 
                    @endphp
                    
                    @if(!empty($galeriImages)) 
                        @foreach($galeriImages as $index => $gPath) 
                            <a href="{{ asset($gPath) }}" data-lightbox="galeri-lahan" data-title="Galeri {{ $index + 1 }}" class="galeri-thumbnail-link">
                                <img src="{{ asset($gPath) }}" alt="Galeri Lokasi {{ $index + 1 }}" class="galeri-thumbnail-img">
                            </a> 
                        @endforeach 
                        @for ($i = count($galeriImages); $i < 3; $i++) 
                            <div class="galeri-placeholder">
                                <i class="fas fa-image"></i>
                            </div> 
                        @endfor
                    @else 
                        @for ($i = 0; $i < 3; $i++) 
                            <div class="galeri-placeholder">
                                <i class="fas fa-image"></i>
                            </div> 
                        @endfor 
                        <p class="text-muted text-center w-100" style="grid-column: 1 / -1;">
                            Tidak ada gambar galeri.
                        </p> 
                    @endif
                </div>
            </div>                
                <h4 class="sidebar-subtitle"><i class="fas fa-map-marked-alt mr-2"></i>Lokasi di Peta</h4>
                @if($lahan->latitude && $lahan->longitude)
                    <div id="mapDisplay"></div>
                @else
                    <div class="map-placeholder">
                        <i class="fas fa-map-marker-alt mr-2"></i>Lokasi peta tidak tersedia
                    </div>
                @endif
                
                <h4 class="sidebar-subtitle"><i class="fas fa-user-circle mr-2"></i>Kontak Pemilik</h4>
                <div class="kontak-pemilik-info">
                    @if($lahan->user)
                        <p><strong><i class="fas fa-user mr-2"></i>Nama:</strong> {{ $lahan->user->name }}</p>
                        <p><strong><i class="fas fa-envelope mr-2"></i>Email:</strong> {{ $lahan->user->email }}</p>
                        <p><strong><i class="fas fa-phone mr-2"></i>No. Telepon:</strong> {{ $lahan->user->no_telepon ?? '-' }}</p>
                    @else
                        <p class="text-muted">
                            <i class="fas fa-exclamation-circle mr-2"></i>Informasi pemilik tidak tersedia.
                        </p>
                    @endif
                </div>

                {{-- Action Buttons --}}
                @auth
                    @if(Auth::id() !== $lahan->user_id)
                        <div class="action-buttons-group">
                            @if($lahan->no_whatsapp)
                                @php
                                    $nomorWhatsApp = preg_replace('/[^0-9]/', '', $lahan->no_whatsapp);
                                    if (substr($nomorWhatsApp, 0, 1) === '0') {
                                        $nomorWhatsApp = '62' . substr($nomorWhatsApp, 1);
                                    } elseif (substr($nomorWhatsApp, 0, 2) !== '62') {
                                        $nomorWhatsApp = '62' . $nomorWhatsApp;
                                    }
                                    $pesanWhatsApp = urlencode("Halo, saya tertarik untuk menyewa lahan \"{$lahan->judul}\" yang saya lihat di Lapakku.");
                                @endphp
                                <a href="https://wa.me/{{ $nomorWhatsApp }}?text={{ $pesanWhatsApp }}" target="_blank" class="btn btn-whatsapp">
                                    <i class="fab fa-whatsapp icon"></i> WhatsApp
                                </a>
                            @endif

                            <button type="button" class="btn btn-ajukan-sewa-sistem" onclick="openAjukanSewaModal()">
                                <i class="fas fa-file-signature icon"></i> Ajukan Sewa
                            </button>
                        </div>
                    @else
                        <div class="alert alert-light text-center mt-3">
                            <i class="fas fa-info-circle mr-2"></i>Ini adalah lahan Anda.
                        </div>
                    @endif
                @else
                    <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login untuk Menghubungi Pemilik
                    </a>
                @endauth

                @auth
                    @if(Auth::id() == $lahan->user_id || (Auth::user() && Auth::user()->role == 'admin'))
                        <a href="{{ route('lahan.edit', $lahan->id) }}" class="btn btn-edit-lahan">
                            <i class="fas fa-edit mr-2"></i> Edit Lahan Ini
                        </a>
                    @endif
                @endauth
            </div>
        </div>
        
        {{-- Ratings Section --}}
        <div class="lahan-rating-section">
            <h3 class="section-title"><i class="fas fa-star mr-2"></i>Rating & Ulasan</h3>
            
            @auth
            <div class="rating-form-card">
                <h4><i class="fas fa-pen mr-2"></i>Beri Rating Lahan Ini</h4>
                <form action="{{ route('lahan.ratings.store', $lahan->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="rating">Rating (1-5):</label>
                        <select name="rating" id="rating" class="form-control" required>
                            <option value="">Pilih Rating</option>
                            <option value="5">⭐⭐⭐⭐⭐ (Sangat Baik)</option>
                            <option value="4">⭐⭐⭐⭐ (Baik)</option>
                            <option value="3">⭐⭐⭐ (Cukup)</option>
                            <option value="2">⭐⭐ (Kurang)</option>
                            <option value="1">⭐ (Buruk)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="komentar">Komentar Anda:</label>
                        <textarea name="komentar" id="komentar" class="form-control" rows="3" placeholder="Bagikan pengalaman Anda tentang lahan ini..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim Ulasan
                    </button>
                </form>
            </div>
            @else
            <div class="alert alert-light">
                <i class="fas fa-info-circle mr-2"></i>
                <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="text-primary">Login</a> untuk memberi rating dan ulasan.
            </div>
            @endauth

            @forelse ($lahan->ratings()->latest()->get() as $rating)
                <div class="user-rating-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>{{ $rating->user->name ?? 'Anonim' }}</strong>
                        <span class="rating-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                @if($i <= $rating->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </span>
                    </div>
                    <p class="rating-comment mt-2">{{ $rating->komentar ?? 'Tidak ada komentar.' }}</p>
                    <small class="text-muted">
                        <i class="far fa-clock mr-1"></i>{{ $rating->created_at->diffForHumans() }}
                    </small>
                </div>
            @empty
                <div class="alert alert-light">
                    <i class="fas fa-info-circle mr-2"></i>Belum ada ulasan untuk lahan ini.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Sewa Modal --}}
    @auth
    <div id="ajukanSewaModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4><i class="fas fa-file-signature mr-2"></i>Formulir Pengajuan Sewa</h4>
                <span class="close-button" onclick="closeAjukanSewaModal()">&times;</span>
            </div>
            <form action="{{ route('pengajuan-sewa.store', $lahan->id) }}" method="POST" id="formAjukanSewa">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-light mb-4">
                        <p class="mb-1">Anda akan mengajukan sewa untuk lahan:</p>
                        <h5 class="mb-0" style="color: var(--primary-color);">{{ $lahan->judul }}</h5>
                        <p class="mb-0">Harga per bulan: <strong>Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }}</strong></p>
                    </div>
                    <input type="hidden" id="hargaPerBulan" value="{{ $lahan->harga_sewa }}">

                    @if ($errors->hasBag('pengajuanSewa'))
                        <div class="alert alert-danger">
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->pengajuanSewa->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="durasi_sewa_bulan">Durasi Sewa (bulan):</label>
                        <input type="number" name="durasi_sewa_bulan" id="durasi_sewa_bulan" 
                               class="form-control" value="{{ old('durasi_sewa_bulan', 1) }}" 
                               min="1" required oninput="hitungTotalHarga()">
                    </div>

                    <div class="form-group">
                        <label for="pesan_penyewa">Pesan Tambahan untuk Pemilik (Opsional):</label>
                        <textarea name="pesan_penyewa" id="pesan_penyewa" class="form-control" rows="3" 
                                  placeholder="Contoh: Saya berencana menggunakan lahan ini untuk usaha kuliner...">{{ old('pesan_penyewa') }}</textarea>
                    </div>

                    <hr>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Estimasi Total Harga:</h5>
                        <h4 id="estimasiTotalHarga" style="color: var(--primary-color); font-weight:bold;">
                            Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }}
                        </h4>
                    </div>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-info-circle mr-1"></i>Ini adalah estimasi. Pemilik akan mengkonfirmasi total akhir.
                    </small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAjukanSewaModal()">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endauth
    @else
        <div class="alert alert-danger text-center py-4">
            <i class="fas fa-exclamation-triangle mr-2"></i>Lahan yang Anda cari tidak ditemukan atau tidak tersedia untuk ditampilkan.
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js" 
        integrity="sha256-+LoL6bQREFgIr0A6M9/uRngYleMk6S9YfGMH+zDE2IE=" 
        crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Lightbox
    if (typeof lightbox !== 'undefined') {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Gambar %1 dari %2'
        });
    }

    // Modal functions
    const ajukanSewaModal = document.getElementById('ajukanSewaModal');
    const hargaPerBulanInput = document.getElementById('hargaPerBulan');
    const durasiSewaInput = document.getElementById('durasi_sewa_bulan');
    const estimasiTotalHargaSpan = document.getElementById('estimasiTotalHarga');

    window.openAjukanSewaModal = function() {
        if(ajukanSewaModal) {
            ajukanSewaModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            hitungTotalHarga();
        }
    }

    window.closeAjukanSewaModal = function() {
        if(ajukanSewaModal) {
            ajukanSewaModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    window.hitungTotalHarga = function() {
        if (hargaPerBulanInput && durasiSewaInput && estimasiTotalHargaSpan) {
            const harga = parseFloat(hargaPerBulanInput.value);
            const durasi = parseInt(durasiSewaInput.value);
            if (!isNaN(harga) && !isNaN(durasi) && durasi >= 1) {
                const total = harga * durasi;
                estimasiTotalHargaSpan.textContent = 'Rp ' + total.toLocaleString('id-ID');
            } else {
                estimasiTotalHargaSpan.textContent = 'Rp 0';
                if (durasiSewaInput && durasiSewaInput.value < 1 && durasiSewaInput.value !== "") {
                    durasiSewaInput.value = 1;
                }
            }
        }
    }

    // Close modal when clicking outside
    if (ajukanSewaModal) {
        window.addEventListener('click', function(event) {
            if (event.target == ajukanSewaModal) {
                closeAjukanSewaModal();
            }
        });
    }

    // Initialize price calculation
    if (durasiSewaInput) {
        hitungTotalHarga();
        @if(session('open_ajukan_sewa_modal') && $errors->hasBag('pengajuanSewa'))
            openAjukanSewaModal();
        @endif
    }

    // Initialize map
    @if(isset($lahan) && $lahan->latitude && $lahan->longitude)
        const lat = {{ $lahan->latitude }};
        const lng = {{ $lahan->longitude }};
        
        const mapDisplayElement = document.getElementById('mapDisplay');
        if (mapDisplayElement) {
            try {
                const mapDisplay = L.map('mapDisplay').setView([lat, lng], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(mapDisplay);

                const greenIcon = L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                L.marker([lat, lng], {icon: greenIcon}).addTo(mapDisplay)
                    .bindPopup(`
                        <b>{{ e(Str::limit($lahan->judul, 30)) }}</b><br>
                        {{ e(Str::limit($lahan->alamat_lengkap, 40)) }}<br>
                        <small>Harga: Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }}/bulan</small>
                    `)
                    .openPopup();
            } catch (e) {
                console.error("Failed to initialize Leaflet map: ", e);
                mapDisplayElement.innerHTML = `
                    <div class="alert alert-light text-center py-3">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Gagal memuat peta. Pastikan koneksi internet Anda stabil.
                    </div>
                `;
            }
        }
    @endif
});
</script>
@endpush