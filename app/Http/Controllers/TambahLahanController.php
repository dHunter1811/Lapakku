<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TambahLahanController extends Controller
{
    public function formTambah()
    {
        return view('lahanbaru.tambah');
    }

    public function simpanLahanBaru(Request $request)
    {
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
            'gambar_utama' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'latitude.regex' => 'Format latitude tidak valid.',
            'longitude.regex' => 'Format longitude tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lahanbaru.tambah')
                ->withErrors($validator)
                ->withInput();
        }

        $dataToCreate = $request->only([
            'judul',
            'deskripsi',
            'tipe_lahan',
            'lokasi',
            'harga_sewa',
            'alamat_lengkap',
            'latitude',
            'longitude',
            'no_whatsapp' // === FIELD DIAMBIL DARI REQUEST ===
        ]);
        $dataToCreate['user_id'] = Auth::id();
        $dataToCreate['status'] = 'Menunggu';

        if ($request->has('keuntungan_lokasi')) {
            $keuntungan = array_filter($request->keuntungan_lokasi, fn($value) => !is_null($value) && $value !== '');
            $dataToCreate['keuntungan_lokasi'] = !empty($keuntungan) ? array_values($keuntungan) : null;
        }

        if ($request->hasFile('gambar_utama')) {
            $dataToCreate['gambar_utama'] = $request->file('gambar_utama')->store('asset_web_images/lahan', 'public');
        }
        for ($i = 1; $i <= 3; $i++) {
            $galeriField = 'galeri_' . $i;
            if ($request->hasFile($galeriField)) {
                $dataToCreate[$galeriField] = $request->file($galeriField)->store('asset_web_images/lahan', 'public');
            }
        }

        Lahan::create($dataToCreate);

        return redirect()->route('lahan.index')->with('success', 'Lahan berhasil ditambahkan dan sedang menunggu persetujuan.');
    }
}
