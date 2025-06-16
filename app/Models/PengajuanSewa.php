<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSewa extends Model
{
    use HasFactory;

    protected $fillable = [
        'lahan_id',
        'user_id', // Penyewa
        'pemilik_lahan_id',
        'durasi_sewa_bulan',
        'harga_per_bulan',
        'total_harga',
        'pesan_penyewa',
        'status',
        'tanggal_mulai_sewa',
        'tanggal_selesai_sewa',
    ];

    protected $casts = [
        'harga_per_bulan' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'tanggal_mulai_sewa' => 'datetime',
        'tanggal_selesai_sewa' => 'datetime',
    ];

    /**
     * Relasi ke Lahan yang diajukan.
     */
    public function lahan()
    {
        return $this->belongsTo(Lahan::class);
    }

    /**
     * Relasi ke User yang mengajukan sewa (Penyewa).
     */
    public function penyewa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke User pemilik lahan.
     */
    public function pemilikLahan()
    {
        return $this->belongsTo(User::class, 'pemilik_lahan_id');
    }
}
