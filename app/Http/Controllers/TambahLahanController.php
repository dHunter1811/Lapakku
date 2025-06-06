<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TambahLahanController extends Controller
{
    /**
     * Hanya user yang sudah login yang bisa mengakses method di controller ini.
     * Middleware akan diterapkan di route.
     */

    /**
     * Menampilkan form untuk menambah lahan baru.
     *
     * @return \Illuminate\View\View
     */
    public function formTambah()
    {
        // Langsung tampilkan view baru
        return view('lahanbaru.tambah'); // Akan mencari resources/views/lahanbaru/tambah.blade.php
    }

    /**
     * Menyimpan lahan baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function simpanLahanBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_lahan' => 'required|string|in:Ruko,Kios,Pasar,Lahan Terbuka,Lainnya',
            'lokasi' => 'required|string|in:Banjarmasin Selatan,Banjarmasin Timur,Banjarmasin Barat,Banjarmasin Tengah,Banjarmasin Utara',
            'harga_sewa' => 'required|numeric|min:1',
            'alamat_lengkap' => 'required|string',
            'keuntungan_lokasi' => 'nullable|array',
            'keuntungan_lokasi.*' => 'nullable|string|max:255', // Validasi setiap item dalam array
            'gambar_utama' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lahanbaru.tambah') // Redirect ke route baru jika validasi gagal
                        ->withErrors($validator)
                        ->withInput();
        }

        $dataToCreate = $request->only([
            'judul', 'deskripsi', 'tipe_lahan', 'lokasi', 'harga_sewa', 'alamat_lengkap'
        ]);
        $dataToCreate['user_id'] = Auth::id(); // Pastikan user login (middleware di route akan menangani ini)
        $dataToCreate['status'] = 'Menunggu'; // Status awal

        // Proses Keuntungan Lokasi
        if ($request->has('keuntungan_lokasi')) {
            $keuntungan = array_filter($request->keuntungan_lokasi, fn($value) => !is_null($value) && $value !== '');
            $dataToCreate['keuntungan_lokasi'] = !empty($keuntungan) ? array_values($keuntungan) : null;
        }

        // Proses Gambar Utama
        if ($request->hasFile('gambar_utama')) {
            $dataToCreate['gambar_utama'] = $request->file('gambar_utama')->store('lahan_images/utama', 'public');
        }

        // Proses Gambar Galeri
        for ($i = 1; $i <= 3; $i++) {
            $galeriField = 'galeri_' . $i;
            if ($request->hasFile($galeriField)) {
                $dataToCreate[$galeriField] = $request->file($galeriField)->store('lahan_images/galeri', 'public');
            }
        }

        Lahan::create($dataToCreate);

        return redirect()->route('lahan.index')->with('success', 'Lahan baru berhasil ditambahkan dan sedang menunggu persetujuan.');
    }
}
