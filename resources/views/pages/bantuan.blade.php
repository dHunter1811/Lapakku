@extends('layouts.app')

@section('title', 'Pusat Bantuan - Lapakku')

@section('content')
<div class="container help-center-wrapper">
    <div class="card help-card">
        <header class="help-header text-center">
            <h1 class="page-title-help">Pusat Bantuan Lapakku</h1>
            <p class="lead-paragraph-help">
                Temukan jawaban atas pertanyaan umum seputar penggunaan platform kami.
            </p>
            <div class="search-help-bar">
                <input type="text" id="helpSearch" placeholder="Cari jawaban pertanyaan Anda..." class="form-control">
                <span class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.085.12c-.07.126-.14.249-.21.368l-.007.012c-.085.138-.178.27-.293.385l-.014.015A6.5 6.5 0 0 0 12.001 14a6.5 6.5 0 0 0 4.383-2.158 6.5 6.5 0 0 0-2.158-4.383L13 9l-1.258 1.344zM12.001 7a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                    </svg>
                </span>
            </div>
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

            <div class="text-center cta-bottom">
                <p>Tidak menemukan jawaban yang Anda cari?</p>
                <a href="{{ route('kontak.show') }}" class="btn btn-primary btn-lg">Hubungi Tim Support Kami</a>
            </div>
        </section>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Global Variables (consistent with home.blade.php & login.blade.php) */
    :root {
        --primary-color: #00695C;
        --primary-light: #4DB6AC;
        --primary-dark: #004D40;
        --secondary-color: #FF8F00;
        --secondary-light: #FFC107;
        --dark-color: #263238;
        --light-color: #F5F5F5;
        --gray-color: #757575;
        --light-gray: #E0E0E0;
        --white: #FFFFFF;
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 8px 16px rgba(0, 0, 0, 0.12);
        --radius: 12px;
        --transition: all 0.3s ease;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Inter', sans-serif;
        line-height: 1.6;
        color: var(--dark-color);
        background-color: var(--light-color);
    }

    .help-center-wrapper {
        padding-top: 40px;
        padding-bottom: 60px;
        min-height: calc(100vh - 70px); /* Adjust for header/footer if present */
        display: flex;
        justify-content: center;
        align-items: flex-start;
        background-color: var(--light-color); /* Atau gradien jika diinginkan */
    }

    .help-card {
        padding: 40px 50px;
        background-color: var(--white);
        border-radius: var(--radius);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Shadow yang lebih menonjol */
        width: 100%;
        max-width: 900px; /* Lebar maksimal konten */
        margin: auto; /* Pusatkan kartu */
    }

    .help-header {
        margin-bottom: 40px;
        position: relative;
        padding-bottom: 20px; /* Ruang untuk search bar */
    }

    .page-title-help {
        font-size: 3em; /* Ukuran lebih besar */
        color: var(--primary-dark); /* Warna lebih gelap */
        font-weight: 800;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .lead-paragraph-help {
        font-size: 1.2em;
        color: var(--gray-color);
        max-width: 700px;
        margin: 0 auto 30px auto; /* Margin bawah untuk search bar */
    }

    .search-help-bar {
        position: relative;
        max-width: 500px;
        margin: 0 auto;
    }

    .search-help-bar .form-control {
        width: 100%;
        padding: 12px 15px 12px 45px; /* Padding kiri untuk ikon */
        border: 1px solid var(--light-gray);
        border-radius: 50px; /* Bentuk kapsul */
        font-size: 1em;
        transition: var(--transition);
        background-color: var(--white);
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.05); /* Sedikit inner shadow */
    }

    .search-help-bar .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 105, 92, 0.15);
    }

    .search-help-bar .search-icon {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: var(--gray-color);
        width: 20px;
        height: 20px;
    }

    .faq-section {
        margin-bottom: 30px;
    }

    .section-title-faq {
        font-size: 2.2em; /* Ukuran lebih besar */
        color: var(--primary-color);
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--primary-light); /* Garis bawah yang lebih menonjol */
        font-weight: 700;
        text-align: center;
    }

    .faq-category {
        margin-bottom: 40px;
    }

    .category-title-faq {
        font-size: 1.6em; /* Ukuran lebih besar */
        color: var(--dark-color);
        margin-bottom: 20px;
        font-weight: 700;
        padding-left: 10px; /* Indentasi sedikit */
        border-left: 4px solid var(--primary-light); /* Garis vertikal sebagai penanda */
    }

    .faq-item {
        margin-bottom: 15px;
        border: 1px solid var(--light-gray);
        border-radius: 8px; /* Sudut lebih melengkung */
        background-color: var(--white);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); /* Sedikit bayangan pada setiap item */
        transition: var(--transition);
    }

    .faq-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Bayangan sedikit lebih saat hover */
    }

    .faq-item details {
        width: 100%;
    }

    .faq-item summary {
        padding: 18px 25px; /* Padding lebih besar */
        font-weight: 600;
        cursor: pointer;
        color: var(--dark-color);
        font-size: 1.1em;
        list-style: none;
        position: relative;
        outline: none; /* Hapus outline saat fokus */
        transition: background-color 0.2s ease;
    }
    .faq-item summary:hover {
        background-color: var(--light-color);
    }

    .faq-item summary::-webkit-details-marker {
        display: none;
    }
    /* Custom icon for expand/collapse */
    .faq-item summary::after {
        content: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="%2300695C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>');
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%) rotate(0deg);
        transition: transform 0.2s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .faq-item details[open] summary::after {
        transform: translateY(-50%) rotate(180deg); /* Panah ke atas saat terbuka */
    }

    .faq-answer {
        padding: 10px 25px 20px 25px; /* Padding bawah lebih besar */
        line-height: 1.8; /* Line height lebih nyaman */
        color: var(--gray-color);
        font-size: 1em;
        border-top: 1px dashed var(--light-gray); /* Garis pemisah lebih halus */
        margin-top: 10px;
    }
    .faq-answer p {
        margin-bottom: 0.5em;
    }

    .text-center { text-align: center; }

    .cta-bottom {
        margin-top: 50px; /* Margin lebih besar sebelum CTA */
        padding-top: 30px;
        border-top: 1px solid var(--light-gray);
    }

    .cta-bottom p {
        font-size: 1.2em;
        color: var(--dark-color);
        margin-bottom: 25px;
        font-weight: 600;
    }

    /* Buttons (consistent with previous designs) */
    .btn {
        padding: 14px 25px;
        font-size: 1.05em;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-radius: 50px;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block; /* Agar bisa pakai margin auto jika perlu */
        text-align: center;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: var(--white);
        box-shadow: 0 4px 10px rgba(0, 105, 92, 0.3);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 105, 92, 0.4);
    }
    .btn-lg {
        padding: 16px 30px;
        font-size: 1.15em;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .help-card {
            padding: 30px;
        }
        .page-title-help {
            font-size: 2.2em;
        }
        .lead-paragraph-help {
            font-size: 1em;
            margin-bottom: 20px;
        }
        .search-help-bar .form-control {
            padding: 10px 15px 10px 40px;
        }
        .search-help-bar .search-icon {
            width: 18px;
            height: 18px;
            left: 12px;
        }
        .section-title-faq {
            font-size: 1.8em;
            margin-bottom: 20px;
        }
        .category-title-faq {
            font-size: 1.3em;
            margin-bottom: 15px;
            padding-left: 8px;
            border-left-width: 3px;
        }
        .faq-item summary {
            padding: 15px 20px;
            font-size: 1em;
        }
        .faq-item summary::after {
            right: 15px;
            width: 18px;
            height: 18px;
        }
        .faq-answer {
            padding: 8px 20px 15px 20px;
            font-size: 0.95em;
        }
        .cta-bottom {
            margin-top: 30px;
            padding-top: 20px;
        }
        .cta-bottom p {
            font-size: 1em;
            margin-bottom: 20px;
        }
        .btn-lg {
            padding: 14px 25px;
            font-size: 1em;
        }
    }

    @media (max-width: 480px) {
        .help-center-wrapper {
            padding: 20px 10px;
        }
        .help-card {
            padding: 20px;
            border-radius: 8px;
        }
        .page-title-help {
            font-size: 1.8em;
        }
        .section-title-faq {
            font-size: 1.5em;
        }
        .category-title-faq {
            font-size: 1.2em;
        }
        .faq-item summary {
            font-size: 0.95em;
            padding: 12px 15px;
        }
        .faq-answer {
            padding: 5px 15px 10px 15px;
            font-size: 0.9em;
        }
        .btn-lg {
            padding: 12px 20px;
            font-size: 0.95em;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const helpSearch = document.getElementById('helpSearch');
    const faqItems = document.querySelectorAll('.faq-item');

    if (helpSearch) {
        helpSearch.addEventListener('keyup', function() {
            const searchTerm = helpSearch.value.toLowerCase();

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question').textContent.toLowerCase();
                const answer = item.querySelector('.faq-answer').textContent.toLowerCase();

                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block'; // Show item
                } else {
                    item.style.display = 'none'; // Hide item
                }
            });
        });
    }

    // Optional: Open relevant FAQ item if search query matches before page load
    // This requires passing search query from URL, e.g., ?q=kata_kunci
    // Example: const urlParams = new URLSearchParams(window.location.search);
    // const initialQuery = urlParams.get('q');
    // if (initialQuery && helpSearch) {
    //     helpSearch.value = initialQuery;
    //     helpSearch.dispatchEvent(new Event('keyup')); // Trigger search
    // }
});
</script>
@endpush
