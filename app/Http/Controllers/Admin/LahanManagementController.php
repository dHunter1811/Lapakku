<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace benar

use App\Http\Controllers\Controller;
use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // Pastikan Storage di-import untuk menghapus gambar

class LahanManagementController extends Controller
{
    // Jika Anda ingin semua method di controller ini dilindungi oleh middleware admin,
    // Anda bisa mengaktifkan __construct() ini.
    // public function __construct()
    // {
    //     $this->middleware('admin');
    // }

    /**
     * Menampilkan daftar semua lahan untuk manajemen admin.
     */
    public function index(Request $request)
    {
        $query = Lahan::query()->with('user'); // Eager load relasi user (pemilik)

        // Filter berdasarkan kata kunci (judul, nama/email pemilik)
        if ($request->filled('search_query')) {
            $searchTerm = $request->search_query;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', '%' . $searchTerm . '%')
                                ->orWhere('email', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Filter berdasarkan status
        if ($request->filled('search_status')) {
            $query->where('status', $request->search_status);
        }

        // Pengurutan
        $sortBy = $request->input('sort_by', 'terbaru'); // Default ke 'terbaru' jika tidak ada
        switch ($sortBy) {
            case 'terlama':
                $query->orderBy('created_at', 'asc');
                break;
            case 'judul_asc':
                $query->orderBy('judul', 'asc');
                break;
            case 'judul_desc':
                $query->orderBy('judul', 'desc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('created_at', 'desc'); // atau $query->latest();
                break;
        }

        $lahanList = $query->paginate(10); // Ambil 10 data per halaman, sesuaikan jika perlu

        return view('admin.lahan.index', compact('lahanList'));
    }

    /**
     * Menampilkan form untuk admin mengedit lahan.
     */
    public function edit(Lahan $lahan)
    {
        $lahan->load('user'); // Eager load user untuk ditampilkan di form edit
        return view('admin.lahan.edit', compact('lahan'));
    }

    /**
     * Memperbarui data lahan oleh admin.
     */
    public function update(Request $request, Lahan $lahan)
    {
        // Otorisasi sudah ditangani oleh middleware di route, tidak perlu pengecekan Auth di sini
        
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_lahan' => 'required|string|in:Ruko,Kios,Pasar,Lahan Terbuka,Lainnya',
            'lokasi' => 'required|string|in:Banjarmasin Selatan,Banjarmasin Timur,Banjarmasin Barat,Banjarmasin Tengah,Banjarmasin Utara',
            'harga_sewa' => 'required|numeric|min:1',
            'alamat_lengkap' => 'required|string',
            'no_whatsapp' => ['nullable', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:20'], // === VALIDASI DITAMBAHKAN ===
            'keuntungan_lokasi' => 'nullable|array',
            'keuntungan_lokasi.*' => 'nullable|string|max:255',
            'latitude' => ['nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+)|90(\.0+)?)$/'],
            'longitude' => ['nullable', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|in:Menunggu,Disetujui,Ditolak',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.lahan.edit', $lahan->id)
                        ->withErrors($validator)
                        ->withInput();
        }

        // Ambil semua field yang relevan dari request
        $dataToUpdate = $request->only([
            'judul', 'deskripsi', 'tipe_lahan', 'lokasi', 'harga_sewa', 'alamat_lengkap', 'status',
            'latitude', 'longitude',
            'no_whatsapp' // === FIELD DIAMBIL DARI REQUEST ===
        ]);

        // Proses Keuntungan Lokasi
        if ($request->has('keuntungan_lokasi')) {
            $keuntungan = array_filter($request->keuntungan_lokasi, fn($value) => !is_null($value) && $value !== '');
            $dataToUpdate['keuntungan_lokasi'] = !empty($keuntungan) ? array_values($keuntungan) : null;
        } else {
            $dataToUpdate['keuntungan_lokasi'] = null; // Kosongkan jika tidak ada input
        }

        // Proses Gambar Utama
        if ($request->hasFile('gambar_utama')) {
            if ($lahan->gambar_utama && Storage::disk('public')->exists($lahan->gambar_utama)) {
                Storage::disk('public')->delete($lahan->gambar_utama);
            }
            $dataToUpdate['gambar_utama'] = $request->file('gambar_utama')->store('lahan_images/utama', 'public');
        }

        // Proses Gambar Galeri
        for ($i = 1; $i <= 3; $i++) {
            $galeriField = 'galeri_' . $i;
            if ($request->hasFile($galeriField)) {
                if ($lahan->$galeriField && Storage::disk('public')->exists($lahan->$galeriField)) {
                    Storage::disk('public')->delete($lahan->$galeriField);
                }
                $dataToUpdate[$galeriField] = $request->file($galeriField)->store('lahan_images/galeri', 'public');
            }
        }

        $lahan->update($dataToUpdate);

        return redirect()->route('admin.lahan.index')->with('success', 'Data lahan berhasil diperbarui.');
    }

    /**
     * Menyetujui listing lahan.
     */
    public function approve(Lahan $lahan)
    {
        $lahan->update(['status' => 'Disetujui']);
        return redirect()->back()->with('success', 'Lahan "' . $lahan->judul . '" berhasil disetujui.');
    }

    /**
     * Menolak listing lahan.
     */
    public function reject(Lahan $lahan)
    {
        $lahan->update(['status' => 'Ditolak']);
        return redirect()->back()->with('success', 'Lahan "' . $lahan->judul . '" berhasil ditolak.');
    }

    /**
     * Menghapus lahan oleh admin.
     */
    public function destroy(Lahan $lahan)
    {
        // Hapus Gambar Utama
        if ($lahan->gambar_utama && Storage::disk('public')->exists($lahan->gambar_utama)) {
            Storage::disk('public')->delete($lahan->gambar_utama);
        }
        // Hapus Gambar Galeri
        for ($i = 1; $i <= 3; $i++) {
            $galeriField = 'galeri_' . $i;
            if ($lahan->$galeriField && Storage::disk('public')->exists($lahan->$galeriField)) {
                Storage::disk('public')->delete($lahan->$galeriField);
            }
        }

        $lahan->delete();
        return redirect()->route('admin.lahan.index')->with('success', 'Lahan "' . $lahan->judul . '" berhasil dihapus permanen.');
    }
}
