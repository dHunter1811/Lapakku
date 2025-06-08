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
            // Tambahkan kolom setelah alamat lengkap
            $table->string('no_whatsapp', 20)->nullable()->after('alamat_lengkap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lahans', function (Blueprint $table) {
            $table->dropColumn('no_whatsapp');
        });
    }
};
