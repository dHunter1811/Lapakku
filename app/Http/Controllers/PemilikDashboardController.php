<?php

namespace App\Http\Controllers; // Sesuaikan namespace jika Anda meletakkannya di subfolder Admin

use App\Models\PengajuanSewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemilikDashboardController extends Controller
{
    // HAPUS ATAU KOMENTARI METHOD __construct() INI:
    /*
    public function __construct()
    {
        $this->middleware('auth'); // Baris ini menyebabkan error dan tidak diperlukan
    }
    */

    /**
     * Menampilkan dashboard pemilik lahan dengan daftar pengajuan sewa.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Pastikan user sudah login (sebenarnya sudah ditangani oleh middleware di route)
        if (!$user) {
            return redirect()->route('login');
        }

        // Ambil semua pengajuan sewa dimana pemilik_lahan_id adalah ID user yang login
        $query = PengajuanSewa::where('pemilik_lahan_id', $user->id)
                              ->with(['lahan', 'penyewa']) // Eager load lahan dan data penyewa
                              ->orderBy('created_at', 'desc'); // Tampilkan yang terbaru dulu

        // Filter berdasarkan status pengajuan jika ada parameter di request
        if ($request->filled('status_pengajuan')) {
            $query->where('status', $request->status_pengajuan);
        }

        $pengajuanMasuk = $query->paginate(10);

        return view('pemilik.dashboard', compact('pengajuanMasuk', 'user'));
    }

    /**
     * Menyetujui pengajuan sewa.
     */
    public function setujui(Request $request, PengajuanSewa $pengajuanSewa)
    {
        // Otorisasi: Pastikan user yang login adalah pemilik lahan dari pengajuan ini
        if ($pengajuanSewa->pemilik_lahan_id !== Auth::id()) {
            return redirect()->route('pemilik.dashboard')->with('error', 'Anda tidak memiliki izin untuk aksi ini.');
        }

        if ($pengajuanSewa->status !== 'Menunggu Persetujuan') {
            return redirect()->route('pemilik.dashboard')->with('info', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $pengajuanSewa->status = 'Disetujui';
        $pengajuanSewa->save();

        return redirect()->route('pemilik.dashboard')->with('success', 'Pengajuan sewa untuk lahan "' . $pengajuanSewa->lahan->judul . '" telah disetujui.');
    }

    /**
     * Menolak pengajuan sewa.
     */
    public function tolak(Request $request, PengajuanSewa $pengajuanSewa)
    {
        if ($pengajuanSewa->pemilik_lahan_id !== Auth::id()) {
            return redirect()->route('pemilik.dashboard')->with('error', 'Anda tidak memiliki izin untuk aksi ini.');
        }

        if ($pengajuanSewa->status !== 'Menunggu Persetujuan') {
            return redirect()->route('pemilik.dashboard')->with('info', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $pengajuanSewa->status = 'Ditolak';
        $pengajuanSewa->save();

        return redirect()->route('pemilik.dashboard')->with('success', 'Pengajuan sewa untuk lahan "' . $pengajuanSewa->lahan->judul . '" telah ditolak.');
    }
}
