<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->decimal('harga_sewa', 15, 2);
            $table->string('tipe_lahan')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('alamat_lengkap');
            $table->string('gambar_utama')->nullable();

            // Kolom baru untuk Keuntungan Lokasi (disimpan sebagai JSON)
            $table->text('keuntungan_lokasi')->nullable();

            // Kolom baru untuk Galeri Lokasi
            $table->string('galeri_1')->nullable();
            $table->string('galeri_2')->nullable();
            $table->string('galeri_3')->nullable();

            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lahans');
    }
};
