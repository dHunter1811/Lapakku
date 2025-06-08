<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace benar

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lahan;   // Import model Lahan
use App\Models\User;    // Import model User
use App\Models\Rating;  // Import model Rating
use App\Models\Message; // Import model Message (jika Anda punya)

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan data statistik.
     */
    public function index()
    {
        // Statistik Umum
        $totalListing = Lahan::count();
        $listingMenunggu = Lahan::where('status', 'Menunggu')->count();
        $listingDisetujui = Lahan::where('status', 'Disetujui')->count();
        $listingDitolak = Lahan::where('status', 'Ditolak')->count();
        $totalUser = User::count(); // Atau User::where('role', 'user')->count(); jika ingin user biasa saja
        $ratingTerkumpul = Rating::count();
        // $pesanMasukBaru = Message::where('is_read', false)->count(); // Jika ada field is_read

        $adminStats = [
            'totalListing' => $totalListing,
            'listingMenunggu' => $listingMenunggu,
            'listingDisetujui' => $listingDisetujui,
            'listingDitolak' => $listingDitolak,
            'totalUser' => $totalUser,
            'ratingTerkumpul' => $ratingTerkumpul,
            // 'pesanMasukBaru' => $pesanMasukBaru,
        ];

        // Data Terbaru untuk Tabel Ringkasan
        $recentListings = Lahan::with('user') // Eager load relasi user
            ->latest() // Urutkan dari yang terbaru
            ->take(5)  // Ambil 5 data teratas
            ->get();

        $recentRatings = Rating::with(['user', 'lahan']) // Eager load relasi user dan lahan
            ->latest()
            ->take(5)
            ->get();

        $recentMessages = Message::with('user') // Eager load relasi user jika ada
            ->latest()
            ->take(5)
            ->get();
            // Jika tidak ada model Message, Anda bisa mengosongkan ini atau menghapusnya
            // $recentMessages = [];


        return view('admin.dashboard', compact(
            'adminStats',
            'recentListings',
            'recentRatings',
            'recentMessages'
        ));
    }
}
