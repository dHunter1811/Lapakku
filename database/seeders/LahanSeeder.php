<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lahan; // Pastikan path model Lahan Anda benar
use App\Models\User;  // Untuk mengambil user_id pemilik
use Illuminate\Support\Facades\Schema; // <-- 1. TAMBAHKAN INI

class LahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $this->command->warn('Tidak ada user ditemukan. Membuat user contoh...');
            $user = \App\Models\User::factory()->create([
                'name' => 'Pemilik Contoh Seeder',
                'email' => 'pemilik.seeder@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);
            $this->command->info('User contoh berhasil dibuat: ' . $user->email);
        }

        // 2. Nonaktifkan pengecekan foreign key sebelum truncate
        Schema::disableForeignKeyConstraints();

        // Hapus data lahan lama untuk menghindari duplikasi saat menjalankan seeder kembali
        Lahan::truncate();
        // Anda juga mungkin perlu men-truncate tabel anak jika ingin memulai dari nol
        // \App\Models\PengajuanSewa::truncate();
        // \App\Models\Rating::truncate();

        // 3. Aktifkan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();

        // Sekarang, buat data baru
        Lahan::create([
            'user_id' => $user->id,
            'judul' => 'Ruko Strategis di Pusat Kota Banjarmasin',
            'deskripsi' => 'Disewakan ruko 2 lantai di lokasi sangat strategis, Jalan A. Yani Km. 2. Cocok untuk berbagai jenis usaha seperti kantor, toko, atau kuliner. Area parkir luas.',
            'tipe_lahan' => 'Ruko',
            'lokasi' => 'Banjarmasin Tengah',
            'harga_sewa' => 5000000,
            'alamat_lengkap' => 'Jl. Ahmad Yani Km. 2, Banjarmasin Tengah, Kota Banjarmasin',
            'no_whatsapp' => '08115001234',
            'latitude' => -3.316833,
            'longitude' => 114.594356,
            'keuntungan_lokasi' => [
                'Tepat di tengah kota Banjarmasin, dekat pusat aktivitas.',
                'Bersebelahan dengan Duta Mall.',
                'Area parkir luas.',
                'Akses mudah dari berbagai arah.'
            ],
            'gambar_utama' => 'lahan_images/utama/ruko1.jpg',
            'galeri_1' => 'lahan_images/galeri/ruko_galeri1.jpg',
            'galeri_2' => 'lahan_images/galeri/ruko_galeri2.jpg',
            'galeri_3' => 'lahan_images/galeri/ruko_galeri3.jpg',
            'status' => 'Disetujui',
        ]);

        Lahan::create([
            'user_id' => $user->id,
            'judul' => 'Stand Bazar di Siring Menara Pandang',
            'deskripsi' => 'Lokasi premium untuk bazar atau jualan di area Siring Menara Pandang. Sangat ramai di akhir pekan dan saat ada event. Cocok untuk produk kreatif, fashion, dan makanan kekinian.',
            'tipe_lahan' => 'Lainnya',
            'lokasi' => 'Banjarmasin Tengah',
            'harga_sewa' => 2500000,
            'alamat_lengkap' => 'Area Siring Menara Pandang, Jl. Kapten Piere Tendean, Banjarmasin Tengah',
            'no_whatsapp' => '087815001122',
            'latitude' => -3.319500,
            'longitude' => 114.590500,
            'keuntungan_lokasi' => [
                'Ikon wisata Kota Banjarmasin.',
                'Target pasar anak muda dan keluarga.',
                'Traffic pengunjung sangat tinggi di akhir pekan.',
                'View langsung ke sungai Martapura.'
            ],
            'gambar_utama' => 'lahan_images/utama/siring1.jpg',
            'galeri_1' => 'lahan_images/galeri/siring_galeri1.jpg',
            'galeri_2' => 'lahan_images/galeri/siring_galeri2.jpg',
            'status' => 'Disetujui',
        ]);

        Lahan::create([
            'user_id' => $user->id,
            'judul' => 'Lapak Kuliner di Area Taman Kamboja',
            'deskripsi' => 'Area strategis di Taman Kamboja yang ramai pengunjung, cocok untuk usaha kuliner seperti gerobak makanan, booth minuman, atau food truck. Terutama ramai di sore dan malam hari.',
            'tipe_lahan' => 'Lahan Terbuka',
            'lokasi' => 'Banjarmasin Tengah',
            'harga_sewa' => 1800000,
            'alamat_lengkap' => 'Jl. H. Anang Adenansi, Taman Kamboja, Banjarmasin Tengah',
            'no_whatsapp' => '085248003344',
            'latitude' => -3.326800,
            'longitude' => 114.591300,
            'keuntungan_lokasi' => [
                'Pusat kota dan taman rekreasi.',
                'Ramai pengunjung di sore dan malam hari.',
                'Sering diadakan event komunitas.',
                'Suasana nyaman dan asri.'
            ],
            'gambar_utama' => 'lahan_images/utama/taman_kamboja1.jpg',
            'galeri_1' => 'lahan_images/galeri/taman_kamboja_galeri1.jpg',
            'status' => 'Disetujui',
        ]);

        Lahan::create([
            'user_id' => $user->id,
            'judul' => 'Kios Pasar Pagi Prospektif di Banjarmasin Timur',
            'deskripsi' => 'Kios di area Pasar Pagi, selalu ramai pengunjung. Ukuran 3x4m, cocok untuk jualan sembako, pakaian, atau makanan ringan. Harga sewa terjangkau.',
            'tipe_lahan' => 'Kios',
            'lokasi' => 'Banjarmasin Timur',
            'harga_sewa' => 1500000,
            'alamat_lengkap' => 'Area Pasar Pagi, Jl. Pangeran Samudera, Banjarmasin Timur',
            'no_whatsapp' => '081251005678',
            'latitude' => -3.324541,
            'longitude' => 114.601011,
            'keuntungan_lokasi' => [
                'Lokasi di dalam pasar yang ramai.',
                'Akses mudah dijangkau pelanggan.',
                'Cocok untuk berbagai jenis dagangan.'
            ],
            'gambar_utama' => 'lahan_images/utama/kios1.jpg',
            'galeri_1' => 'lahan_images/galeri/kios_galeri1.jpg',
            'status' => 'Disetujui',
        ]);

        Lahan::create([
            'user_id' => $user->id,
            'judul' => 'Lahan Kosong Tepi Jalan Bypass Banjarmasin Selatan',
            'deskripsi' => 'Lahan kosong luas 200m2 di tepi jalan bypass, cocok untuk gudang, bengkel, atau usaha cuci mobil. Akses kontainer mudah.',
            'tipe_lahan' => 'Lahan Terbuka',
            'lokasi' => 'Banjarmasin Selatan',
            'harga_sewa' => 2000000,
            'alamat_lengkap' => 'Jl. Lingkar Dalam Selatan (Bypass), Banjarmasin Selatan',
            'no_whatsapp' => '085248001122',
            'latitude' => -3.345890,
            'longitude' => 114.614867,
            'keuntungan_lokasi' => [
                'Akses jalan lebar untuk kendaraan besar.',
                'Area berkembang pesat.',
                'Harga sewa kompetitif.'
            ],
            'gambar_utama' => 'lahan_images/utama/lahan1.jpg',
            'status' => 'Menunggu',
        ]);

        Lahan::create([
            'user_id' => $user->id,
            'judul' => 'Tempat Usaha di Pasar Sentra Antasari',
            'deskripsi' => 'Lokasi strategis di dalam Pasar Sentra Antasari, cocok untuk berbagai jenis dagangan. Lantai dasar, dekat pintu masuk.',
            'tipe_lahan' => 'Pasar',
            'lokasi' => 'Banjarmasin Tengah',
            'harga_sewa' => 1200000,
            'alamat_lengkap' => 'Pasar Sentra Antasari, Blok C No. 10, Banjarmasin Tengah',
            'no_whatsapp' => null,
            'latitude' => -3.323533,
            'longitude' => 114.590471,
            'keuntungan_lokasi' => [
                'Terletak di pusat perdagangan tradisional.',
                'Potensi pelanggan tinggi dari pengunjung pasar.'
            ],
            'gambar_utama' => null,
            'galeri_1' => 'lahan_images/galeri/pasar_galeri1.jpg',
            'galeri_2' => 'lahan_images/galeri/pasar_galeri2.jpg',
            'status' => 'Disetujui',
        ]);
        
        Lahan::create([
            'user_id' => $user->id,
            'judul' => 'Gudang Serbaguna di Banjarmasin Utara',
            'deskripsi' => 'Gudang luas dengan akses mudah untuk truk. Keamanan 24 jam. Cocok untuk penyimpanan barang atau industri ringan.',
            'tipe_lahan' => 'Lainnya',
            'lokasi' => 'Banjarmasin Utara',
            'harga_sewa' => 7500000,
            'alamat_lengkap' => 'Jl. Brigjen Hasan Basri, Komp. Pergudangan Kayu Tangi, Banjarmasin Utara',
            'no_whatsapp' => '087815009988',
            'latitude' => -3.292044,
            'longitude' => 114.588820,
            'keuntungan_lokasi' => [
                'Kawasan industri dan pergudangan.',
                'Keamanan terjamin.',
                'Luas dan fleksibel untuk berbagai kebutuhan.'
            ],
            'gambar_utama' => 'lahan_images/utama/gudang1.jpg',
            'galeri_1' => 'lahan_images/galeri/gudang_galeri1.jpg',
            'galeri_2' => 'lahan_images/galeri/gudang_galeri2.jpg',
            'galeri_3' => 'lahan_images/galeri/gudang_galeri3.jpg',
            'status' => 'Disetujui',
        ]);

        $this->command->info('Seeder Lahan berhasil dijalankan dengan data lengkap.');
    }
}
