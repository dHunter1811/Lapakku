<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable // implements MustVerifyEmail (jika menggunakan verifikasi email)
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'alamat',      // Tambahan dari wireframe register
        'no_telepon',  // Tambahan dari wireframe register
        'role',        // Untuk membedakan user dan admin (mis. 'user', 'admin')
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Otomatis hash password saat diset
    ];

    /**
     * Relasi: User memiliki banyak Lahan.
     */
    public function lahan()
    {
        return $this->hasMany(Lahan::class);
    }

    /**
     * Relasi: User bisa memberikan banyak Rating.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Relasi: User bisa mengirim banyak Pesan (jika pesan terhubung ke user).
     * Asumsi kolom 'user_id' di tabel messages.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}