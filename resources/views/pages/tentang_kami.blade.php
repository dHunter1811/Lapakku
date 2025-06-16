@extends('layouts.app')

@section('title', 'Tentang Kami - Lapakku')

@section('content')
<div class="container about-us-container">
    <div class="card about-us-card">
        <article>
            <header class="about-us-header text-center">
                <h1 class="page-title">Tentang Lapakku</h1>
                <p class="lead-paragraph">
                    Menghubungkan Peluang, Membangun Usaha.
                </p>
            </header>

            <section class="about-section">
                <h2 class="section-title">Selamat Datang di Lapakku!</h2>
                <p>Lapakku adalah sebuah platform digital inovatif yang lahir dari semangat untuk memberdayakan Usaha Mikro, Kecil, dan Menengah (UMKM) di Banjarmasin dan sekitarnya. Kami percaya bahwa lokasi adalah salah satu kunci utama kesuksesan sebuah usaha, dan misi kami adalah memudahkan para pelaku UMKM menemukan tempat usaha strategis yang sesuai dengan kebutuhan dan anggaran mereka.</p>
                <p>Di sisi lain, kami juga menyediakan wadah bagi para pemilik lahan atau properti untuk dapat memasarkan tempatnya kepada calon penyewa yang potensial secara lebih luas dan efisien.</p>
            </section>

            <section class="about-section team-section">
                <h2 class="section-title">Tim Pengembang Lapakku</h2>
                <p class="team-intro">Lapakku dikembangkan dengan penuh dedikasi dan semangat kolaborasi oleh tim mahasiswa dari <strong>Universitas Lambung Mangkurat, Fakultas Keguruan dan Ilmu Pendidikan, Program Studi Pendidikan Komputer</strong>. Kami berkomitmen untuk terus belajar dan berinovasi demi menghadirkan platform yang bermanfaat bagi komunitas.</p>
                <div class="team-members-grid">
                    {{-- Muhammad Dimas Aditya --}}
                    <div class="team-member-card">
                        <img src="{{ asset('images/dimas.jpg') }}" alt="Foto Muhammad Dimas Aditya" class="team-member-photo">
                        <h5 class="team-member-name">Muhammad Dimas Aditya</h5>
                        <p class="team-member-role">Pengembang Inti</p>
                        {{-- Link Sosial Media --}}
                        <div class="team-member-socials">
                            <a href="https://www.instagram.com/dimas_1811?igsh=NzNlandzcjBhbmlv" target="_blank" title="Instagram Muhammad Dimas Aditya" class="social-icon instagram">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4s1.791-4 4-4 4 1.79 4 4-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44 1.441-.645 1.441-1.44-.645-1.44-1.441-1.44z"/></svg>
                            </a>
                            <a href="https://github.com/dHunter1811" target="_blank" title="GitHub Muhammad Dimas Aditya" class="social-icon github">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                            </a>
                        </div>
                    </div>
                    {{-- Muhammad Farros Shofiy --}}
                    <div class="team-member-card">
                        <img src="{{ asset('images/farros.jpg') }}" alt="Foto Muhammad Farros Shofiy" class="team-member-photo">
                        <h5 class="team-member-name">Muhammad Farros Shofiy</h5>
                        <p class="team-member-role">Pengembang Inti</p>
                        {{-- Link Sosial Media --}}
                        <div class="team-member-socials">
                            <a href="https://instagram.com/banwave10thperiod" target="_blank" title="Instagram Muhammad Farros Shofiy" class="social-icon instagram">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4s1.791-4 4-4 4 1.79 4 4-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44 1.441-.645 1.441-1.44-.645-1.44-1.441-1.44z"/></svg>
                            </a>
                            <a href="https://github.com/KizuAnee" target="_blank" title="GitHub Muhammad Farros Shofiy" class="social-icon github">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                            </a>
                        </div>
                    </div>
                    {{-- Akhmad Rizky Rahmatullah --}}
                    <div class="team-member-card">
                        <img src="{{ asset('images/rizky.jpg') }}" alt="Foto Akhmad Rizky Rahmatullah" class="team-member-photo">
                        <h5 class="team-member-name">Akhmad Rizky Rahmatullah</h5>
                        <p class="team-member-role">Pengembang Inti</p>
                        {{-- Link Sosial Media --}}
                        <div class="team-member-socials">
                            <a href="https://instagram.com/rizkl_" target="_blank" title="Instagram Akhmad Rizky Rahmatullah" class="social-icon instagram">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4s1.791-4 4-4 4 1.79 4 4-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44 1.441-.645 1.441-1.44-.645-1.44-1.441-1.44z"/></svg>
                            </a>
                            <a href="https://github.com/omogiri" target="_blank" title="GitHub Akhmad Rizky Rahmatullah" class="social-icon github">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="about-section">
                <h2 class="section-title">Visi & Misi Kami</h2>
                <div class="row">
                    <div class="col-md-6">
                        <h5><strong>Visi</strong></h5>
                        <p>Menjadi platform penyewaan tempat usaha terdepan dan terpercaya yang mendukung pertumbuhan berkelanjutan UMKM di Kalimantan Selatan.</p>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Misi</strong></h5>
                        <ul>
                            <li>Menyediakan antarmuka yang ramah pengguna untuk pencarian dan penawaran lahan usaha.</li>
                            <li>Menjamin transparansi dan keamanan dalam setiap transaksi informasi.</li>
                            <li>Membangun komunitas yang solid antara pemilik lahan dan pelaku UMKM.</li>
                            <li>Terus berinovasi untuk memberikan fitur dan layanan terbaik.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <section class="about-section text-center">
                <h2 class="section-title">Bergabunglah dengan Kami!</h2>
                <p>Baik Anda seorang pemilik lahan yang ingin menyewakan propertinya, atau seorang wirausahawan yang sedang mencari tempat usaha ideal, Lapakku siap membantu Anda.</p>
                <a href="{{ route('lahan.index') }}" class="btn btn-primary" style="margin-right: 10px;">Cari Lahan Sekarang</a>
                <a href="{{ route('kontak.show') }}" class="btn btn-secondary">Hubungi Tim Kami</a>
            </section>
        </article>
    </div>
</div>
@endsection

@push('styles')
<style>
    .about-us-container {
        padding-top: 20px;
        padding-bottom: 40px;
    }
    .about-us-card {
        padding: 30px 40px; /* Padding lebih besar untuk card utama */
        background-color: #fff;
    }
    .about-us-header {
        margin-bottom: 40px;
    }
    .page-title {
        font-size: 2.8em; /* Ukuran judul halaman */
        color: #00695C; /* Warna tema Anda */
        font-weight: 700;
        margin-bottom: 10px;
    }
    .lead-paragraph {
        font-size: 1.25em;
        color: #555;
        max-width: 700px;
        margin: 0 auto;
    }
    .about-section {
        margin-bottom: 40px;
    }
    .section-title {
        font-size: 1.8em;
        color: #00796B; /* Warna sub-judul */
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e0f2f1; /* Garis bawah halus */
        font-weight: 600;
    }
    .about-section p, .about-section ul {
        line-height: 1.7;
        color: #4a5568; /* Warna teks paragraf */
        font-size: 1.05em;
    }
    .about-section ul {
        padding-left: 20px;
    }
    .about-section ul li {
        margin-bottom: 8px;
    }
    .team-section .team-intro {
        margin-bottom: 25px;
        text-align: center;
        font-size: 1.1em;
    }
    .team-members-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px; /* Jarak antar kartu tim */
        margin-top: 20px;
    }
    .team-member-card {
        text-align: center;
        padding: 20px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background-color: #f9fafb;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .team-member-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }
    .team-member-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 3px solid #00796B; /* Border dengan warna tema */
    }
    .team-member-name {
        font-size: 1.2em;
        font-weight: 600;
        color: #334155;
        margin-bottom: 5px;
    }
    .team-member-role {
        font-size: 0.95em;
        color: #64748b;
    }
    /* Untuk row pada Visi & Misi */
    .row { display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px; }
    .col-md-6 { position: relative; width: 100%; padding-right: 15px; padding-left: 15px; }
    @media (min-width: 768px) {
        .col-md-6 { flex: 0 0 50%; max-width: 50%; }
    }

    /* === CSS BARU UNTUK SOSIAL MEDIA === */
    .team-member-socials {
        display: flex;
        justify-content: center;
        gap: 15px; /* Jarak antar ikon */
    }
    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #e2e8f0; /* Warna background ikon default */
        color: #4a5568; /* Warna ikon default */
        text-decoration: none;
        transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }
    .social-icon:hover {
        transform: scale(1.1); /* Efek hover sedikit membesar */
    }
    .social-icon.instagram:hover {
        background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        color: white;
    }
    .social-icon.github:hover {
        background-color: #333;
        color: white;
    }
    /* ================================== */

    .row { display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px; }
    .col-md-6 { position: relative; width: 100%; padding-right: 15px; padding-left: 15px; }
    @media (min-width: 768px) {
        .col-md-6 { flex: 0 0 50%; max-width: 50%; }
    }
</style>
@endpush
