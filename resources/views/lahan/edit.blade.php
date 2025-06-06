@extends('layouts.app')

@section('title', 'Edit Lahan: ' . ($lahan->judul ?? 'Lahan'))

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
<style>
    #mapEditLahan { height: 400px; width: 100%; border-radius: 8px; margin-bottom: 10px; border: 1px solid #ced4da;}
    /* ... (Style CSS Anda yang sudah ada untuk form edit) ... */
    .edit-lahan-form .form-label { font-weight: 500; margin-bottom: 0.5rem; color: #4a5568; font-size: 0.9em; }
    .edit-lahan-form .form-control, .edit-lahan-form .form-select { border-radius: 0.375rem; border: 1px solid #cbd5e0; padding: 0.55rem 0.85rem; font-size: 0.95rem; width: 100%; box-sizing: border-box; transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; }
    .edit-lahan-form .form-control:focus, .edit-lahan-form .form-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25); }
    .edit-lahan-form .form-group { margin-bottom: 1.5rem; }
    .map-search-container-edit { display: flex; gap: 10px; margin-bottom: 10px; }
    .map-search-container-edit input[type="text"] { flex-grow: 1; }
    .current-image-display { margin-bottom: 10px; padding: 8px; border: 1px dashed #d1d5db; display: inline-block; border-radius: 6px; background-color: #f9fafb; }
    .current-image-display img { max-width: 180px; max-height: 120px; border-radius: 4px; display: block; margin-bottom: 5px; }
    .galeri-edit-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-top: 0.5rem; }
    .galeri-edit-item .form-label-sm { font-size: 0.85em; display: block; margin-bottom: 0.3rem; font-weight:500; }
    .galeri-edit-item .current-image-display img { max-width: 100px; max-height: 75px; }
    .form-actions-bottom { margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px; }
    .form-actions-bottom .btn { padding: 0.65rem 1.3rem; font-size: 0.95em; }
    .form-text.text-muted { font-size: 0.85em; color: #718096; margin-top: 0.35rem; display: block; }
    hr.form-divider { margin: 2rem 0 !important; border-top: 1px solid #e2e8f0; }
    .row { display: flex; flex-wrap: wrap; margin-right: -7.5px; margin-left: -7.5px; }
    .col-md-4, .col-md-6 { position: relative; width: 100%; padding-right: 7.5px; padding-left: 7.5px; }
    @media (min-width: 768px) {
        .col-md-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
        .col-md-6 { flex: 0 0 50%; max-width: 50%; }
    }
    .mb-2 { margin-bottom: .5rem!important; }
    .d-block { display: block !important; }
    .text-danger { color: #dc3545 !important; }
    .text-sm { font-size: 0.875em; }
</style>
@endpush

@section('content')
<div class="container">
    <div class="card" style="max-width: 750px; margin: 30px auto; padding: 30px 35px;">
        <h2 style="color: #00695C; text-align:center; margin-bottom:30px; font-size: 1.8em; font-weight:600;">Edit Informasi Lahan Anda</h2>

        @if(!isset($lahan))
            <div class="alert alert-danger text-center">Data lahan tidak ditemukan.</div>
        @else
            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom: 20px; border-left: 5px solid #c53030; background-color: #fff5f5;">
                    <strong style="display:block; margin-bottom:8px; color: #c53030;">Oops! Periksa kembali input Anda:</strong>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('lahan.update', $lahan->id) }}" method="POST" enctype="multipart/form-data" class="edit-lahan-form">
                @csrf
                @method('PUT')

                {{-- Field Judul, Deskripsi, Tipe, Lokasi, Harga, Alamat --}}
                <div class="form-group"><label for="judul" class="form-label">Judul Lahan</label><input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $lahan->judul) }}" required></div>
                <div class="form-group"><label for="deskripsi" class="form-label">Deskripsi</label><textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" required>{{ old('deskripsi', $lahan->deskripsi) }}</textarea></div>
                <div class="row">
                    <div class="col-md-6"><div class="form-group"><label for="tipe_lahan" class="form-label">Tipe Lahan</label><select name="tipe_lahan" id="tipe_lahan" class="form-control form-select" required><option value="">-- Pilih --</option><option value="Ruko" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Ruko' ? 'selected' : '' }}>Ruko</option><option value="Kios" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Kios' ? 'selected' : '' }}>Kios</option><option value="Pasar" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Pasar' ? 'selected' : '' }}>Pasar</option><option value="Lahan Terbuka" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Lahan Terbuka' ? 'selected' : '' }}>Lahan Terbuka</option><option value="Lainnya" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option></select></div></div>
                    <div class="col-md-6"><div class="form-group"><label for="lokasi" class="form-label">Lokasi</label><select name="lokasi" id="lokasi" class="form-control form-select" required><option value="">-- Pilih --</option><option value="Banjarmasin Selatan" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Selatan' ? 'selected' : '' }}>Banjarmasin Selatan</option><option value="Banjarmasin Timur" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Timur' ? 'selected' : '' }}>Banjarmasin Timur</option><option value="Banjarmasin Barat" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Barat' ? 'selected' : '' }}>Banjarmasin Barat</option><option value="Banjarmasin Tengah" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Tengah' ? 'selected' : '' }}>Banjarmasin Tengah</option><option value="Banjarmasin Utara" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Utara' ? 'selected' : '' }}>Banjarmasin Utara</option></select></div></div>
                </div>
                <div class="form-group"><label for="harga_sewa" class="form-label">Harga Sewa/bln (Rp)</label><input type="number" name="harga_sewa" id="harga_sewa" class="form-control" value="{{ old('harga_sewa', $lahan->harga_sewa) }}" required min="1"></div>
                <div class="form-group"><label for="alamat_lengkap" class="form-label">Alamat Lengkap</label><textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control" rows="3" required>{{ old('alamat_lengkap', $lahan->alamat_lengkap) }}</textarea></div>

                {{-- Peta Interaktif untuk Edit Lokasi --}}
                <div class="form-group">
                    <label for="mapEditLahan" class="form-label">Tandai Lokasi di Peta:</label>
                    <div class="map-search-container-edit">
                        <input type="text" id="mapSearchInputEdit" class="form-control form-control-sm" placeholder="Cari alamat atau tempat...">
                        <button type="button" id="mapSearchButtonEdit" class="btn btn-info btn-sm">Cari</button>
                    </div>
                    <div id="mapEditLahan"></div>
                    {{-- PASTIKAN INPUT INI ADA DAN NAME-NYA BENAR --}}
                    <input type="hidden" name="latitude" id="latitudeEdit" value="{{ old('latitude', $lahan->latitude) }}">
                    <input type="hidden" name="longitude" id="longitudeEdit" value="{{ old('longitude', $lahan->longitude) }}">
                    <small class="form-text text-muted">Klik pada peta untuk mengubah lokasi lahan Anda. Anda juga bisa mencari alamat.</small>
                    @error('latitude') <span class="text-danger d-block text-sm">{{ $message }}</span> @enderror
                    @error('longitude') <span class="text-danger d-block text-sm">{{ $message }}</span> @enderror
                </div>

                <hr class="form-divider">

                <div class="form-group">
                    <label class="form-label">Keuntungan Lokasi Ini (Beberapa poin):</label>
                    @php
                        $keuntunganDbEdit = is_array($lahan->keuntungan_lokasi) ? $lahan->keuntungan_lokasi : (is_string($lahan->keuntungan_lokasi) ? json_decode($lahan->keuntungan_lokasi, true) ?? [] : []);
                        if (!is_array($keuntunganDbEdit)) $keuntunganDbEdit = [];
                    @endphp
                    @for ($i = 0; $i < 4; $i++)
                        <input type="text" name="keuntungan_lokasi[]" class="form-control mb-2" value="{{ old('keuntungan_lokasi.'.$i, $keuntunganDbEdit[$i] ?? '') }}" placeholder="Keuntungan {{ $i + 1 }}">
                    @endfor
                    <small class="form-text text-muted">Isi poin keuntungan, kosongkan jika tidak ada.</small>
                </div>

                <hr class="form-divider">

                <div class="form-group">
                    <label for="gambar_utama" class="form-label">Gambar Utama Lahan</label>
                    @if($lahan->gambar_utama)
                        <div class="current-image-display">
                            <img src="{{ Storage::url($lahan->gambar_utama) }}" alt="Gambar Utama Saat Ini">
                            <small class="d-block text-muted">Gambar saat ini</small>
                        </div>
                    @else
                         <p class="text-muted"><small>Belum ada gambar utama.</small></p>
                    @endif
                    <input type="file" name="gambar_utama" id="gambar_utama" class="form-control" accept="image/png, image/jpeg, image/jpg, image/gif">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah. Format: JPG, PNG, GIF. Maks: 2MB.</small>
                </div>

                <hr class="form-divider">

                <div class="form-group">
                    <label class="form-label">Galeri Lokasi (Maksimal 3 gambar)</label>
                    <div class="galeri-edit-grid">
                        @for ($i = 1; $i <= 3; $i++)
                            @php $galeriField = 'galeri_' . $i; @endphp
                            <div class="galeri-edit-item">
                                <label for="{{ $galeriField }}" class="form-label-sm">Gambar Galeri {{ $i }}</label>
                                @if($lahan->$galeriField)
                                    <div class="current-image-display galeri-image-wrapper">
                                        <img src="{{ Storage::url($lahan->$galeriField) }}" alt="Galeri {{ $i }} Saat Ini">
                                    </div>
                                @endif
                                <input type="file" name="{{ $galeriField }}" id="{{ $galeriField }}" class="form-control form-control-sm" accept="image/png, image/jpeg, image/jpg, image/gif">
                                <small class="form-text text-muted">Kosongkan jika tidak diubah.</small>
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <hr class="form-divider">
                <div class="form-actions-bottom">
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.lahan.index') : route('pemilik.dashboard') }}" class="btn btn-secondary">
                        <span class="icon">⬅️</span> Batal & Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <span class="icon">💾</span> Simpan Perubahan
                    </button>
                </div>
            </form>

            @if(Auth::id() == $lahan->user_id || (Auth::check() && Auth::user()->role == 'admin'))
                <hr class="form-divider" style="margin-top:1.5rem !important;">
                <form action="{{ route('lahan.destroy', $lahan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lahan ini secara permanen? Tindakan ini tidak bisa dibatalkan.');" style="margin-top: 20px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="width: 100%;">Hapus Lahan Ini</button>
                </form>
            @endif
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
    const latInputEdit = document.getElementById('latitudeEdit');
    const lngInputEdit = document.getElementById('longitudeEdit');
    const mapSearchInputEdit = document.getElementById('mapSearchInputEdit');
    const mapSearchButtonEdit = document.getElementById('mapSearchButtonEdit');
    const mapEditContainer = document.getElementById('mapEditLahan');

    // Pastikan elemen-elemen ada sebelum melanjutkan
    if (!mapEditContainer || !latInputEdit || !lngInputEdit) {
        console.error('Elemen peta atau input koordinat tidak ditemukan.');
        if(mapEditContainer) mapEditContainer.innerHTML = '<p class="text-muted text-center" style="padding:20px;">Gagal memuat komponen peta.</p>';
        return;
    }

    let initialLat = parseFloat(latInputEdit.value) || -3.3173; // Default Banjarmasin
    let initialLng = parseFloat(lngInputEdit.value) || 114.5900;
    let initialZoom = (latInputEdit.value && lngInputEdit.value && !isNaN(parseFloat(latInputEdit.value))) ? 16 : 13;

    const mapEdit = L.map('mapEditLahan').setView([initialLat, initialLng], initialZoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mapEdit);

    let markerEdit = null;
    if (latInputEdit.value && lngInputEdit.value && !isNaN(parseFloat(latInputEdit.value))) {
        markerEdit = L.marker([initialLat, initialLng]).addTo(mapEdit);
    }

    mapEdit.on('click', function(e) {
        if (markerEdit) {
            markerEdit.setLatLng(e.latlng);
        } else {
            markerEdit = L.marker(e.latlng).addTo(mapEdit);
        }
        latInputEdit.value = e.latlng.lat.toFixed(7); // Pastikan nilai input tersembunyi diupdate
        lngInputEdit.value = e.latlng.lng.toFixed(7); // Pastikan nilai input tersembunyi diupdate
    });

    if(mapSearchButtonEdit && mapSearchInputEdit) {
        mapSearchButtonEdit.addEventListener('click', function() {
            const address = mapSearchInputEdit.value;
            if (address.trim() === '') return;
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lon = parseFloat(data[0].lon);
                        mapEdit.setView([lat, lon], 16);
                        if (markerEdit) {
                            markerEdit.setLatLng([lat, lon]);
                        } else {
                            markerEdit = L.marker([lat, lon]).addTo(mapEdit);
                        }
                        latInputEdit.value = lat.toFixed(7); // Pastikan nilai input tersembunyi diupdate
                        lngInputEdit.value = lon.toFixed(7); // Pastikan nilai input tersembunyi diupdate
                    } else {
                        alert('Alamat tidak ditemukan. Coba tandai manual di peta.');
                    }
                })
                .catch(error => {
                    console.error('Error geocoding:', error);
                    alert('Terjadi kesalahan saat mencari alamat.');
                });
        });
    }
});
</script>
@endpush
