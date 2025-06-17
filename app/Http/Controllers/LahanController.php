<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File; 

class LahanController extends Controller
{
    public function index(Request $request)
    {
        $query = Lahan::query()
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->where('status', 'Disetujui');

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
                    ->orWhere('alamat_lengkap', 'like', '%' . $searchTerm . '%')
                    ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%');
            });
        }

        $sortBy = $request->input('sort_by', 'terbaru');
        switch ($sortBy) {
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

        $lahanList = $query->paginate(12);
        return view('lahan.index', compact('lahanList'));
    }

    public function create()
    {
        return view('lahan.create');
    }

    public function store(Request $request)
    {
        // Logika upload file di sini masih dalam bentuk komentar.
        // Jika Anda menggunakan TambahLahanController.php, pastikan perbaikan serupa diterapkan di sana.
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_lahan' => 'required|string|in:Ruko,Kios,Pasar,Lahan Terbuka,Lainnya',
            'lokasi' => 'required|string|in:Banjarmasin Selatan,Banjarmasin Timur,Banjarmasin Barat,Banjarmasin Tengah,Banjarmasin Utara',
            'harga_sewa' => 'required|numeric|min:1',
            'alamat_lengkap' => 'required|string',
            'no_whatsapp' => ['nullable', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:20'],
            'keuntungan_lokasi' => 'nullable|array',
            'keuntungan_lokasi.*' => 'nullable|string|max:255',
            'latitude' => ['nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+)|90(\.0+)?)$/'],
            'longitude' => ['nullable', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
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

        $dataToCreate = $request->only([
            'judul', 'deskripsi', 'tipe_lahan', 'lokasi', 'harga_sewa',
            'alamat_lengkap', 'latitude', 'longitude', 'no_whatsapp'
        ]);
        $dataToCreate['user_id'] = Auth::id();
        $dataToCreate['status'] = 'Menunggu';

        if ($request->has('keuntungan_lokasi')) {
            $keuntungan = array_filter($request->keuntungan_lokasi, fn($value) => !is_null($value) && $value !== '');
            $dataToCreate['keuntungan_lokasi'] = !empty($keuntungan) ? array_values($keuntungan) : null;
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
            'harga_sewa' => 'required|numeric|min:1',
            'alamat_lengkap' => 'required|string',
            'no_whatsapp' => ['nullable', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:20'],
            'keuntungan_lokasi' => 'nullable|array',
            'keuntungan_lokasi.*' => 'nullable|string|max:255',
            'latitude' => ['nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+)|90(\.0+)?)$/'],
            'longitude' => ['nullable', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lahan.edit', $lahan->id)->withErrors($validator)->withInput();
        }
        
        $dataToUpdate = $request->only([
            'judul', 'deskripsi', 'tipe_lahan', 'lokasi', 'harga_sewa',
            'alamat_lengkap', 'latitude', 'longitude', 'no_whatsapp'
        ]);

        if (optional(Auth::user())->role !== 'admin' && $lahan->status !== 'Disetujui') {
            $dataToUpdate['status'] = 'Menunggu';
        }

        if ($request->has('keuntungan_lokasi')) {
            $keuntungan = array_filter($request->keuntungan_lokasi, fn($value) => !is_null($value) && $value !== '');
            $dataToUpdate['keuntungan_lokasi'] = !empty($keuntungan) ? array_values($keuntungan) : null;
        } else {
            $dataToUpdate['keuntungan_lokasi'] = null;
        }

        if ($request->hasFile('gambar_utama')) {
            if ($lahan->gambar_utama && File::exists(public_path($lahan->gambar_utama))) {
                File::delete(public_path($lahan->gambar_utama));
            }

            File::makeDirectory(public_path('asset_web_images/lahan'), 0755, true, true);

            $file = $request->file('gambar_utama');
            $namaFile = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('asset_web_images/lahan'), $namaFile);
            $dataToUpdate['gambar_utama'] = 'asset_web_images/lahan/' . $namaFile;
        }

        for ($i = 1; $i <= 3; $i++) {
            $galeriField = 'galeri_' . $i;
            if ($request->hasFile($galeriField)) {
                if ($lahan->$galeriField && File::exists(public_path($lahan->$galeriField))) {
                    File::delete(public_path($lahan->$galeriField));
                }

                File::makeDirectory(public_path('asset_web_images/lahan'), 0755, true, true);

                $file = $request->file($galeriField);
                $namaFile = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('asset_web_images/lahan'), $namaFile);
                $dataToUpdate[$galeriField] = 'asset_web_images/lahan/' . $namaFile;
            }
        }

        $lahan->update($dataToUpdate);

        return redirect()->route('lahan.show', $lahan->id)->with('success', 'Lahan berhasil diperbarui.');
    }

    public function destroy(Lahan $lahan)
    {
        if (Auth::id() !== $lahan->user_id && (Auth::check() && optional(Auth::user())->role !== 'admin')) {
            return redirect()->route('lahan.index')->with('error', 'Anda tidak memiliki izin untuk menghapus lahan ini.');
        }

        if ($lahan->gambar_utama && File::exists(public_path($lahan->gambar_utama))) {
            File::delete(public_path($lahan->gambar_utama));
        }

        for ($i = 1; $i <= 3; $i++) {
            $galeriField = 'galeri_' . $i;
            if ($lahan->$galeriField && File::exists(public_path($lahan->$galeriField))) {
                File::delete(public_path($lahan->$galeriField));
            }
        }

        $lahan->delete();

        return redirect()->route('lahan.index')->with('success', 'Lahan berhasil dihapus.');
    }
}