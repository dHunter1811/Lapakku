<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan model User di-import
use Illuminate\Support\Facades\Hash; // Untuk hashing password

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data user lama untuk menghindari duplikasi saat seeding ulang (opsional, hati-hati)
        // User::truncate(); // JANGAN JALANKAN INI JIKA ANDA TIDAK INGIN MENGHAPUS SEMUA USER

        // Data Tim Pengembang
        $team = [
            [
                'name' => 'Muhammad Dimas Aditya',
                'email' => 'dimasraffa32@gmail.com',
                'password' => 'dimas123', // Ganti dengan password yang aman
                'role' => 'user', // Jadikan Dimas sebagai admin
                'no_telepon' => '087727727087',
                'alamat' => 'Jl. Sungai Andai, Banjarmasin Utara'
            ],
            [
                'name' => 'Muhammad Farros Shofiy',
                'email' => 'farros@gmail.com',
                'password' => '12345678', // Ganti dengan password yang aman
                'role' => 'user',
                'no_telepon' => '081233334444',
                'alamat' => 'Jl. Pramuka, Banjarmasin Timur'
            ],
            [
                'name' => 'Akhmad Rizky Rahmatullah',
                'email' => 'rizky@gmail.com',
                'password' => '12345678', // Ganti dengan password yang aman
                'role' => 'user',
                'no_telepon' => '081255556666',
                'alamat' => 'Jl. Veteran, Banjarmasin Tengah'
            ],
        ];

        // Loop untuk membuat setiap user
        foreach ($team as $member) {
            // firstOrCreate akan membuat user hanya jika email-nya belum ada
            User::firstOrCreate(
                ['email' => $member['email']], // Kunci untuk mengecek
                [
                    'name' => $member['name'],
                    'password' => Hash::make($member['password']),
                    'role' => $member['role'],
                    'no_telepon' => $member['no_telepon'],
                    'alamat' => $member['alamat'],
                    'email_verified_at' => now(), // Langsung set email sebagai terverifikasi
                ]
            );
        }

        $this->command->info('Seeder untuk tim pengembang berhasil dijalankan!');
    }
}
