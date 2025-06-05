<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lahan; // Pastikan path model Lahan Anda benar
use App\Models\User;  // Untuk mengambil user_id pemilik

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
            $user = User::factory()->create([
                'name' => 'Pemilik Contoh Seeder',
                'email' => 'pemilik.seeder@example.com',
                'password' => bcrypt('password'), // Ganti password ini
                'role' => 'user',
                'email_verified_at' => now(),
            ]);
            $this->command->info('User contoh berhasil dibuat: ' . $user->email);
        }

        // Opsi untuk tipe lahan dan lokasi (tidak digunakan di contoh statis ini, tapi bisa untuk data acak)
        // $tipeLahanOptions = ['Ruko', 'Kios', 'Pasar', 'Lahan Terbuka', 'Lainnya'];
        // $lokasiOptions = ['Banjarmasin Selatan', 'Banjarmasin Timur', 'Banjarmasin Barat', 'Banjarmasin Tengah', 'Banjarmasin Utara'];

        Lahan::create([
            'user_id' => $user->id,
            'judul' => 'Ruko Strategis di Pusat Kota Banjarmasin',
            'deskripsi' => 'Disewakan ruko 2 lantai di lokasi sangat strategis, Jalan A. Yani Km. 2. Cocok untuk berbagai jenis usaha seperti kantor, toko, atau kuliner. Area parkir luas.',
            'tipe_lahan' => 'Ruko',
            'lokasi' => 'Banjarmasin Tengah',
            'harga_sewa' => 5000000,
            'alamat_lengkap' => 'Jl. Ahmad Yani Km. 2, Banjarmasin Tengah, Kota Banjarmasin, Kalimantan Selatan',
            'keuntungan_lokasi' => [ // Tambahkan ini
                'Tepat di tengah kota Banjarmasin, dekat pusat aktivitas masyarakat.',
                'Bersebelahan dengan taman kota, ideal untuk usaha kuliner dan rekreasi.',
                'Area parkir luas, cocok untuk pelanggan yang membawa kendaraan.',
                'Sering digunakan untuk event atau bazar UMKM di hari-hari tertentu.'
            ],
            'gambar_utama' => 'lahan_images/utama/ruko1.jpg', // Sesuaikan path jika perlu
            'galeri_1' => 'lahan_images/galeri/ruko_galeri1.jpg', // Tambahkan ini
            'galeri_2' => 'lahan_images/galeri/ruko_galeri2.jpg', // Tambahkan ini
            'galeri_3' => 'lahan_images/galeri/ruko_galeri3.jpg', // Tambahkan ini
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
            'keuntungan_lokasi' => [ // Tambahkan ini
                'Lokasi di dalam pasar yang ramai.',
                'Akses mudah dijangkau pelanggan.',
                'Cocok untuk berbagai jenis dagangan.'
            ],
            'gambar_utama' => 'lahan_images/utama/kios1.jpg', // Sesuaikan path
            'galeri_1' => 'lahan_images/galeri/kios_galeri1.jpg', // Tambahkan ini
            // 'galeri_2' => null, // Bisa null jika hanya ada 1 atau 2 gambar galeri
            // 'galeri_3' => null,
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
            'keuntungan_lokasi' => [ // Tambahkan ini
                'Akses jalan lebar untuk kendaraan besar.',
                'Area berkembang pesat.',
                'Harga sewa kompetitif.'
            ],
            'gambar_utama' => 'lahan_images/utama/lahan1.jpg', // Sesuaikan path
            // 'galeri_1' => null,
            // 'galeri_2' => null,
            // 'galeri_3' => null,
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
            'keuntungan_lokasi' => [ // Tambahkan ini
                'Terletak di pusat perdagangan tradisional.',
                'Potensi pelanggan tinggi dari pengunjung pasar.'
            ],
            'gambar_utama' => null, // Contoh tanpa gambar utama
            'galeri_1' => 'lahan_images/galeri/pasar_galeri1.jpg', // Tambahkan ini
            'galeri_2' => 'lahan_images/galeri/pasar_galeri2.jpg', // Tambahkan ini
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
            'keuntungan_lokasi' => [ // Tambahkan ini
                'Kawasan industri dan pergudangan.',
                'Keamanan terjamin.',
                'Luas dan fleksibel untuk berbagai kebutuhan.'
            ],
            'gambar_utama' => 'lahan_images/utama/gudang1.jpg', // Sesuaikan path
            'galeri_1' => 'lahan_images/galeri/gudang_galeri1.jpg', // Tambahkan ini
            'galeri_2' => 'lahan_images/galeri/gudang_galeri2.jpg', // Tambahkan ini
            'galeri_3' => 'lahan_images/galeri/gudang_galeri3.jpg', // Tambahkan ini
            'status' => 'Disetujui',
        ]);

        $this->command->info('Seeder Lahan berhasil dijalankan dengan data keuntungan dan galeri.');
    }
}
