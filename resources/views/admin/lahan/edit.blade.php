@extends('layouts.admin')

@section('title', 'Edit Lahan: ' . ($lahan->judul ?? 'Lahan') . ' - Admin Lapakku')
@section('page-title', 'Edit Detail Lahan')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin:0; font-size: 1.2em; font-weight: 600;">Formulir Edit Lahan: "{{ Str::limit($lahan->judul ?? 'Lahan Tidak Ditemukan', 40) }}"</h4>
            <a href="{{ route('admin.lahan.index') }}" class="btn btn-secondary btn-sm">
                <span class="icon">⬅️</span> Kembali ke Daftar
            </a>
        </div>
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

            <form action="{{ route('admin.lahan.update', $lahan->id) }}" method="POST" enctype="multipart/form-data" class="admin-edit-lahan-form">
                @csrf
                @method('PUT')

                {{-- Grid untuk layout 2 kolom --}}
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
                            <input type="text" id="user_display" class="form-control" value="{{ $lahan->user->name ?? 'N/A' }} ({{ $lahan->user->email ?? 'N/A' }})" readonly>
                        </div>

                        <div class="form-group">
                            <label for="harga_sewa" class="form-label">Harga Sewa (per bulan, Rp)</label>
                            <input type="number" name="harga_sewa" id="harga_sewa" class="form-control" value="{{ old('harga_sewa', $lahan->harga_sewa) }}" required min="0">
                        </div>

                        <div class="form-group">
                            <label for="tipe_lahan" class="form-label">Tipe Lahan</label>
                            <select name="tipe_lahan" id="tipe_lahan" class="form-select" required>
                                <option value="">-- Pilih Tipe --</option>
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
                                <option value="">-- Pilih Lokasi --</option>
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
                {{-- Akhir dari form-section-grid --}}

                <hr class="form-divider">

                {{-- Keuntungan Lokasi --}}
                <div class="form-group">
                    <label class="form-label section-label">Keuntungan Lokasi Ini</label>
                    @php
                        $keuntunganDb = is_array($lahan->keuntungan_lokasi) ? $lahan->keuntungan_lokasi : (is_string($lahan->keuntungan_lokasi) ? json_decode($lahan->keuntungan_lokasi, true) ?? [] : []);
                        if (!is_array($keuntunganDb)) $keuntunganDb = [];
                    @endphp
                    <div class="keuntungan-grid">
                        @for ($i = 0; $i < 4; $i++)
                            <input type="text" name="keuntungan_lokasi[]" class="form-control" value="{{ old('keuntungan_lokasi.'.$i, $keuntunganDb[$i] ?? '') }}" placeholder="Keuntungan {{ $i + 1 }}">
                        @endfor
                    </div>
                    <small class="form-text text-muted">Isi poin keuntungan (opsional), kosongkan jika tidak ada.</small>
                </div>

                <hr class="form-divider">

                {{-- Gambar Utama --}}
                <div class="form-group">
                    <label for="gambar_utama" class="form-label section-label">Gambar Utama Lahan</label>
                    @if($lahan->gambar_utama)
                        <div class="current-image-wrapper">
                            <img src="{{ Storage::url($lahan->gambar_utama) }}" alt="Gambar Utama Saat Ini" class="current-image-preview">
                            <small class="d-block text-muted">Gambar saat ini: {{ basename($lahan->gambar_utama) }}</small>
                        </div>
                    @else
                        <p class="text-muted"><small>Belum ada gambar utama.</small></p>
                    @endif
                    <input type="file" name="gambar_utama" id="gambar_utama" class="form-control file-input" accept="image/png, image/jpeg, image/jpg, image/gif">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah. Format: JPG, PNG, GIF. Maks: 2MB.</small>
                </div>

                <hr class="form-divider">

                {{-- Galeri Lokasi --}}
                <div class="form-group">
                    <label class="form-label section-label">Galeri Lokasi (Maksimal 3 gambar)</label>
                    <div class="galeri-grid">
                        @for ($i = 1; $i <= 3; $i++)
                            @php $galeriField = 'galeri_' . $i; @endphp
                            <div class="galeri-item">
                                <label for="{{ $galeriField }}" class="form-label-sm">Gambar Galeri {{ $i }}</label>
                                @if($lahan->$galeriField)
                                    <div class="current-image-wrapper galeri-image-wrapper">
                                        <img src="{{ Storage::url($lahan->$galeriField) }}" alt="Galeri {{ $i }} Saat Ini" class="current-image-preview galeri-preview">
                                    </div>
                                @endif
                                <input type="file" name="{{ $galeriField }}" id="{{ $galeriField }}" class="form-control file-input form-control-sm" accept="image/png, image/jpeg, image/jpg, image/gif">
                                <small class="form-text text-muted">Kosongkan jika tidak diubah.</small>
                            </div>
                        @endfor
                    </div>
                </div>

                <hr class="form-divider">
                <div class="form-actions">
                    <a href="{{ route('admin.lahan.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .admin-edit-lahan-form .form-label {
        font-weight: 600; /* Label lebih tebal */
        margin-bottom: 0.5rem;
        color: #4a5568; /* Warna label lebih gelap */
        font-size: 0.9em;
    }
    .admin-edit-lahan-form .form-control,
    .admin-edit-lahan-form .form-select {
        border-radius: 0.375rem; /* Border radius lebih besar */
        border: 1px solid #cbd5e0;
        padding: 0.6rem 0.9rem; /* Padding lebih nyaman */
        font-size: 0.95rem;
        width: 100%;
        box-sizing: border-box;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
    .admin-edit-lahan-form .form-control:focus,
    .admin-edit-lahan-form .form-select:focus {
        border-color: #3b82f6; /* Warna biru saat fokus */
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }
    .admin-edit-lahan-form .form-control[readonly] {
        background-color: #f3f4f6; /* Warna readonly lebih terang */
        cursor: not-allowed;
    }
    .admin-edit-lahan-form .form-group {
        margin-bottom: 1.25rem; /* Jarak antar grup form */
    }

    /* Layout Grid untuk detail utama */
    .form-section-grid {
        display: grid;
        grid-template-columns: 1fr; /* Default 1 kolom */
        gap: 0 30px; /* Jarak antar kolom */
    }
    @media (min-width: 992px) { /* Layar besar (lg) */
        .form-section-grid {
            grid-template-columns: minmax(0, 2.5fr) minmax(0, 1.5fr); /* Kolom kiri lebih lebar */
        }
    }
    .form-column .form-group:last-child {
        margin-bottom: 0;
    }

    /* Keuntungan Lokasi Grid */
    .keuntungan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 10px;
        margin-top: 0.5rem;
    }

    /* Gambar & Galeri */
    .section-label { /* Untuk label bagian seperti Keuntungan, Gambar, Galeri */
        font-size: 1.1em;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .current-image-wrapper {
        margin-bottom: 0.75rem;
        padding: 8px;
        border: 1px dashed #d1d5db;
        display: inline-block;
        border-radius: 6px;
        background-color: #f9fafb;
    }
    .current-image-preview {
        max-width: 220px; /* Preview gambar utama */
        max-height: 160px;
        border-radius: 4px;
        display: block;
    }
    .galeri-image-wrapper {
         display: flex; /* Agar gambar dan input file bisa diatur */
         flex-direction: column;
         align-items: center; /* Pusatkan gambar jika lebih kecil dari wrapper */
    }
    .galeri-preview {
        max-width: 100%; /* Gambar galeri mengisi lebar wrapper */
        max-height: 100px; /* Tinggi maksimum preview galeri */
        margin-bottom: 5px;
    }
    .galeri-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); /* Kolom galeri responsif */
        gap: 20px;
        margin-top: 0.5rem;
    }
    .galeri-item {
        border: 1px solid #e2e8f0;
        padding: 10px;
        border-radius: 6px;
        background-color: #fdfdff;
    }
    .galeri-item .form-label-sm {
        font-size: 0.85em;
        display: block;
        margin-bottom: 0.3rem;
        font-weight: 500;
    }
    .admin-edit-lahan-form .file-input { /* Style khusus untuk input file agar lebih konsisten */
        padding: 0.4rem 0.75rem;
    }
    .admin-edit-lahan-form .form-control-sm { /* Untuk input file galeri */
        font-size: 0.85rem;
        padding: .3rem .6rem;
    }


    .form-text.text-muted {
        font-size: 0.85em;
        color: #718096;
        margin-top: 0.25rem;
        display: block;
    }
    hr.form-divider {
        margin-top: 2rem !important;
        margin-bottom: 2rem !important;
        border-top: 1px solid #e2e8f0;
    }
    .form-actions {
        display: flex;
        justify-content: flex-end; /* Tombol ke kanan */
        gap: 10px; /* Jarak antar tombol */
        margin-top: 1.5rem;
    }
    .form-actions .btn {
        padding: 0.6rem 1.2rem; /* Padding tombol aksi */
        font-size: 0.95em;
    }

    /* Utility classes (jika belum ada di layout admin Anda) */
    .d-block { display: block !important; }
    .mb-1 { margin-bottom: 0.25rem !important; }
    .mb-2 { margin-bottom: 0.5rem !important; }
    .me-2 { margin-right: 0.5rem !important; }
</style>
@endpush
