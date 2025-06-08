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
                    <details open> {{-- Dibuat terbuka secara default --}}
                        <summary class="faq-question">
                            <span class="faq-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="faq-icon">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Bagaimana cara mencari lahan di Lapakku?
                        </summary>
                        <div class="faq-answer">
                            <p>Anda dapat mencari lahan dengan menggunakan fitur pencarian di halaman <a href="{{ route('home') }}">Home</a> atau halaman <a href="{{ route('lahan.index') }}">Cari Lahan</a>. Gunakan filter untuk mempersempit hasil berdasarkan <strong>Tipe Lahan</strong> (Ruko, Kios, dll.) dan <strong>Lokasi</strong> (Kecamatan di Banjarmasin).</p>
                        </div>
                    </details>
                </div>
                <div class="faq-item">
                    <details>
                        <summary class="faq-question">
                             <span class="faq-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="faq-icon">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Bagaimana cara menghubungi pemilik lahan?
                        </summary>
                        <div class="faq-answer">
                            <p>Ada dua cara utama untuk menghubungi pemilik:</p>
                            <ul>
                                <li><strong>Via WhatsApp:</strong> Jika pemilik menyertakan nomornya, Anda akan melihat tombol hijau "Hubungi via WhatsApp" di halaman detail lahan. Ini adalah cara tercepat untuk memulai percakapan.</li>
                                <li><strong>Via Sistem Lapakku:</strong> Klik tombol "Ajukan Sewa Sekarang". Ini akan membuka form di mana Anda bisa menentukan durasi sewa dan mengirim pesan. Pengajuan ini akan masuk ke dashboard pemilik lahan.</li>
                            </ul>
                            <p>Anda harus <a href="{{ route('login') }}">login</a> terlebih dahulu untuk bisa menggunakan kedua fitur ini.</p>
                        </div>
                    </details>
                </div>
                 <div class="faq-item">
                    <details>
                        <summary class="faq-question">
                            <span class="faq-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="faq-icon">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Apa yang terjadi setelah saya mengirim pengajuan sewa?
                        </summary>
                        <div class="faq-answer">
                            <p>Setelah Anda mengirim formulir "Ajukan Sewa Sekarang", pengajuan Anda akan langsung masuk ke "Dashboard Saya" milik pemilik lahan. Pemilik akan meninjau pengajuan Anda dan bisa menyetujui atau menolaknya. Kami menyarankan untuk juga menghubungi pemilik via WhatsApp (jika tersedia) untuk respons yang lebih cepat.</p>
                        </div>
                    </details>
                </div>
            </div>

            {{-- Kategori: Untuk Pemilik Lahan --}}
            <div class="faq-category">
                <h3 class="category-title-faq">Untuk Pemilik Lahan</h3>
                <div class="faq-item">
                    <details>
                        <summary class="faq-question">
                            <span class="faq-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="faq-icon">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Bagaimana cara mendaftarkan lahan saya?
                        </summary>
                        <div class="faq-answer">
                            <p>Sangat mudah! Pastikan Anda sudah <a href="{{ route('register') }}">membuat akun</a> dan login. Setelah itu, klik nama Anda di pojok kanan atas, lalu pilih "Tambah Lahan Baru" dari menu dropdown. Isi semua informasi yang diminta mengenai lahan Anda, termasuk detail, harga, foto, keuntungan lokasi, dan titik lokasi di peta. Setelah disubmit, lahan Anda akan ditinjau oleh admin sebelum ditampilkan di situs.</p>
                        </div>
                    </details>
                </div>
                <div class="faq-item">
                    <details>
                        <summary class="faq-question">
                             <span class="faq-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="faq-icon">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Bagaimana cara mengelola pengajuan sewa yang masuk?
                        </summary>
                        <div class="faq-answer">
                            <p>Semua pengajuan sewa untuk lahan Anda akan masuk ke halaman "Dashboard Saya". Anda bisa mengaksesnya dengan mengklik nama Anda di pojok kanan atas, lalu pilih "Dashboard Saya". Di halaman tersebut, Anda dapat melihat detail setiap pengajuan dan memilih untuk **Menyetujui** atau **Menolak**.</p>
                        </div>
                    </details>
                </div>
                 <div class="faq-item">
                    <details>
                        <summary class="faq-question">
                             <span class="faq-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="faq-icon">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Apakah ada biaya untuk mendaftarkan lahan?
                        </summary>
                        <div class="faq-answer">
                            <p>Saat ini, pendaftaran lahan di Lapakku tidak dipungut biaya (GRATIS). Kami bertujuan untuk memudahkan semua pemilik lahan memasarkan propertinya.</p>
                        </div>
                    </details>
                </div>
            </div>

            {{-- Kategori: Akun dan Keamanan (DILENGKAPI) --}}
            <div class="faq-category">
                <h3 class="category-title-faq">Akun dan Keamanan</h3>
                <div class="faq-item">
                    <details>
                        <summary class="faq-question">
                            <span class="faq-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="faq-icon">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Bagaimana cara membuat akun di Lapakku?
                        </summary>
                        <div class="faq-answer">
                            <p>Klik tombol "Register" atau "Daftar" di bagian atas halaman. Isi formulir pendaftaran dengan nama, alamat email, dan password Anda. Anda juga bisa mengunggah foto profil secara opsional. Setelah itu, Anda bisa langsung login.</p>
                        </div>
                    </details>
                </div>
                <div class="faq-item">
                    <details>
                        <summary class="faq-question">
                             <span class="faq-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="faq-icon">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Bagaimana cara mengubah informasi profil atau password saya?
                        </summary>
                        <div class="faq-answer">
                            <p>Setelah login, klik pada nama atau foto profil Anda di header untuk membuka menu dropdown. Pilih opsi "Edit Profil Saya". Di halaman tersebut, Anda dapat memperbarui informasi pribadi Anda, termasuk mengganti password.</p>
                        </div>
                    </details>
                </div>
                <div class="faq-item">
                    <details>
                        <summary class="faq-question">
                             <span class="faq-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="faq-icon">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Apakah data saya aman di Lapakku?
                        </summary>
                        <div class="faq-answer">
                            <p>Kami sangat memprioritaskan keamanan data Anda. Password Anda dienkripsi menggunakan metode hashing modern di database kami. Kami tidak akan pernah membagikan informasi pribadi Anda kepada pihak ketiga tanpa persetujuan Anda. Untuk keamanan tambahan, selalu gunakan password yang kuat dan jangan membagikannya kepada siapa pun.</p>
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
    .help-center-container { padding-top: 20px; padding-bottom: 40px; }
    .help-card { padding: 30px 40px; background-color: #fff; }
    .help-header { margin-bottom: 40px; }
    .page-title-help { font-size: 2.8em; color: #00695C; font-weight: 700; margin-bottom: 10px; }
    .lead-paragraph-help { font-size: 1.25em; color: #555; max-width: 700px; margin: 0 auto; }
    .faq-section { margin-bottom: 30px; }
    .section-title-faq { font-size: 1.8em; color: #00796B; margin-bottom: 25px; padding-bottom: 10px; border-bottom: 2px solid #e0f2f1; font-weight: 600; }
    .faq-category { margin-bottom: 30px; }
    .category-title-faq { font-size: 1.4em; color: #334155; margin-bottom: 15px; font-weight: 600; }
    .faq-item { margin-bottom: 10px; border: 1px solid #e2e8f0; border-radius: 8px; background-color: #ffffff; transition: box-shadow 0.2s ease; }
    .faq-item:hover { box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .faq-item details { width: 100%; }
    .faq-item summary {
        display: flex;
        align-items: center;
        padding: 18px 20px;
        font-weight: 500;
        cursor: pointer;
        color: #2d3748;
        font-size: 1.1em;
        list-style: none;
        outline: none;
    }
    .faq-item summary::-webkit-details-marker { display: none; }
    .faq-icon-wrapper {
        margin-right: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .faq-icon {
        width: 20px;
        height: 20px;
        color: #00796B;
        transition: transform 0.2s ease-in-out;
    }
    details[open] > summary .faq-icon {
        transform: rotate(90deg);
    }
    .faq-answer {
        padding: 0px 20px 20px 55px;
        line-height: 1.7;
        color: #4a5568;
        font-size: 1em;
        border-top: 1px dashed #e2e8f0;
        margin: 0 20px;
        padding-top: 15px;
    }
    .faq-answer p, .faq-answer ul { margin-top: 0; margin-bottom: 0.5em; }
    .faq-answer ul { padding-left: 20px; }
    .faq-answer ul li { margin-bottom: 5px; }
    .text-center { text-align: center; }
</style>
@endpush
