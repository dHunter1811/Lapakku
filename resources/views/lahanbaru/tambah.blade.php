@extends('layouts.app')

@section('title', 'Tambah Lahan Baru - Lapakku')

{{-- Tambahkan CSS Leaflet di head --}}
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin="" />
<style>
    #mapInput {
        height: 400px;
        width: 100%;
        border-radius: 8px;
        margin-bottom: 15px;
        border: 1px solid #ced4da;
    }

    .form-control-file {
        display: block;
        width: 100%;
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
    }

    .form-control-file:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25);
    }

    .form-control-sm {
        font-size: .875rem;
        padding: .25rem .5rem;
    }

    .form-label-sm {
        font-size: .875rem;
        margin-bottom: .2rem;
        display: block;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -7.5px;
        margin-left: -7.5px;
    }

    .col-md-4,
    .col-md-6 {
        position: relative;
        width: 100%;
        padding-right: 7.5px;
        padding-left: 7.5px;
    }

    @media (min-width: 768px) {
        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    .mb-2 {
        margin-bottom: .5rem !important;
    }

    .map-search-container {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
    }

    .map-search-container input[type="text"] {
        flex-grow: 1;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="card" style="max-width: 750px; margin: 30px auto; padding: 30px;">
        <h2 style="color: #00695C; text-align:center; margin-bottom:25px; font-size: 1.8em;">Tambahkan Informasi Lahan Anda</h2>

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

        <form action="{{ route('lahanbaru.simpan') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- ... (Field Judul, Deskripsi, Tipe, Lokasi, Harga, Alamat Lengkap seperti sebelumnya) ... --}}
            <div class="form-group">
                <label for="judul">Judul Lahan / Nama Properti</label>
                <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" placeholder="Contoh: Ruko Strategis 2 Lantai di Pusat Kota" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi Lengkap Lahan</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" placeholder="Jelaskan detail lahan Anda, fasilitas, keunggulan, dll." required>{{ old('deskripsi') }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipe_lahan">Tipe Lahan</label>
                        <select name="tipe_lahan" id="tipe_lahan" class="form-control" required>
                            <option value="">-- Pilih Tipe Lahan --</option>
                            <option value="Ruko" {{ old('tipe_lahan') == 'Ruko' ? 'selected' : '' }}>Ruko</option>
                            <option value="Kios" {{ old('tipe_lahan') == 'Kios' ? 'selected' : '' }}>Kios</option>
                            <option value="Pasar" {{ old('tipe_lahan') == 'Pasar' ? 'selected' : '' }}>Tempat di Pasar</option>
                            <option value="Lahan Terbuka" {{ old('tipe_lahan') == 'Lahan Terbuka' ? 'selected' : '' }}>Lahan Terbuka</option>
                            <option value="Lainnya" {{ old('tipe_lahan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lokasi">Lokasi (Kecamatan di Banjarmasin)</label>
                        <select name="lokasi" id="lokasi" class="form-control" required>
                            <option value="">-- Pilih Lokasi --</option>
                            <option value="Banjarmasin Selatan" {{ old('lokasi') == 'Banjarmasin Selatan' ? 'selected' : '' }}>Banjarmasin Selatan</option>
                            <option value="Banjarmasin Timur" {{ old('lokasi') == 'Banjarmasin Timur' ? 'selected' : '' }}>Banjarmasin Timur</option>
                            <option value="Banjarmasin Barat" {{ old('lokasi') == 'Banjarmasin Barat' ? 'selected' : '' }}>Banjarmasin Barat</option>
                            <option value="Banjarmasin Tengah" {{ old('lokasi') == 'Banjarmasin Tengah' ? 'selected' : '' }}>Banjarmasin Tengah</option>
                            <option value="Banjarmasin Utara" {{ old('lokasi') == 'Banjarmasin Utara' ? 'selected' : '' }}>Banjarmasin Utara</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="harga_sewa">Harga Sewa (per bulan, dalam Rupiah)</label>
                <input type="number" name="harga_sewa" id="harga_sewa" class="form-control" value="{{ old('harga_sewa') }}" placeholder="Contoh: 5000000" required min="1">
            </div>
            <div class="form-group">
                <label for="alamat_lengkap">Alamat Lengkap Lahan</label>
                <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control" rows="3" placeholder="Contoh: Jl. Pramuka No. 10, RT 05 RW 02, Kel. Pemurus Luar (Selain Kecamatan)" required>{{ old('alamat_lengkap') }}</textarea>
            </div>
            {{-- INPUT BARU UNTUK NOMOR WHATSAPP --}}
            <div class="form-group">
                <label for="no_whatsapp" class="form-label">Nomor WhatsApp untuk Penyewa</label>
                <input type="tel" name="no_whatsapp" id="no_whatsapp" class="form-control" value="{{ old('no_whatsapp') }}" placeholder="Contoh: 081234567890 (awali dengan 0)">
                <small class="form-text text-muted">Nomor ini akan ditampilkan kepada calon penyewa agar bisa menghubungi Anda via WhatsApp. Kosongkan jika tidak ingin menampilkan.</small>
            </div>

            {{-- Peta Interaktif untuk Input Lokasi --}}
            <div class="form-group">
                <label for="mapInput">Tandai Lokasi di Peta:</label>
                <div class="map-search-container">
                    <input type="text" id="mapSearchInput" class="form-control form-control-sm" placeholder="Cari alamat atau tempat...">
                    <button type="button" id="mapSearchButton" class="btn btn-info btn-sm">Cari</button>
                </div>
                <div id="mapInput"></div>
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                <small class="form-text text-muted">Klik pada peta untuk menentukan lokasi lahan Anda. Anda juga bisa mencari alamat.</small>
                @error('latitude') <span class="text-danger d-block">{{ $message }}</span> @enderror
                @error('longitude') <span class="text-danger d-block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Keuntungan Lokasi Ini (Sebutkan beberapa poin):</label>
                @for ($i = 0; $i < 4; $i++)
                    <input type="text" name="keuntungan_lokasi[]" class="form-control mb-2" value="{{ old('keuntungan_lokasi.'.$i) }}" placeholder="Keuntungan {{ $i + 1 }}">
                    @endfor
                    <small class="form-text text-muted">Isi minimal satu atau beberapa keuntungan utama lokasi Anda.</small>
            </div>

            <div class="form-group">
                <label for="gambar_utama">Gambar Utama Lahan</label>
                <input type="file" name="gambar_utama" id="gambar_utama" class="form-control-file" accept="image/png, image/jpeg, image/jpg, image/gif" required>
                <small class="form-text text-muted">Format: JPG, PNG, GIF. Maks: 2MB.</small>
            </div>

            <div class="form-group">
                <label>Galeri Lokasi (Opsional, maksimal 3 gambar)</label>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label for="galeri_1" class="form-label-sm">Gambar Galeri 1</label>
                        <input type="file" name="galeri_1" id="galeri_1" class="form-control-file form-control-sm" accept="image/png, image/jpeg, image/jpg, image/gif">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="galeri_2" class="form-label-sm">Gambar Galeri 2</label>
                        <input type="file" name="galeri_2" id="galeri_2" class="form-control-file form-control-sm" accept="image/png, image/jpeg, image/jpg, image/gif">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="galeri_3" class="form-label-sm">Gambar Galeri 3</label>
                        <input type="file" name="galeri_3" id="galeri_3" class="form-control-file form-control-sm" accept="image/png, image/jpeg, image/jpg, image/gif">
                    </div>
                </div>
                <small class="form-text text-muted">Format: JPG, PNG, GIF. Maks: 2MB per gambar.</small>
            </div>

            <div class="form-group" style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 1.1em;">Simpan dan Ajukan Lahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

{{-- Tambahkan JavaScript Leaflet di akhir body --}}
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Koordinat default (Banjarmasin)
        let defaultLat = -3.3173; // Perkiraan tengah Banjarmasin
        let defaultLng = 114.5900;
        let defaultZoom = 13;

        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const mapSearchInput = document.getElementById('mapSearchInput');
        const mapSearchButton = document.getElementById('mapSearchButton');

        // Inisialisasi peta
        const map = L.map('mapInput').setView([defaultLat, defaultLng], defaultZoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let marker = null;

        // Jika ada nilai old latitude dan longitude (misalnya dari error validasi), set marker awal
        if (latInput.value && lngInput.value) {
            const oldLat = parseFloat(latInput.value);
            const oldLng = parseFloat(lngInput.value);
            if (!isNaN(oldLat) && !isNaN(oldLng)) {
                marker = L.marker([oldLat, oldLng]).addTo(map);
                map.setView([oldLat, oldLng], 16); // Zoom lebih dekat ke marker yang sudah ada
            }
        }

        map.on('click', function(e) {
            if (marker) { // Jika marker sudah ada, pindahkan
                marker.setLatLng(e.latlng);
            } else { // Jika belum ada, buat marker baru
                marker = L.marker(e.latlng).addTo(map);
            }
            latInput.value = e.latlng.lat.toFixed(7);
            lngInput.value = e.latlng.lng.toFixed(7);
        });

        // Fungsi pencarian alamat
        mapSearchButton.addEventListener('click', function() {
            const address = mapSearchInput.value;
            if (address.trim() === '') return;

            // Menggunakan Nominatim OpenStreetMap untuk Geocoding
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lon = parseFloat(data[0].lon);
                        map.setView([lat, lon], 16); // Zoom ke lokasi yang dicari
                        if (marker) {
                            marker.setLatLng([lat, lon]);
                        } else {
                            marker = L.marker([lat, lon]).addTo(map);
                        }
                        latInput.value = lat.toFixed(7);
                        lngInput.value = lon.toFixed(7);
                    } else {
                        alert('Alamat tidak ditemukan. Coba kata kunci yang lebih spesifik atau tandai manual di peta.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mencari alamat.');
                });
        });
    });
</script>
@endpush