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
                    <div class="team-member-card">
                        {{-- Ganti dengan path foto jika ada, atau gunakan placeholder --}}
                        <img src="{{ asset('images/dimas.jpg') }}" alt="Foto Muhammad Dimas Aditya" class="team-member-photo">
                        <h5 class="team-member-name">Muhammad Dimas Aditya</h5>
                        <p class="team-member-role">Pengembang Inti</p>
                    </div>
                    <div class="team-member-card">
                        <img src="{{ asset('images/farros.jpg') }}" alt="Foto Muhammad Farros Shofiy" class="team-member-photo">
                        <h5 class="team-member-name">Muhammad Farros Shofiy</h5>
                        <p class="team-member-role">Pengembang Inti</p>
                    </div>
                    <div class="team-member-card">
                        <img src="{{ asset('images/rizky.jpg') }}" alt="Foto Akhmad Rizky Rahmatullah" class="team-member-photo">
                        <h5 class="team-member-name">Akhmad Rizky Rahmatullah</h5>
                        <p class="team-member-role">Pengembang Inti</p>
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
</style>
@endpush
