@extends('layouts.app')

@section('title', 'Pusat Bantuan - Lapakku')

@section('content')
<div class="container help-center-container">
    <div class="card help-card">
        <header class="help-header text-center">
            <h1 class="page-title-help">Pusat Bantuan Lapakku</h1>
            <p class="lead-paragraph-help">
                Temukan jawaban atas pertanyaan umum seputar penggunaan platform kami.
            </p>
        </header>

        <section class="faq-section">
            <h2 class="section-title-faq">Pertanyaan Umum (FAQ)</h2>

            {{-- Kategori: Untuk Pencari Lahan --}}
            <div class="faq-category">
                <h3 class="category-title-faq">Untuk Pencari Lahan</h3>
                <div class="faq-item">
                    <details>
                        <summary class="faq-question">Bagaimana cara mencari lahan di Lapakku?</summary>
                        <div class="faq-answer">
                            <p>Anda dapat mencari lahan dengan menggunakan fitur pencarian di halaman utama atau halaman "Cari Lahan". Masukkan kata kunci seperti jenis lahan (ruko, kios), lokasi, atau fasilitas yang Anda inginkan. Anda juga bisa menggunakan filter untuk mempersempit hasil pencarian berdasarkan tipe lahan dan lokasi kecamatan.</p>
                        </div>
                    </details>
                </div>
                <div class="faq-item">
                    <details>
                        <summary class="faq-question">Bagaimana cara melihat detail informasi sebuah lahan?</summary>
                        <div class="faq-answer">
                            <p>Setelah menemukan lahan yang menarik dari hasil pencarian atau daftar lahan, klik pada judul atau tombol "Lihat Detail". Anda akan diarahkan ke halaman detail lahan yang berisi informasi lengkap seperti deskripsi, harga sewa, foto-foto, keuntungan lokasi, dan informasi kontak pemilik.</p>
                        </div>
                    </details>
                </div>
                <div class="faq-item">
                    <details>
                        <summary class="faq-question">Bagaimana cara menghubungi pemilik lahan?</summary>
                        <div class="faq-answer">
                            <p>Informasi kontak pemilik lahan (nama, email, dan nomor telepon jika tersedia) ditampilkan di halaman detail setiap lahan. Anda dapat langsung menghubungi mereka melalui detail kontak tersebut. Jika Anda mengklik tombol "Ajukan Sewa Sekarang", Anda juga bisa mengisi form pengajuan yang akan diteruskan ke pemilik lahan.</p>
                        </div>
                    </details>
                </div>
                 <div class="faq-item">
                    <details>
                        <summary class="faq-question">Apa yang harus saya lakukan setelah mengajukan sewa?</summary>
                        <div class="faq-answer">
                            <p>Setelah Anda mengirim formulir "Ajukan Sewa Sekarang", pengajuan Anda akan diteruskan kepada pemilik lahan. Pemilik lahan akan meninjau pengajuan Anda dan akan menghubungi Anda kembali jika mereka tertarik atau untuk diskusi lebih lanjut. Anda juga bisa memantau status pengajuan Anda jika kami menyediakan fitur dashboard untuk penyewa di masa mendatang.</p>
                        </div>
                    </details>
                </div>
            </div>

            {{-- Kategori: Untuk Pemilik Lahan --}}
            <div class="faq-category">
                <h3 class="category-title-faq">Untuk Pemilik Lahan</h3>
                <div class="faq-item">
                    <details>
                        <summary class="faq-question">Bagaimana cara mendaftarkan atau menambahkan lahan saya di Lapakku?</summary>
                        <div class="faq-answer">
                            <p>Anda harus memiliki akun terlebih dahulu dan login. Setelah itu, Anda bisa mengklik tombol "Tambah Lahan Baru" yang biasanya tersedia di navigasi header atau di dashboard Anda. Isi semua informasi yang diminta mengenai lahan Anda, termasuk detail, harga, foto, dan keuntungan lokasi. Setelah disubmit, lahan Anda akan ditinjau oleh admin sebelum ditampilkan.</p>
                        </div>
                    </details>
                </div>
                <div class="faq-item">
                    <details>
                        <summary class="faq-question">Bagaimana cara mengelola pengajuan sewa yang masuk untuk lahan saya?</summary>
                        <div class="faq-answer">
                            <p>Jika Anda sudah mendaftarkan lahan, Anda dapat mengakses "Dashboard Saya" (atau "Dashboard Pemilik"). Di sana, Anda akan menemukan daftar pengajuan sewa yang masuk untuk lahan-lahan Anda. Anda dapat melihat detail setiap pengajuan dan memilih untuk menyetujui atau menolaknya.</p>
                        </div>
                    </details>
                </div>
                 <div class="faq-item">
                    <details>
                        <summary class="faq-question">Apakah ada biaya untuk mendaftarkan lahan?</summary>
                        <div class="faq-answer">
                            <p>Saat ini, pendaftaran lahan di Lapakku tidak dipungut biaya (GRATIS). Kami bertujuan untuk memudahkan semua pemilik lahan memasarkan propertinya.</p>
                        </div>
                    </details>
                </div>
            </div>

            {{-- Kategori: Umum/Akun --}}
            <div class="faq-category">
                <h3 class="category-title-faq">Akun dan Umum</h3>
                <div class="faq-item">
                    <details>
                        <summary class="faq-question">Bagaimana cara membuat akun di Lapakku?</summary>
                        <div class="faq-answer">
                            <p>Klik tombol "Register" atau "Daftar" di bagian atas halaman. Isi formulir pendaftaran dengan nama, alamat email, dan password Anda. Anda juga bisa mengunggah foto profil secara opsional. Setelah itu, Anda bisa langsung login.</p>
                        </div>
                    </details>
                </div>
                <div class="faq-item">
                    <details>
                        <summary class="faq-question">Bagaimana cara mengubah informasi profil atau password saya?</summary>
                        <div class="faq-answer">
                            <p>Setelah login, klik pada nama atau foto profil Anda di header untuk membuka menu dropdown. Pilih opsi "Edit Profil Saya". Di halaman tersebut, Anda dapat memperbarui informasi pribadi Anda, termasuk mengganti password.</p>
                        </div>
                    </details>
                </div>
            </div>

            <div class="text-center" style="margin-top: 40px;">
                <p style="font-size: 1.1em;">Tidak menemukan jawaban yang Anda cari?</p>
                <a href="{{ route('kontak.show') }}" class="btn btn-primary">Hubungi Tim Support Kami</a>
            </div>
        </section>
    </div>
</div>
@endsection

@push('styles')
<style>
    .help-center-container {
        padding-top: 20px;
        padding-bottom: 40px;
    }
    .help-card {
        padding: 30px 40px;
        background-color: #fff;
    }
    .help-header {
        margin-bottom: 40px;
    }
    .page-title-help {
        font-size: 2.8em;
        color: #00695C;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .lead-paragraph-help {
        font-size: 1.25em;
        color: #555;
        max-width: 700px;
        margin: 0 auto;
    }
    .faq-section {
        margin-bottom: 30px;
    }
    .section-title-faq {
        font-size: 1.8em;
        color: #00796B;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e0f2f1;
        font-weight: 600;
    }
    .faq-category {
        margin-bottom: 30px;
    }
    .category-title-faq {
        font-size: 1.4em;
        color: #334155; /* Warna judul kategori */
        margin-bottom: 15px;
        font-weight: 600;
    }
    .faq-item {
        margin-bottom: 15px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        background-color: #f9fafb; /* Background item FAQ sedikit berbeda */
    }
    .faq-item details {
        width: 100%;
    }
    .faq-item summary {
        padding: 15px 20px;
        font-weight: 500;
        cursor: pointer;
        color: #2d3748; /* Warna pertanyaan */
        font-size: 1.1em;
        list-style: none; /* Hapus marker default */
        position: relative; /* Untuk custom marker */
    }
    .faq-item summary::-webkit-details-marker { /* Sembunyikan marker default di Chrome/Safari */
        display: none;
    }
    .faq-item summary::before { /* Custom marker (panah) */
        content: '▶'; /* Panah kanan saat tertutup */
        position: absolute;
        left: -5px; /* Geser sedikit agar tidak terlalu menempel */
        margin-right: 10px;
        font-size: 0.8em;
        color: #00796B;
        transition: transform 0.2s ease-in-out;
        top: 50%;
        transform: translateY(-50%) rotate(0deg);
    }
    .faq-item details[open] summary::before {
        transform: translateY(-50%) rotate(90deg); /* Panah bawah saat terbuka */
    }
    .faq-answer {
        padding: 0px 20px 15px 35px; /* Padding kiri lebih besar untuk mengakomodasi marker */
        line-height: 1.7;
        color: #4a5568;
        font-size: 1em;
        border-top: 1px dashed #e2e8f0; /* Garis pemisah halus saat terbuka */
        margin-top: 10px; /* Jarak dari summary */
    }
    .faq-answer p {
        margin-bottom: 0.5em;
    }
    .text-center { text-align: center; }
</style>
@endpush
