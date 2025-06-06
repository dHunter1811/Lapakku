<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create(); // Contoh bawaan

        // Panggil seeder Anda di sini:
        $this->call([
            UserSeeder::class, // Pastikan UserSeeder sudah ada
            AdminUserSeeder::class, // Panggil seeder admin terlebih dahulu
            // UserSeeder::class, // Jika Anda punya seeder untuk user biasa
            LahanSeeder::class,
            // Tambahkan seeder lain jika ada
        ]);
    }
}
