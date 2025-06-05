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
        Schema::create('pengajuan_sewas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lahan_id')->constrained('lahans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Penyewa
            $table->foreignId('pemilik_lahan_id')->constrained('users')->onDelete('cascade'); // Pemilik Lahan
            $table->integer('durasi_sewa_bulan'); // Durasi sewa dalam bulan
            $table->decimal('harga_per_bulan', 15, 2);
            $table->decimal('total_harga', 15, 2);
            $table->text('pesan_penyewa')->nullable();
            $table->enum('status', ['Menunggu Persetujuan', 'Disetujui', 'Ditolak', 'Dibatalkan Penyewa', 'Selesai'])->default('Menunggu Persetujuan');
            $table->timestamp('tanggal_mulai_sewa')->nullable(); // Opsional, jika ingin menentukan tanggal mulai
            $table->timestamp('tanggal_selesai_sewa')->nullable(); // Opsional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_sewas');
    }
};
