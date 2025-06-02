<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Lahan; // Jika perlu mengambil data lahan untuk homepage
// use App\Models\Testimonial; // Jika perlu mengambil data testimonial

class PageController extends Controller
{
    /**
     * Menampilkan halaman utama (homepage).
     */
    public function home()
    {
        // Contoh mengambil data untuk homepage
        // $rekomendasiLahan = Lahan::where('is_recommended', true)->take(4)->get();
        // $testimonials = Testimonial::latest()->take(3)->get();

        // return view('pages.home', compact('rekomendasiLahan', 'testimonials'));
        return view('pages.home'); // resources/views/pages/home.blade.php
                                   // Sesuaikan dengan wireframe 3
    }

    // Anda bisa menambahkan method lain untuk halaman seperti 'Tentang Kami', 'Kontak', dll.
    // public function tentangKami()
    // {
    //     return view('pages.tentang_kami');
    // }
}