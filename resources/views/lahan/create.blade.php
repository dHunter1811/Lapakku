@extends('layouts.app')

@section('title', 'Tambah Lahan Baru - Lapakku')

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

        <form action="{{ route('lahan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                <input type="number" name="harga_sewa" id="harga_sewa" class="form-control" value="{{ old('harga_sewa') }}" placeholder="Contoh: 5000000" required min="0">
            </div>

            <div class="form-group">
                <label for="alamat_lengkap">Alamat Lengkap Lahan</label>
                <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control" rows="3" placeholder="Contoh: Jl. Pramuka No. 10, RT 05 RW 02, Kel. Pemurus Luar (Selain Kecamatan)" required>{{ old('alamat_lengkap') }}</textarea>
            </div>

            {{-- Keuntungan Lokasi --}}
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

            {{-- Galeri Lokasi --}}
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

@push('styles')
<style>
    .form-control-file { display: block; width: 100%; padding: .375rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; }
    .form-control-file:focus { border-color: #80bdff; outline: 0; box-shadow: 0 0 0 .2rem rgba(0,123,255,.25); }
    .form-control-sm { font-size: .875rem; padding: .25rem .5rem; } /* Untuk input file galeri yang lebih kecil */
    .form-label-sm { font-size: .875rem; margin-bottom: .2rem; display: block; } /* Label untuk input file galeri */
    .row { display: flex; flex-wrap: wrap; margin-right: -7.5px; margin-left: -7.5px; }
    .col-md-4, .col-md-6 { position: relative; width: 100%; padding-right: 7.5px; padding-left: 7.5px; }
    @media (min-width: 768px) {
        .col-md-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
        .col-md-6 { flex: 0 0 50%; max-width: 50%; }
    }
    .mb-2 { margin-bottom: .5rem!important; }
</style>
@endpush
