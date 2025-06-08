<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lahan;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Menampilkan halaman utama (homepage).
     */
    public function home()
    {
        $rekomendasiLahan = Lahan::where('status', 'Disetujui')
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->orderByDesc('ratings_count')
            ->take(4)
            ->get();

        if ($rekomendasiLahan->isEmpty()) {
            $rekomendasiLahan = Lahan::where('status', 'Disetujui')
                ->latest()
                ->take(4)
                ->get();
        }

        $categories = [
            ['name' => 'Ruko', 'value' => 'Ruko', 'icon' => '🏠'],
            ['name' => 'Kios', 'value' => 'Kios', 'icon' => '🏪'],
            ['name' => 'Pasar', 'value' => 'Pasar', 'icon' => '🛒'],
            ['name' => 'Lahan Terbuka', 'value' => 'Lahan Terbuka', 'icon' => '🌳'],
            ['name' => 'Lainnya', 'value' => 'Lainnya', 'icon' => '➕']
        ];

        return view('pages.home', compact('rekomendasiLahan', 'categories'));
    }

    /**
     * Menampilkan halaman form kontak.
     */
    public function showContactForm()
    {
        return view('pages.kontak');
    }

    /**
     * Menyimpan pesan dari form kontak.
     */
    public function storeContactMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pesan' => 'required|string|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('kontak.show')
                        ->withErrors($validator)
                        ->withInput();
        }

        Message::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
            'user_id' => Auth::check() ? Auth::id() : null,
            'is_read' => false,
        ]);

        return redirect()->route('kontak.show')->with('success', 'Pesan Anda telah berhasil dikirim! Kami akan segera merespons.');
    }

    /**
     * Menampilkan halaman Tentang Kami.
     */
    public function showTentangKami()
    {
        return view('pages.tentang_kami');
    }

    /**
     * Menampilkan halaman Bantuan (FAQ).
     */
    public function showBantuan() // METHOD BARU DITAMBAHKAN
    {
        // Anda bisa mengambil data FAQ dari database jika mau di masa mendatang.
        // Untuk saat ini, konten ada di Blade.
        return view('pages.bantuan'); // Pastikan file resources/views/pages/bantuan.blade.php ada
    }
}
