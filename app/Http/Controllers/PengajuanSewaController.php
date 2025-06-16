<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use App\Models\PengajuanSewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PengajuanSewaController extends Controller
{
    // HAPUS ATAU KOMENTARI METHOD __construct() INI:
    /*
    public function __construct()
    {
        $this->middleware('auth'); // Baris ini menyebabkan error dan tidak diperlukan karena route sudah dilindungi
    }
    */

    /**
     * Menyimpan pengajuan sewa baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lahan  $lahan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Lahan $lahan)
    {
        // Pastikan user sudah login (sebenarnya ini sudah ditangani oleh middleware di route,
        // tapi bisa ditambahkan pengecekan eksplisit jika mau, meskipun redundan)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengajukan sewa.');
        }

        $validator = Validator::make($request->all(), [
            'durasi_sewa_bulan' => 'required|integer|min:1',
            'pesan_penyewa' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator, 'pengajuanSewa') // Menggunakan named error bag
                        ->withInput()
                        ->with('open_ajukan_sewa_modal', true); // Kirim flash session untuk buka modal lagi jika error
        }

        // Pastikan lahan yang diajukan ada dan disetujui (atau kebijakan lain)
        if (!$lahan || $lahan->status !== 'Disetujui') {
            return redirect()->back()->with('error', 'Lahan ini tidak tersedia untuk disewa saat ini.');
        }

        // Pastikan pengguna tidak mengajukan sewa untuk lahannya sendiri
        if ($lahan->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengajukan sewa untuk lahan Anda sendiri.');
        }

        $totalHarga = $lahan->harga_sewa * $request->durasi_sewa_bulan;

        PengajuanSewa::create([
            'lahan_id' => $lahan->id,
            'user_id' => Auth::id(), // ID Penyewa
            'pemilik_lahan_id' => $lahan->user_id, // ID Pemilik Lahan
            'durasi_sewa_bulan' => $request->durasi_sewa_bulan,
            'harga_per_bulan' => $lahan->harga_sewa,
            'total_harga' => $totalHarga,
            'pesan_penyewa' => $request->pesan_penyewa,
            'status' => 'Menunggu Persetujuan', // Status awal
        ]);

        return redirect()->route('lahan.show', $lahan->id)->with('success', 'Pengajuan sewa Anda berhasil dikirim dan sedang menunggu konfirmasi dari pemilik lahan.');
    }
}
