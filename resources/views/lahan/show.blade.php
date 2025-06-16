@extends('layouts.app')

@section('title', ($lahan->judul ?? 'Detail Lahan') . ' - Lapakku')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" integrity="sha256-ZKX+BvQihRJPA8CROKBhDNVoc2KDAnalGrRwdLI9BGr2wLCRTTFPsy9GXoG8YhNE+JQUIY9RBpFhdNAHxTciA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    #mapDisplay { height: 300px; width: 100%; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ccc; }
    /* ... (CSS Anda yang sudah ada untuk lahan-detail-grid, galeri-placeholder, dll.) ... */
    .lahan-detail-container { display: grid; grid-template-columns: 1fr; gap: 30px; }
    @media (min-width: 992px) { .lahan-detail-container { grid-template-columns: minmax(0, 2.5fr) minmax(0, 1.5fr); } }
    .lahan-detail-main {}
    .lahan-detail-sidebar { background-color: #f9f9f9; padding: 25px; border-radius: 8px; border: 1px solid #e7e7e7; height: fit-content; }
    .lahan-gambar-utama { width: 100%; max-height: 450px; object-fit: cover; border-radius: 8px; margin-bottom: 20px; border: 1px solid #e0e0e0; }
    .section-title { color: #00796B; margin-top: 25px; margin-bottom: 10px; font-size: 1.35em; padding-bottom: 5px; border-bottom: 1px solid #e0e0e0; } /* Perubahan border-bottom */
    .lahan-text-block { line-height: 1.65; color: #454545; }
    .lahan-keuntungan-list { padding-left: 20px; line-height: 1.75; color: #454545; }
    .lahan-keuntungan-list li { margin-bottom: 5px; }
    .lahan-harga { color: #00796B; font-size: 1.9em; margin-bottom: 15px; font-weight: 600; }
    .harga-suffix { font-size:0.6em; color:#555; font-weight: 400; }
    .sidebar-divider { margin: 20px 0; border-top: 1px solid #e0e0e0; }
    .sidebar-subtitle { color: #00796B; margin-bottom: 10px; font-size: 1.15em; font-weight: 600; }
    .galeri-grid-sidebar { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 20px; }
    .galeri-thumbnail-link img.galeri-thumbnail-img { width:100%; height: 75px; object-fit: cover; border-radius:4px; border: 1px solid #ccc; transition: transform 0.2s ease; }
    .galeri-thumbnail-link:hover img.galeri-thumbnail-img { transform: scale(1.05); }
    .galeri-placeholder { width:100%; height: 75px; background-color: #e9ecef; border-radius:4px; display:flex; align-items:center; justify-content:center; color:#adb5bd; font-size:0.8em; border: 1px solid #dee2e6; }
    .map-placeholder { width: 100%; height: 180px; background-color: #e9ecef; display:flex; align-items:center; justify-content:center; border-radius:4px; margin-bottom:20px; border: 1px solid #dee2e6; color:#adb5bd; }
    .kontak-pemilik-info p { font-size:0.95em; margin-bottom:6px; color: #555; }
    .kontak-pemilik-info strong { color: #333; }
    .btn-block { width:100%; text-align:center; }
    .btn-ajukan-sewa { margin-top:15px; padding:12px; font-size:1.05em; font-weight: 500; }
    .btn-edit-lahan { margin-top:10px; padding:10px; font-size:0.95em; background-color: #6c757d; border-color: #6c757d;}
    .btn-edit-lahan:hover { background-color: #5a6268; border-color: #545b62;}

    /* === STYLE BARU UNTUK GRUP TOMBOL AKSI === */
    .action-buttons-group {
        display: flex;
        gap: 10px; /* Jarak antar tombol */
        margin-top: 15px;
    }
    .action-buttons-group .btn {
        flex: 1; /* Membuat tombol berbagi ruang */
        padding: 12px 10px;
        font-size: 0.95em;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: background-color 0.2s ease, transform 0.1s ease;
    }
    .action-buttons-group .btn:hover {
        transform: translateY(-1px);
    }
    .action-buttons-group .btn .icon {
        margin-right: 8px;
        font-size: 1.2em; /* Ukuran ikon sedikit lebih besar */
    }
    .btn-whatsapp {
        background-color: #25D366;
        color: white !important; /* !important untuk override warna link <a> */
    }
    .btn-whatsapp:hover {
        background-color: #1DA851;
    }
    .btn-ajukan-sewa-sistem {
        background-color: #00796B; /* Warna primer Anda */
        color: white;
    }
    .btn-ajukan-sewa-sistem:hover {
        background-color: #00695C;
    }
    /* === AKHIR STYLE BARU === */

    .lahan-rating-section { margin-top: 40px; padding-top:25px; border-top:1px solid #e5e5e5; }
    .rating-form-card { padding:20px; background-color:#fdfdfd; border: 1px solid #f0f0f0; }
    .user-rating-card { padding:15px; border: 1px solid #f0f0f0; }
    .rating-stars { margin-left: 10px; color: #f59e0b; }
    .rating-comment { margin-top:5px; margin-bottom:5px; line-height:1.5; color: #555; }
    .text-muted { color: #6c757d!important; }
    .text-success { color: #198754 !important; }
    .text-danger { color: #dc3545 !important; }
    .modal { display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
    .modal-content { background-color: #fefefe; margin: 8% auto; padding: 0; border: 1px solid #ddd; width: 90%; max-width: 550px; border-radius: .3rem; box-shadow: 0 5px 15px rgba(0,0,0,.5); animation-name: animatetop; animation-duration: 0.4s }
    @keyframes animatetop { from {top: -300px; opacity: 0} to {top: 0; opacity: 1} }
    .modal-header { padding: 15px 20px; border-bottom: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center; }
    .modal-header h4 { margin: 0; font-size: 1.25rem; }
    .modal-body { padding: 20px; }
    .modal-footer { padding: 15px 20px; border-top: 1px solid #e9ecef; text-align: right; background-color: #f9f9f9; border-bottom-left-radius: .3rem; border-bottom-right-radius: .3rem;}
    .modal-footer .btn { margin-left: .5rem; }
    .close-button { color: #777; font-size: 28px; font-weight: bold; }
    .close-button:hover, .close-button:focus { color: black; text-decoration: none; cursor: pointer; }
    .form-group { margin-bottom: 1rem; }
    .form-control { display: block; width: 100%; padding: .375rem .75rem; font-size: 1rem; line-height: 1.5; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; }
    .text-danger { color: #dc3545!important; } .text-sm { font-size: .875em!important; }
</style>
@endpush

@section('content')
<div class="container">
    @if(isset($lahan))
    <div class="card">
        <div class="lahan-detail-container">
            {{-- Kolom Kiri --}}
            <div class="lahan-detail-main">
                <h1 style="color: #00695C; margin-top:0; font-size: 1.8em; margin-bottom: 15px;">{{ $lahan->judul }}</h1>
                <img src="{{ $lahan->gambar_utama ? Storage::url($lahan->gambar_utama) : 'https://placehold.co/700x450/e2e8f0/94a3b8?text=Gambar+Utama' }}" alt="Gambar Utama {{ $lahan->judul }}" class="lahan-gambar-utama">
                <h3 class="section-title">Deskripsi Lokasi</h3>
                <p class="lahan-text-block">{!! nl2br(e($lahan->deskripsi)) !!}</p>
                <h3 class="section-title">Keuntungan Lokasi Ini</h3>
                @if(!empty($lahan->keuntungan_lokasi) && is_array($lahan->keuntungan_lokasi) && count(array_filter($lahan->keuntungan_lokasi)) > 0)
                    <ul class="lahan-keuntungan-list">
                        @foreach ($lahan->keuntungan_lokasi as $keuntungan)
                            @if(!empty(trim($keuntungan)))<li>{{ e($keuntungan) }}</li>@endif
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Informasi keuntungan lokasi belum tersedia.</p>
                @endif
            </div>

            {{-- Kolom Kanan --}}
            <div class="lahan-detail-sidebar">
                {{-- ... Konten Kolom Kanan (Harga, Galeri, Peta, Kontak Pemilik) ... --}}
                <h2 class="lahan-harga">Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }} <span class="harga-suffix">/ bulan</span></h2>
                <hr class="sidebar-divider">
                <h4 class="sidebar-subtitle">Galeri Lokasi</h4>
                <div class="galeri-grid-sidebar">
                    @php $galeriImages = []; if ($lahan->galeri_1) $galeriImages[] = $lahan->galeri_1; if ($lahan->galeri_2) $galeriImages[] = $lahan->galeri_2; if ($lahan->galeri_3) $galeriImages[] = $lahan->galeri_3; @endphp
                    @if(!empty($galeriImages)) @foreach($galeriImages as $index => $gPath) <a href="{{ Storage::url($gPath) }}" data-lightbox="galeri-lahan" data-title="Galeri {{ $index + 1 }}" class="galeri-thumbnail-link"><img src="{{ Storage::url($gPath) }}" alt="Galeri Lokasi {{ $index + 1 }}" class="galeri-thumbnail-img"></a> @endforeach @for ($i = count($galeriImages); $i < 3; $i++) <div class="galeri-placeholder">Galeri {{ $i + 1 }}</div> @endfor
                    @else @for ($i = 0; $i < 3; $i++) <div class="galeri-placeholder">Galeri {{ $i + 1 }}</div> @endfor <p class="text-muted-small text-center" style="grid-column: 1 / -1;">Tidak ada gambar galeri.</p> @endif
                </div>
                <h4 class="sidebar-subtitle">Lokasi di Peta</h4>
                @if($lahan->latitude && $lahan->longitude)
                    <div id="mapDisplay"></div>
                @else
                    <div class="map-placeholder">Lokasi peta tidak tersedia.</div>
                @endif
                <h4 class="sidebar-subtitle" style="margin-top:20px;">Kontak Pemilik</h4>
                <div class="kontak-pemilik-info">@if($lahan->user)<p><strong>Nama:</strong> {{ $lahan->user->name }}</p><p><strong>Email:</strong> {{ $lahan->user->email }}</p><p><strong>No. Telepon:</strong> {{ $lahan->user->no_telepon ?? '-' }}</p>@else<p class="text-muted">Informasi pemilik tidak tersedia.</p>@endif</div>

                {{-- === PERBAIKAN TOMBOL AKSI === --}}
                @auth
                    {{-- Hanya tampilkan tombol jika pengguna yang login BUKAN pemilik lahan ini --}}
                    @if(Auth::id() !== $lahan->user_id)
                        <div class="action-buttons-group">
                            {{-- Tombol WhatsApp (hanya tampil jika no_whatsapp ada) --}}
                            @if($lahan->no_whatsapp)
                                @php
                                    // Format nomor telepon ke format internasional (misal: dari 0812... menjadi 62812...)
                                    $nomorWhatsApp = preg_replace('/[^0-9]/', '', $lahan->no_whatsapp);
                                    if (substr($nomorWhatsApp, 0, 1) === '0') {
                                        $nomorWhatsApp = '62' . substr($nomorWhatsApp, 1);
                                    } elseif (substr($nomorWhatsApp, 0, 2) !== '62') {
                                        $nomorWhatsApp = '62' . $nomorWhatsApp;
                                    }
                                    // Siapkan pesan otomatis
                                    $pesanWhatsApp = urlencode("Halo, saya tertarik untuk menyewa lahan \"{$lahan->judul}\" yang saya lihat di Lapakku.");
                                @endphp
                                <a href="https://wa.me/{{ $nomorWhatsApp }}?text={{ $pesanWhatsApp }}" target="_blank" class="btn btn-whatsapp">
                                    <span class="icon">💬</span> WhatsApp
                                </a>
                            @endif

                            {{-- Tombol Ajukan Sewa via sistem (selalu ada) --}}
                            <button type="button" class="btn btn-ajukan-sewa-sistem" onclick="openAjukanSewaModal()">
                                <span class="icon">📝</span> Ajukan Sewa
                            </button>
                        </div>
                    @else
                        {{-- Jika pengguna adalah pemilik lahan --}}
                        <p class="text-muted text-center" style="margin-top:15px;">Ini adalah lahan Anda.</p>
                    @endif
                @else
                    {{-- Jika belum login --}}
                    <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn btn-primary btn-block">
                        Login untuk Menghubungi Pemilik
                    </a>
                @endauth

                @auth
                    @if(Auth::id() == $lahan->user_id || (Auth::user() && Auth::user()->role == 'admin'))
                        <a href="{{ route('lahan.edit', $lahan->id) }}" class="btn btn-secondary btn-block btn-edit-lahan">Edit Lahan Ini</a>
                    @endif
                @endauth
                {{-- ============================== --}}
            </div>
        </div>
        {{-- Bagian Rating & Ulasan dan Modal Ajukan Sewa --}}
        <div class="lahan-rating-section">
            <h3 class="section-title">Rating & Ulasan</h3>
            @auth
            <div class="card mb-3 rating-form-card">
                <h4>Beri Rating Lahan Ini</h4>
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
                        <textarea name="komentar" id="komentar" class="form-control" rows="3" placeholder="Tulis ulasan Anda di sini..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Kirim Ulasan</button>
                </form>
            </div>
            @else
            <p><a href="{{ route('login', ['redirect' => url()->current()]) }}">Login</a> untuk memberi rating dan ulasan.</p>
            @endauth

            @forelse ($lahan->ratings()->latest()->get() as $rating)
                <div class="card mb-3 user-rating-card">
                    <strong>{{ $rating->user->name ?? 'Anonim' }}</strong>
                    <span class="rating-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= $rating->rating ? '★' : '☆' }}
                        @endfor
                    </span>
                    <p class="rating-comment">{{ $rating->komentar ?? 'Tidak ada komentar.' }}</p>
                    <small class="text-muted">{{ $rating->created_at->diffForHumans() }}</small>
                </div>
            @empty
                <p class="text-muted">Belum ada ulasan untuk lahan ini.</p>
            @endforelse
        </div>
    </div>
    {{-- Modal untuk Ajukan Sewa --}}
    @auth
    <div id="ajukanSewaModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="color:#00695C;">Formulir Pengajuan Sewa</h4>
                <span class="close-button" onclick="closeAjukanSewaModal()">&times;</span>
            </div>
            <form action="{{ route('pengajuan-sewa.store', $lahan->id) }}" method="POST" id="formAjukanSewa">
                @csrf
                <div class="modal-body">
                    <p>Anda akan mengajukan sewa untuk lahan: <strong style="color:#00796B;">{{ $lahan->judul }}</strong></p>
                    <p>Harga per bulan: <strong>Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }}</strong></p>
                    <input type="hidden" id="hargaPerBulan" value="{{ $lahan->harga_sewa }}">

                    @if ($errors->hasBag('pengajuanSewa'))
                        <div class="alert alert-danger" style="font-size:0.9em; padding:10px;">
                            <ul style="margin:0; padding-left:15px;">
                                @foreach ($errors->pengajuanSewa->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="durasi_sewa_bulan">Durasi Sewa (bulan):</label>
                        <input type="number" name="durasi_sewa_bulan" id="durasi_sewa_bulan" class="form-control" value="{{ old('durasi_sewa_bulan', 1) }}" min="1" required oninput="hitungTotalHarga()">
                    </div>

                    <div class="form-group">
                        <label for="pesan_penyewa">Pesan Tambahan untuk Pemilik (Opsional):</label>
                        <textarea name="pesan_penyewa" id="pesan_penyewa" class="form-control" rows="3" placeholder="Contoh: Saya berencana menggunakan lahan ini untuk usaha kuliner...">{{ old('pesan_penyewa') }}</textarea>
                    </div>

                    <hr>
                    <h4>Estimasi Total Harga: <span id="estimasiTotalHarga" style="color:#00796B; font-weight:bold;">Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }}</span></h4>
                    <small class="text-muted">Ini adalah estimasi. Pemilik akan mengkonfirmasi total akhir.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAjukanSewaModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
    @endauth
    @else
        <div class="alert alert-danger text-center" style="margin-top: 30px;">
            Lahan yang Anda cari tidak ditemukan atau tidak tersedia untuk ditampilkan.
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
{{-- Memperbaiki tag script Lightbox2 --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js" integrity="sha256-+LoL6bQREFgIr0A6M9/uRngYleMk6S9YfGMH+zDE2IE=" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi Lightbox jika ada
    if (typeof lightbox !== 'undefined') {
        lightbox.option({
          'resizeDuration': 200,
          'wrapAround': true
        });
    }

    // Script modal Ajukan Sewa
    const ajukanSewaModal = document.getElementById('ajukanSewaModal');
    const hargaPerBulanInput = document.getElementById('hargaPerBulan');
    const durasiSewaInput = document.getElementById('durasi_sewa_bulan');
    const estimasiTotalHargaSpan = document.getElementById('estimasiTotalHarga');

    window.openAjukanSewaModal = function() { // Membuat fungsi global
        if(ajukanSewaModal) {
            ajukanSewaModal.style.display = 'block';
            hitungTotalHarga();
        }
    }
    window.closeAjukanSewaModal = function() { // Membuat fungsi global
        if(ajukanSewaModal) {
            ajukanSewaModal.style.display = 'none';
        }
    }
    window.hitungTotalHarga = function() { // Membuat fungsi global
        if (hargaPerBulanInput && durasiSewaInput && estimasiTotalHargaSpan) {
            const harga = parseFloat(hargaPerBulanInput.value);
            const durasi = parseInt(durasiSewaInput.value);
            if (!isNaN(harga) && !isNaN(durasi) && durasi >= 1) {
                const total = harga * durasi;
                estimasiTotalHargaSpan.textContent = 'Rp ' + total.toLocaleString('id-ID');
            } else {
                estimasiTotalHargaSpan.textContent = 'Rp 0';
                 if (durasiSewaInput && durasiSewaInput.value < 1 && durasiSewaInput.value !== "") durasiSewaInput.value = 1;
            }
        }
    }

    if (ajukanSewaModal) { // Hanya tambahkan event listener jika modal ada
        window.addEventListener('click', function(event) { // Menggunakan addEventListener
            if (event.target == ajukanSewaModal) {
                closeAjukanSewaModal();
            }
        });
    }

    if (durasiSewaInput) {
        hitungTotalHarga(); // Inisialisasi saat halaman dimuat
        @if(session('open_ajukan_sewa_modal') && $errors->hasBag('pengajuanSewa'))
            openAjukanSewaModal();
        @endif
    }

    // JavaScript untuk menampilkan peta di halaman detail
    @if(isset($lahan) && $lahan->latitude && $lahan->longitude)
    // Pastikan DOM sudah siap sebelum inisialisasi peta Leaflet
    // Fungsi ini sudah di dalam DOMContentLoaded dari event listener di atas
        const lat = {{ $lahan->latitude }};
        const lng = {{ $lahan->longitude }};
        
        // Periksa apakah mapDisplay ada sebelum mencoba membuat peta
        const mapDisplayElement = document.getElementById('mapDisplay');
        if (mapDisplayElement) {
            try {
                const mapDisplay = L.map('mapDisplay').setView([lat, lng], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(mapDisplay);

                L.marker([lat, lng]).addTo(mapDisplay)
                    .bindPopup('<b>{{ e(Str::limit($lahan->judul, 30)) }}</b><br>{{ e(Str::limit($lahan->alamat_lengkap, 40)) }}')
                    .openPopup();
            } catch (e) {
                console.error("Gagal menginisialisasi peta Leaflet: ", e);
                mapDisplayElement.innerHTML = '<p class="text-muted text-center" style="padding:20px;">Gagal memuat peta. Pastikan koneksi internet Anda stabil.</p>';
            }
        }
    @endif
});
</script>
@endpush

