<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class LahanController extends Controller
{
    // Method index() tetap sama seperti yang sudah Anda miliki dan perbaiki sebelumnya

    public function index(Request $request)
    {
        $query = Lahan::query()->where('status', 'Disetujui');

        if ($request->filled('tipe_lahan')) {
            $query->where('tipe_lahan', $request->tipe_lahan);
        }
        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul', 'like', '%' . $searchTerm . '%')
                  ->orWhere('alamat_lengkap', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'termurah':
                    $query->orderBy('harga_sewa', 'asc');
                    break;
                case 'termahal':
                    $query->orderBy('harga_sewa', 'desc');
                    break;
                case 'terbaru':
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $lahanList = $query->paginate(9);
        return view('lahan.index', compact('lahanList'));
    }


    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk menambah lahan.');
        }
        return view('lahan.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_lahan' => 'required|string|in:Ruko,Kios,Pasar,Lahan Terbuka,Lainnya',
            'lokasi' => 'required|string|in:Banjarmasin Selatan,Banjarmasin Timur,Banjarmasin Barat,Banjarmasin Tengah,Banjarmasin Utara',
            'harga_sewa' => 'required|numeric|min:0',
            'alamat_lengkap' => 'required|string',
            'keuntungan_lokasi' => 'nullable|array', // Keuntungan adalah array
            'keuntungan_lokasi.*' => 'nullable|string|max:255', // Setiap item dalam array keuntungan adalah string
            'gambar_utama' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lahan.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $dataToCreate = [
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tipe_lahan' => $request->tipe_lahan,
            'lokasi' => $request->lokasi,
            'harga_sewa' => $request->harga_sewa,
            'alamat_lengkap' => $request->alamat_lengkap,
            'status' => 'Menunggu',
        ];

        // Proses Keuntungan Lokasi (filter yang kosong)
        if ($request->has('keuntungan_lokasi')) {
            $keuntungan = array_filter($request->keuntungan_lokasi, function ($value) {
                return !is_null($value) && $value !== '';
            });
            $dataToCreate['keuntungan_lokasi'] = !empty($keuntungan) ? array_values($keuntungan) : null; // Simpan sebagai array atau null jika kosong
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

        return redirect()->route('lahan.index')->with('success', 'Lahan berhasil ditambahkan dan sedang menunggu persetujuan.');
    }

    public function show(Lahan $lahan)
    {
        if ($lahan->status !== 'Disetujui' && (!Auth::check() || (Auth::id() !== $lahan->user_id && optional(Auth::user())->role !== 'admin'))) {
            abort(404);
        }
        $lahan->load(['user', 'ratings.user']);
        return view('lahan.show', compact('lahan'));
    }

    public function edit(Lahan $lahan)
    {
        if (Auth::id() !== $lahan->user_id && (Auth::check() && optional(Auth::user())->role !== 'admin')) {
            return redirect()->route('lahan.index')->with('error', 'Anda tidak memiliki izin untuk mengedit lahan ini.');
        }
        return view('lahan.edit', compact('lahan'));
    }

    public function update(Request $request, Lahan $lahan)
    {
        if (Auth::id() !== $lahan->user_id && (Auth::check() && optional(Auth::user())->role !== 'admin')) {
            return redirect()->route('lahan.index')->with('error', 'Anda tidak memiliki izin untuk memperbarui lahan ini.');
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_lahan' => 'required|string|in:Ruko,Kios,Pasar,Lahan Terbuka,Lainnya',
            'lokasi' => 'required|string|in:Banjarmasin Selatan,Banjarmasin Timur,Banjarmasin Barat,Banjarmasin Tengah,Banjarmasin Utara',
            'harga_sewa' => 'required|numeric|min:0',
            'alamat_lengkap' => 'required|string',
            'keuntungan_lokasi' => 'nullable|array',
            'keuntungan_lokasi.*' => 'nullable|string|max:255',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => (optional(Auth::user())->role === 'admin' && $request->has('status')) ? 'required|string|in:Menunggu,Disetujui,Ditolak' : 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lahan.edit', $lahan->id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $dataToUpdate = $request->only([
            'judul', 'deskripsi', 'tipe_lahan', 'lokasi',
            'harga_sewa', 'alamat_lengkap'
        ]);

        // Proses Keuntungan Lokasi
        if ($request->has('keuntungan_lokasi')) {
            $keuntungan = array_filter($request->keuntungan_lokasi, function ($value) {
                return !is_null($value) && $value !== '';
            });
             $dataToUpdate['keuntungan_lokasi'] = !empty($keuntungan) ? array_values($keuntungan) : null;
        } else {
            // Jika tidak ada input keuntungan_lokasi sama sekali (misalnya semua field dikosongkan), set ke null
            $dataToUpdate['keuntungan_lokasi'] = null;
        }


        if (optional(Auth::user())->role === 'admin' && $request->has('status')) {
            $dataToUpdate['status'] = $request->status;
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
            $hapusGaleriField = 'hapus_' . $galeriField; // Jika Anda menambahkan checkbox hapus

            // Jika ada file baru diupload untuk slot galeri ini
            if ($request->hasFile($galeriField)) {
                // Hapus gambar lama di slot ini jika ada
                if ($lahan->$galeriField && Storage::disk('public')->exists($lahan->$galeriField)) {
                    Storage::disk('public')->delete($lahan->$galeriField);
                }
                // Simpan gambar baru
                $dataToUpdate[$galeriField] = $request->file($galeriField)->store('lahan_images/galeri', 'public');
            }
            // (Opsional) Jika Anda menambahkan checkbox untuk menghapus gambar galeri yang sudah ada
            // elseif ($request->has($hapusGaleriField) && $request->$hapusGaleriField == '1') {
            //     if ($lahan->$galeriField && Storage::disk('public')->exists($lahan->$galeriField)) {
            //         Storage::disk('public')->delete($lahan->$galeriField);
            //     }
            //     $dataToUpdate[$galeriField] = null; // Set path di DB menjadi null
            // }
        }

        $lahan->update($dataToUpdate);

        return redirect()->route('lahan.show', $lahan->id)->with('success', 'Lahan berhasil diperbarui.');
    }

    public function destroy(Lahan $lahan)
    {
        if (Auth::id() !== $lahan->user_id && (Auth::check() && optional(Auth::user())->role !== 'admin')) {
            return redirect()->route('lahan.index')->with('error', 'Anda tidak memiliki izin untuk menghapus lahan ini.');
        }

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

        return redirect()->route('lahan.index')->with('success', 'Lahan berhasil dihapus.');
    }
}
