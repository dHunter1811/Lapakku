<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'harga_sewa',
        'alamat_lengkap',
        'no_whatsapp', // TAMBAHKAN INI
        'gambar_utama',
        'status',
        'tipe_lahan',
        'lokasi',
        'keuntungan_lokasi', // Tambahkan ini
        'galeri_1',          // Tambahkan ini
        'galeri_2',          // Tambahkan ini
        'galeri_3',          // Tambahkan ini
        'latitude',  // TAMBAHKAN INI
        'longitude', // TAMBAHKAN INI
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'harga_sewa' => 'decimal:2',
        'keuntungan_lokasi' => 'array', // Otomatis konversi ke/dari JSON
        'latitude' => 'decimal:7',  // Pastikan cast jika perlu
        'longitude' => 'decimal:7', // Pastikan cast jika perlu
    ];

    /**
     * Relasi: Lahan dimiliki oleh satu User (pemilik).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Lahan bisa memiliki banyak Rating.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
