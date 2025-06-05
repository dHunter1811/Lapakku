<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan path model User Anda benar
use Illuminate\Support\Facades\Hash; // Untuk hashing password

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin dengan email tertentu sudah ada
        // untuk menghindari duplikasi jika seeder dijalankan berkali-kali
        $adminEmail = 'admin@lapakku.com'; // Anda bisa mengganti email ini

        if (!User::where('email', $adminEmail)->exists()) {
            User::create([
                'name' => 'Admin Lapakku', // Nama untuk akun admin
                'email' => $adminEmail,
                'password' => Hash::make('12345678'), // GANTI DENGAN PASSWORD YANG AMAN!
                'role' => 'admin', // Set role sebagai admin
                'email_verified_at' => now(), // Opsional: langsung set email sebagai terverifikasi
                // Tambahkan field lain jika ada di model User Anda dan wajib diisi
                // 'alamat' => 'Kantor Pusat Lapakku',
                // 'no_telepon' => '081234567890',
            ]);
            $this->command->info('Akun admin berhasil dibuat dengan email: ' . $adminEmail);
        } else {
            $this->command->info('Akun admin dengan email: ' . $adminEmail . ' sudah ada.');
        }
    }
}
