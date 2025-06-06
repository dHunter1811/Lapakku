@extends('layouts.admin')

@section('title', 'Edit Lahan: ' . ($lahan->judul ?? 'Lahan') . ' - Admin Lapakku')
@section('page-title', 'Edit Detail Lahan')

{{-- Menambahkan CSS Leaflet di head --}}
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
<style>
    /* Styling untuk form edit lahan di panel admin */
    .admin-form .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #4a5568;
        font-size: 0.9em;
    }
    .admin-form .form-control,
    .admin-form .form-select {
        border-radius: 0.375rem;
        border: 1px solid #cbd5e0;
        padding: 0.55rem 0.85rem;
        font-size: 0.95rem;
        width: 100%;
        box-sizing: border-box;
    }
    .admin-form .form-control[readonly] {
        background-color: #f3f4f6;
        cursor: not-allowed;
    }
    .admin-form .form-group {
        margin-bottom: 1.25rem;
    }

    /* Layout Grid untuk detail utama */
    .form-section-grid {
        display: grid;
        grid-template-columns: 1fr; /* Default 1 kolom */
        gap: 0 30px;
    }
    @media (min-width: 992px) { /* Layar besar (lg) */
        .form-section-grid {
            grid-template-columns: minmax(0, 2.5fr) minmax(0, 1.5fr);
        }
    }
    .form-column .form-group:last-child {
        margin-bottom: 0;
    }

    .section-label {
        font-size: 1.1em;
        font-weight: 600;
        color: #00695C;
        margin-bottom: 1rem;
        padding-bottom: 0.6rem;
        border-bottom: 2px solid #e0f2f1;
    }

    #mapAdminEdit { height: 400px; width: 100%; border-radius: 8px; margin-bottom: 10px; border: 1px solid #ced4da; }
    .map-search-container { display: flex; gap: 10px; margin-bottom: 10px; }
    .map-search-container input[type="text"] { flex-grow: 1; }

    .current-image-wrapper {
        margin-bottom: 0.75rem;
        padding: 8px;
        border: 1px dashed #d1d5db;
        display: inline-block;
        border-radius: 6px;
        background-color: #f9fafb;
    }
    .current-image-preview {
        max-width: 220px;
        max-height: 160px;
        border-radius: 4px;
        display: block;
    }
    .galeri-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-top: 0.5rem;
    }
    .galeri-item .form-label-sm { font-size: 0.85em; display: block; margin-bottom: 0.3rem; font-weight: 500; }
    .galeri-item .current-image-wrapper img { max-width: 100%; max-height: 100px; }

    hr.form-divider {
        margin-top: 2rem !important;
        margin-bottom: 2rem !important;
        border-top: 1px solid #e2e8f0;
    }
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }
    .form-actions .btn { padding: 0.65rem 1.3rem; font-size: 0.95em; }
    .form-text.text-muted { font-size: 0.85em; color: #718096; margin-top: 0.35rem; display: block; }
    .d-block { display: block !important; }
    .mb-2 { margin-bottom: 0.5rem !important; }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h4 style="margin:0; font-size: 1.2em; font-weight: 600;">Formulir Edit Lahan: "{{ Str::limit($lahan->judul ?? 'Lahan Tidak Ditemukan', 40) }}"</h4>
    </div>
    <div class="card-body" style="padding-top: 25px;">
        @if(!isset($lahan))
            <div class="alert alert-danger">Data lahan tidak ditemukan.</div>
        @else
            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom: 20px;">
                    <strong style="display:block; margin-bottom:5px;">Oops! Ada beberapa masalah dengan input Anda:</strong>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.lahan.update', $lahan->id) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                <div class="form-section-grid">
                    {{-- Kolom Kiri --}}
                    <div class="form-column">
                        <div class="form-group">
                            <label for="judul" class="form-label">Judul Lahan</label>
                            <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $lahan->judul) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi" class="form-label">Deskripsi Lengkap</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="8" required>{{ old('deskripsi', $lahan->deskripsi) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control" rows="3" required>{{ old('alamat_lengkap', $lahan->alamat_lengkap) }}</textarea>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="form-column">
                        <div class="form-group">
                            <label for="user_display" class="form-label">Pemilik Lahan</label>
                            <input type="text" id="user_display" class="form-control" value="{{ $lahan->user->name ?? 'N/A' }} (ID: {{ $lahan->user_id }})" readonly>
                        </div>

                        <div class="form-group">
                            <label for="harga_sewa" class="form-label">Harga Sewa (per bulan, Rp)</label>
                            <input type="number" name="harga_sewa" id="harga_sewa" class="form-control" value="{{ old('harga_sewa', $lahan->harga_sewa) }}" required min="1">
                        </div>

                        {{-- NOMOR WHATSAPP DITAMBAHKAN DI SINI --}}
                        <div class="form-group">
                            <label for="no_whatsapp" class="form-label">Nomor WhatsApp</label>
                            <input type="tel" name="no_whatsapp" id="no_whatsapp" class="form-control" value="{{ old('no_whatsapp', $lahan->no_whatsapp) }}" placeholder="Contoh: 08123456xxxx">
                            <small class="form-text text-muted">Nomor ini akan digunakan untuk tombol "Hubungi via WhatsApp".</small>
                        </div>

                        <div class="form-group">
                            <label for="tipe_lahan" class="form-label">Tipe Lahan</label>
                            <select name="tipe_lahan" id="tipe_lahan" class="form-select" required>
                                <option value="Ruko" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Ruko' ? 'selected' : '' }}>Ruko</option>
                                <option value="Kios" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Kios' ? 'selected' : '' }}>Kios</option>
                                <option value="Pasar" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Pasar' ? 'selected' : '' }}>Tempat di Pasar</option>
                                <option value="Lahan Terbuka" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Lahan Terbuka' ? 'selected' : '' }}>Lahan Terbuka</option>
                                <option value="Lainnya" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="lokasi" class="form-label">Lokasi (Kecamatan)</label>
                            <select name="lokasi" id="lokasi" class="form-select" required>
                                <option value="Banjarmasin Selatan" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Selatan' ? 'selected' : '' }}>Banjarmasin Selatan</option>
                                <option value="Banjarmasin Timur" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Timur' ? 'selected' : '' }}>Banjarmasin Timur</option>
                                <option value="Banjarmasin Barat" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Barat' ? 'selected' : '' }}>Banjarmasin Barat</option>
                                <option value="Banjarmasin Tengah" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Tengah' ? 'selected' : '' }}>Banjarmasin Tengah</option>
                                <option value="Banjarmasin Utara" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Utara' ? 'selected' : '' }}>Banjarmasin Utara</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">Status Lahan</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="Menunggu" {{ old('status', $lahan->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                                <option value="Disetujui" {{ old('status', $lahan->status) == 'Disetujui' ? 'selected' : '' }}>Disetujui (Tampil)</option>
                                <option value="Ditolak" {{ old('status', $lahan->status) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="form-divider">

                <div class="form-group">
                    <label class="section-label">Peta Lokasi</label>
                    <div class="map-search-container">
                        <input type="text" id="mapSearchInputAdmin" class="form-control form-control-sm" placeholder="Cari alamat atau tempat untuk memindahkan marker...">
                        <button type="button" id="mapSearchButtonAdmin" class="btn btn-info btn-sm">Cari</button>
                    </div>
                    <div id="mapAdminEdit"></div>
                    <input type="hidden" name="latitude" id="latitudeAdmin" value="{{ old('latitude', $lahan->latitude) }}">
                    <input type="hidden" name="longitude" id="longitudeAdmin" value="{{ old('longitude', $lahan->longitude) }}">
                    <small class="form-text text-muted">Klik pada peta untuk mengubah lokasi lahan.</small>
                </div>

                <hr class="form-divider">
                {{-- Bagian lain seperti Keuntungan, Gambar, Galeri --}}

                <div class="form-actions">
                    <a href="{{ route('admin.lahan.index') }}" class="btn btn-secondary">Batal & Kembali ke Daftar</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const latInput = document.getElementById('latitudeAdmin');
    const lngInput = document.getElementById('longitudeAdmin');
    const mapContainer = document.getElementById('mapAdminEdit');
    const mapSearchInput = document.getElementById('mapSearchInputAdmin');
    const mapSearchButton = document.getElementById('mapSearchButtonAdmin');

    if (mapContainer && latInput && lngInput) {
        let initialLat = parseFloat(latInput.value) || -3.3173; // Default Banjarmasin
        let initialLng = parseFloat(lngInput.value) || 114.5900;
        let initialZoom = (latInput.value && lngInput.value && !isNaN(parseFloat(latInput.value))) ? 16 : 13;

        const map = L.map('mapAdminEdit').setView([initialLat, initialLng], initialZoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let marker = null;
        if (latInput.value && lngInput.value && !isNaN(parseFloat(latInput.value))) {
            marker = L.marker([initialLat, initialLng]).addTo(map);
        }

        map.on('click', function(e) {
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }
            latInput.value = e.latlng.lat.toFixed(7);
            lngInput.value = e.latlng.lng.toFixed(7);
        });

        if(mapSearchButton && mapSearchInput) {
            mapSearchButton.addEventListener('click', function() {
                const address = mapSearchInput.value;
                if (address.trim() === '') return;
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            map.setView([lat, lon], 16);
                            if (marker) {
                                marker.setLatLng([lat, lon]);
                            } else {
                                marker = L.marker([lat, lon]).addTo(map);
                            }
                            latInput.value = lat.toFixed(7);
                            lngInput.value = lon.toFixed(7);
                        } else {
                            alert('Alamat tidak ditemukan.');
                        }
                    })
                    .catch(error => console.error('Error geocoding:', error));
            });
        }
    }
});
</script>
@endpush
