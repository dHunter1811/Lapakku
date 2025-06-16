# Lapakku - Platform Penyewaan Tempat Usaha

![Logo Lapakku](<public/images/Jukung Lapakku.png>)

**Menghubungkan Peluang, Membangun Usaha.**

Lapakku adalah sebuah platform web inovatif berbasis Laravel yang dirancang untuk menjadi jembatan antara pemilik lahan/properti dengan para pelaku UMKM di Banjarmasin yang sedang mencari lokasi usaha strategis. Proyek ini bertujuan untuk mendigitalisasi dan menyederhanakan proses pencarian dan penyewaan tempat usaha seperti ruko, kios, dan lahan terbuka.

---

## 📸 Tampilan Aplikasi

Berikut adalah beberapa tampilan dari antarmuka website Lapakku:

| Halaman Utama | Halaman Detail Lahan | Dashboard Admin |
| :---: | :---: | :---: |
| ![Tampilan Halaman Utama Lapakku](<public/images/README/Halaman Home.png>) | ![Tampilan Halaman Detail Lahan](<public/images/README/Halaman Detail Lahan.png>) | ![Tampilan Dashboard Admin](<public/images/README/Dashboard Admin.png>) |

---

## ✨ Fitur Utama

### Untuk Pengguna (Pencari Lahan)
- **Pencarian & Filter Lanjutan:** Cari lahan berdasarkan kata kunci, tipe lahan (Ruko, Kios, dll.), dan lokasi per kecamatan di Banjarmasin.
- **Urutkan Hasil:** Urutkan hasil pencarian berdasarkan harga termurah, termahal, atau yang terbaru.
- **Peta Interaktif:** Lihat lokasi pasti setiap lahan di peta interaktif pada halaman detail.
- **Detail Lahan Lengkap:** Lihat informasi komprehensif termasuk deskripsi, harga, galeri foto, keuntungan lokasi, dan informasi pemilik.
- **Sistem Rating & Ulasan:** Berikan rating dan ulasan untuk lahan yang pernah Anda sewa atau kunjungi.
- **Kontak Langsung ke Pemilik:** Hubungi pemilik lahan secara langsung melalui tombol WhatsApp yang terintegrasi.
- **Sistem Pengajuan Sewa:** Ajukan sewa secara formal melalui platform, lengkap dengan durasi sewa dan pesan untuk pemilik.

### Untuk Pemilik Lahan
- **Manajemen Akun:** Pengguna dapat mendaftar, login, dan mengedit profil mereka, termasuk foto profil.
- **Tambah & Kelola Lahan:** Pengguna dapat dengan mudah mendaftarkan lahan mereka melalui form yang intuitif, termasuk menentukan lokasi di peta.
- **Dashboard Pemilik:** Halaman khusus untuk melihat daftar lahan yang dimiliki, serta mengelola pengajuan sewa yang masuk (menyetujui atau menolak).

### Untuk Administrator
- **Dashboard Admin:** Ringkasan statistik mengenai total lahan, pengguna, rating, dan pesan masuk.
- **Manajemen Penuh:** Admin memiliki kontrol penuh untuk mengelola (CRUD) data Lahan, Pengguna, Rating, dan Pesan Masuk.
- **Persetujuan Lahan:** Admin dapat menyetujui atau menolak listing lahan baru yang diajukan oleh pengguna.
- **Ekspor Data:** Kemampuan untuk mengekspor data dari setiap modul (Lahan, User, Rating, Pesan) ke format **Excel (.xlsx)** dan **PDF**.

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP 8.2, Laravel 12
* **Frontend:** Blade Templates, HTML5, CSS3, JavaScript
* **Database:** MySQL
* **Pustaka Pihak Ketiga:**
    * **Leaflet.js:** Untuk peta interaktif.
    * **Lightbox2:** Untuk galeri foto.
    * **Maatwebsite/Excel:** Untuk fungsionalitas ekspor ke Excel.
    * **Barryvdh/laravel-dompdf:** Untuk fungsionalitas ekspor ke PDF.

---

## 🚀 Instalasi & Setup Lokal

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan lokal Anda.

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/username-anda/lapakku.git](https://github.com/username-anda/lapakku.git)
    cd lapakku
    ```

2.  **Instal Dependensi**
    ```bash
    composer install
    npm install
    npm run build
    ```

3.  **Konfigurasi Lingkungan**
    * Salin file `.env.example` menjadi `.env`:
        ```bash
        cp .env.example .env
        ```
    * Buat kunci aplikasi baru:
        ```bash
        php artisan key:generate
        ```
    * Konfigurasikan koneksi database Anda di dalam file `.env`:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=lapakku
        DB_USERNAME=root
        DB_PASSWORD=
        ```

4.  **Migrasi & Seeding Database**
    * Jalankan migrasi untuk membuat semua tabel:
        ```bash
        php artisan migrate
        ```
    * (Opsional) Jalankan seeder untuk mengisi database dengan data contoh:
        ```bash
        php artisan db:seed
        ```

5.  **Storage Link**
    * Buat symbolic link agar file yang diupload bisa diakses dari web:
        ```bash
        php artisan storage:link
        ```

6.  **Jalankan Aplikasi**
    * Jalankan server pengembangan lokal:
        ```bash
        php artisan serve
        ```
    * Buka `http://127.0.0.1:8000` di browser Anda.

---

## 👨‍💻 Tim Pengembang

Proyek "Lapakku" ini dikembangkan dengan penuh dedikasi dan semangat kolaborasi oleh tim mahasiswa dari **Universitas Lambung Mangkurat, Fakultas Keguruan dan Ilmu Pendidikan, Program Studi Pendidikan Komputer**.

* **Muhammad Dimas Aditya**
    * [![GitHub](https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/dHunter1811)
    * [![Instagram](https://img.shields.io/badge/Instagram-E4405F?style=for-the-badge&logo=instagram&logoColor=white)](https://www.instagram.com/dimas_1811?igsh=NzNlandzcjBhbmlv)
* **Muhammad Farros Shofiy**
    * [![GitHub](https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/KizuAnee)
    * [![Instagram](https://img.shields.io/badge/Instagram-E4405F?style=for-the-badge&logo=instagram&logoColor=white)](https://www.instagram.com/banwave10thperiod?igsh=MTlvbWE1NGIyZ2FyZg==)
* **Akhmad Rizky Rahmatullah**
    * [![GitHub](https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/omogiri)
    * [![Instagram](https://img.shields.io/badge/Instagram-E4405F?style=for-the-badge&logo=instagram&logoColor=white)](https://www.instagram.com/rizkl_?igsh=MWgyM3ptcmFrN2NrYQ==)

---

## 🤝 Kontribusi

Kontribusi, isu, dan permintaan fitur sangat kami hargai. Jangan ragu untuk membuat *pull request* atau membuka *issue*.

---

## 📜 Lisensi

Proyek ini berada di bawah Lisensi MIT. Lihat file `LICENSE` untuk detail lebih lanjut.
