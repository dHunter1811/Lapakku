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
        Schema::table('lahans', function (Blueprint $table) {
            // Tambahkan setelah kolom 'alamat_lengkap' atau sesuaikan
            $table->decimal('latitude', 10, 7)->nullable()->after('alamat_lengkap'); // Presisi 10, 7 desimal untuk latitude
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');  // Presisi 10, 7 desimal untuk longitude
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lahans', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
