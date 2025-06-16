<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',   // ID pengguna yang memberi rating
        'lahan_id',  // ID lahan yang diberi rating
        'rating',    // Nilai rating (mis. 1-5)
        'komentar',
    ];

    /**
     * Relasi: Rating diberikan oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Rating diberikan untuk satu Lahan.
     */
    public function lahan()
    {
        return $this->belongsTo(Lahan::class);
    }
}