<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // ID pengirim jika user login, bisa nullable jika tamu
        'nama',    // Nama pengirim (jika tamu atau untuk override)
        'email',   // Email pengirim
        'pesan',
        'is_read', // Status apakah sudah dibaca admin
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Relasi: Pesan mungkin dikirim oleh User (opsional).
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Pengunjung Tamu', // Default name if user_id is null
        ]);
    }
}