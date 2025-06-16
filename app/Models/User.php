<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage; // Pastikan Storage di-import

class User extends Authenticatable
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
        'alamat',
        'no_telepon',
        'role',
        'profile_photo_path',
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
        'password' => 'hashed',
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
     * Relasi: User bisa mengirim banyak Pesan.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Accessor untuk mendapatkan URL foto profil.
     * Akan mengembalikan URL foto yang diupload atau URL foto default.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        // Cek apakah profile_photo_path ada isinya (tidak null dan tidak string kosong)
        // DAN file tersebut benar-benar ada di storage publik
        if ($this->profile_photo_path && Storage::disk('public')->exists($this->profile_photo_path)) {
            return Storage::url($this->profile_photo_path);
        }

        // Jika tidak ada foto profil yang diupload atau file tidak ditemukan,
        // kembalikan path ke foto default Anda.
        // PASTIKAN file 'default-avatar.png' (atau nama file Anda)
        // ADA DI DALAM folder 'public/images/'.
        return asset('images/default-avatar.png');

        // Alternatif jika Anda tidak ingin menggunakan file fisik untuk default,
        // Anda bisa menggunakan layanan placeholder seperti ui-avatars.com:
        // return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}
