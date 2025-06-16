<?php

namespace App\Http\Controllers;

use App\Models\Lahan; // 1. PASTIKAN MODEL LAHAN DI-IMPORT
use App\Models\PengajuanSewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemilikDashboardController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware('auth'); // Sudah ditangani oleh middleware di route
    }
    */

    /**
     * Menampilkan dashboard pemilik lahan dengan daftar pengajuan sewa dan lahan milik user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 2. Ambil lahan milik pengguna yang sedang login
        $lahanMilikUser = Lahan::where('user_id', $user->id)
                              ->orderBy('created_at', 'desc') // Urutkan berdasarkan yang terbaru
                              ->paginate(5, ['*'], 'lahan_page'); // Paginasi untuk lahan, nama parameter halaman 'lahan_page'

        // Ambil semua pengajuan sewa dimana pemilik_lahan_id adalah ID user yang login
        $queryPengajuan = PengajuanSewa::where('pemilik_lahan_id', $user->id)
                              ->with(['lahan', 'penyewa']) // Eager load lahan dan data penyewa
                              ->orderBy('created_at', 'desc');

        // Filter berdasarkan status pengajuan jika ada parameter di request
        if ($request->filled('status_pengajuan')) {
            $queryPengajuan->where('status', $request->status_pengajuan);
        }

        $pengajuanMasuk = $queryPengajuan->paginate(10, ['*'], 'pengajuan_page'); // Paginasi untuk pengajuan, nama parameter halaman 'pengajuan_page'

        // 3. Kirim kedua data ke view
        return view('pemilik.dashboard', compact('lahanMilikUser', 'pengajuanMasuk', 'user'));
    }

    /**
     * Menyetujui pengajuan sewa.
     */
    public function setujui(Request $request, PengajuanSewa $pengajuanSewa)
    {
        if ($pengajuanSewa->pemilik_lahan_id !== Auth::id()) {
            return redirect()->route('pemilik.dashboard')->with('error', 'Anda tidak memiliki izin untuk aksi ini.');
        }

        if ($pengajuanSewa->status !== 'Menunggu Persetujuan') {
            return redirect()->route('pemilik.dashboard')->with('info', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $pengajuanSewa->status = 'Disetujui';
        $pengajuanSewa->save();

        // Menggunakan optional() untuk mencegah error jika relasi lahan tidak ada (mis. lahan terhapus)
        return redirect()->route('pemilik.dashboard')->with('success', 'Pengajuan sewa untuk lahan "' . optional($pengajuanSewa->lahan)->judul . '" telah disetujui.');
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
        
        return redirect()->route('pemilik.dashboard')->with('success', 'Pengajuan sewa untuk lahan "' . optional($pengajuanSewa->lahan)->judul . '" telah ditolak.');
    }
}
