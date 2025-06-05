@extends('layouts.app')

@section('title', 'Edit Lahan: ' . $lahan->judul . ' - Lapakku')

@section('content')
<div class="container">
    <div class="card" style="max-width: 750px; margin: 30px auto; padding: 30px;">
        <h2 style="color: #00695C; text-align:center; margin-bottom:25px; font-size: 1.8em;">Edit Informasi Lahan Anda</h2>

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

        <form action="{{ route('lahan.update', $lahan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="judul">Judul Lahan / Nama Properti</label>
                <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $lahan->judul) }}" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Lengkap Lahan</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" required>{{ old('deskripsi', $lahan->deskripsi) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipe_lahan">Tipe Lahan</label>
                        <select name="tipe_lahan" id="tipe_lahan" class="form-control" required>
                            <option value="">-- Pilih Tipe Lahan --</option>
                            <option value="Ruko" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Ruko' ? 'selected' : '' }}>Ruko</option>
                            <option value="Kios" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Kios' ? 'selected' : '' }}>Kios</option>
                            <option value="Pasar" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Pasar' ? 'selected' : '' }}>Tempat di Pasar</option>
                            <option value="Lahan Terbuka" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Lahan Terbuka' ? 'selected' : '' }}>Lahan Terbuka</option>
                            <option value="Lainnya" {{ old('tipe_lahan', $lahan->tipe_lahan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lokasi">Lokasi (Kecamatan di Banjarmasin)</label>
                        <select name="lokasi" id="lokasi" class="form-control" required>
                            <option value="">-- Pilih Lokasi --</option>
                            <option value="Banjarmasin Selatan" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Selatan' ? 'selected' : '' }}>Banjarmasin Selatan</option>
                            <option value="Banjarmasin Timur" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Timur' ? 'selected' : '' }}>Banjarmasin Timur</option>
                            <option value="Banjarmasin Barat" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Barat' ? 'selected' : '' }}>Banjarmasin Barat</option>
                            <option value="Banjarmasin Tengah" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Tengah' ? 'selected' : '' }}>Banjarmasin Tengah</option>
                            <option value="Banjarmasin Utara" {{ old('lokasi', $lahan->lokasi) == 'Banjarmasin Utara' ? 'selected' : '' }}>Banjarmasin Utara</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="harga_sewa">Harga Sewa (per bulan, dalam Rupiah)</label>
                <input type="number" name="harga_sewa" id="harga_sewa" class="form-control" value="{{ old('harga_sewa', $lahan->harga_sewa) }}" required min="0">
            </div>

            <div class="form-group">
                <label for="alamat_lengkap">Alamat Lengkap Lahan</label>
                <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control" rows="3" required>{{ old('alamat_lengkap', $lahan->alamat_lengkap) }}</textarea>
            </div>

            {{-- Keuntungan Lokasi --}}
            <div class="form-group">
                <label>Keuntungan Lokasi Ini (Sebutkan beberapa poin):</label>
                @php
                    // Ambil data keuntungan dari model, pastikan itu array dan default ke array kosong jika null
                    $keuntunganDb = is_array($lahan->keuntungan_lokasi) ? $lahan->keuntungan_lokasi : [];
                @endphp
                @for ($i = 0; $i < 4; $i++)
                    <input type="text" name="keuntungan_lokasi[]" class="form-control mb-2" value="{{ old('keuntungan_lokasi.'.$i, $keuntunganDb[$i] ?? '') }}" placeholder="Keuntungan {{ $i + 1 }}">
                @endfor
                <small class="form-text text-muted">Isi minimal satu atau beberapa keuntungan utama lokasi Anda.</small>
            </div>

            <div class="form-group">
                <label for="gambar_utama">Gambar Utama Lahan (Kosongkan jika tidak ingin diubah)</label>
                @if($lahan->gambar_utama)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ Storage::url($lahan->gambar_utama) }}" alt="Gambar Utama Saat Ini" style="max-width: 200px; max-height: 150px; border-radius: 4px; border: 1px solid #ddd;">
                    </div>
                @endif
                <input type="file" name="gambar_utama" id="gambar_utama" class="form-control-file" accept="image/png, image/jpeg, image/jpg, image/gif">
                <small class="form-text text-muted">Format: JPG, PNG, GIF. Maks: 2MB.</small>
            </div>

            {{-- Galeri Lokasi --}}
            <div class="form-group">
                <label>Galeri Lokasi (Opsional, maksimal 3 gambar. Kosongkan jika tidak ingin diubah)</label>
                <div class="row">
                    @for ($i = 1; $i <= 3; $i++)
                        @php $galeriField = 'galeri_' . $i; @endphp
                        <div class="col-md-4 mb-2">
                            <label for="{{ $galeriField }}" class="form-label-sm">Gambar Galeri {{ $i }}</label>
                            @if($lahan->$galeriField)
                                <div style="margin-bottom: 5px;">
                                    <img src="{{ Storage::url($lahan->$galeriField) }}" alt="Galeri {{ $i }} Saat Ini" style="max-width: 100px; max-height: 75px; border-radius: 3px; border: 1px solid #ddd;">
                                    {{-- Tambahkan opsi hapus jika perlu --}}
                                    {{-- <input type="checkbox" name="hapus_galeri_{{$i}}" value="1"> Hapus gambar ini --}}
                                </div>
                            @endif
                            <input type="file" name="{{ $galeriField }}" id="{{ $galeriField }}" class="form-control-file form-control-sm" accept="image/png, image/jpeg, image/jpg, image/gif">
                        </div>
                    @endfor
                </div>
                <small class="form-text text-muted">Format: JPG, PNG, GIF. Maks: 2MB per gambar.</small>
            </div>

            {{-- Admin bisa mengubah status jika diperlukan --}}
            @if(Auth::user()->role === 'admin')
            <div class="form-group">
                <label for="status">Status Lahan (Admin Only)</label>
                <select name="status" id="status" class="form-control">
                    <option value="Menunggu" {{ old('status', $lahan->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="Disetujui" {{ old('status', $lahan->status) == 'Disetujui' ? 'selected' : '' }}>Disetujui (Tampil)</option>
                    <option value="Ditolak" {{ old('status', $lahan->status) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            @endif

            <div class="form-group" style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 1.1em;">Simpan Perubahan</button>
            </div>
        </form>

        @if(Auth::id() == $lahan->user_id || Auth::user()->role == 'admin')
            <form action="{{ route('lahan.destroy', $lahan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lahan ini secara permanen? Tindakan ini tidak bisa dibatalkan.');" style="margin-top: 20px;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="width: 100%;">Hapus Lahan Ini</button>
            </form>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control-file { display: block; width: 100%; padding: .375rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; }
    .form-control-file:focus { border-color: #80bdff; outline: 0; box-shadow: 0 0 0 .2rem rgba(0,123,255,.25); }
    .form-control-sm { font-size: .875rem; padding: .25rem .5rem; }
    .form-label-sm { font-size: .875rem; margin-bottom: .2rem; display: block; }
    .row { display: flex; flex-wrap: wrap; margin-right: -7.5px; margin-left: -7.5px; }
    .col-md-4, .col-md-6 { position: relative; width: 100%; padding-right: 7.5px; padding-left: 7.5px; }
     @media (min-width: 768px) {
        .col-md-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
        .col-md-6 { flex: 0 0 50%; max-width: 50%; }
    }
    .mb-2 { margin-bottom: .5rem!important; }
</style>
@endpush
