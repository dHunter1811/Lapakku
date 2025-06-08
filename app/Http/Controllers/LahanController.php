<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class LahanController extends Controller
{
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

        $lahanList = $query->paginate(9);
        return view('lahan.index', compact('lahanList'));
    }

    public function create()
    {
        // Middleware 'auth' pada route sudah memastikan hanya user login yang bisa akses.
        return view('lahan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_lahan' => 'required|string|in:Ruko,Kios,Pasar,Lahan Terbuka,Lainnya',
            'lokasi' => 'required|string|in:Banjarmasin Selatan,Banjarmasin Timur,Banjarmasin Barat,Banjarmasin Tengah,Banjarmasin Utara',
            'harga_sewa' => 'required|numeric|min:1',
            'alamat_lengkap' => 'required|string',
            'keuntungan_lokasi' => 'nullable|array',
            'keuntungan_lokasi.*' => 'nullable|string|max:255',
            'latitude' => ['nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+)|90(\.0+)?)$/'],
            'longitude' => ['nullable', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'gambar_utama' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'latitude.regex' => 'Format latitude tidak valid.',
            'longitude.regex' => 'Format longitude tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lahan.create') // atau lahanbaru.tambah jika Anda menggunakan itu
                        ->withErrors($validator)
                        ->withInput();
        }

        $dataToCreate = $request->only([ // Ambil semua field yang relevan
            'judul', 'deskripsi', 'tipe_lahan', 'lokasi', 'harga_sewa', 'alamat_lengkap',
            'latitude', 'longitude' // PASTIKAN INI DIAMBIL
        ]);
        $dataToCreate['user_id'] = Auth::id();
        $dataToCreate['status'] = 'Menunggu';

        if ($request->has('keuntungan_lokasi')) {
            $keuntungan = array_filter($request->keuntungan_lokasi, fn($value) => !is_null($value) && $value !== '');
            $dataToCreate['keuntungan_lokasi'] = !empty($keuntungan) ? array_values($keuntungan) : null;
        }

        if ($request->hasFile('gambar_utama')) {
            $dataToCreate['gambar_utama'] = $request->file('gambar_utama')->store('lahan_images/utama', 'public');
        }
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
            'harga_sewa' => 'required|numeric|min:1', // Sesuai dengan store
            'alamat_lengkap' => 'required|string',
            'keuntungan_lokasi' => 'nullable|array',
            'keuntungan_lokasi.*' => 'nullable|string|max:255',
            'latitude' => ['nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+)|90(\.0+)?)$/'], // VALIDASI UNTUK KOORDINAT
            'longitude' => ['nullable', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'], // VALIDASI UNTUK KOORDINAT
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galeri_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Untuk status, hanya admin yang bisa mengubahnya melalui form edit lahan milik user.
            // Jika user biasa yang mengedit, statusnya bisa direset ke 'Menunggu' atau dibiarkan.
            // 'status' => (Auth::user()->role === 'admin' && $request->has('status')) ? 'required|string|in:Menunggu,Disetujui,Ditolak' : 'nullable',
        ],[
            'latitude.regex' => 'Format latitude tidak valid.',
            'longitude.regex' => 'Format longitude tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lahan.edit', $lahan->id)
                        ->withErrors($validator)
                        ->withInput();
        }

        // Ambil semua field yang relevan dari request, TERMASUK latitude dan longitude
        $dataToUpdate = $request->only([
            'judul', 'deskripsi', 'tipe_lahan', 'lokasi',
            'harga_sewa', 'alamat_lengkap',
            'latitude', 'longitude' // PASTIKAN INI ADA
        ]);
        
        // Logika status jika user biasa mengedit
        if (Auth::user()->role !== 'admin') {
            // Jika lahan sebelumnya belum disetujui, atau Anda ingin setiap editan direview ulang
            // Anda bisa set status kembali ke 'Menunggu'
            // if ($lahan->status !== 'Disetujui') {
            //    $dataToUpdate['status'] = 'Menunggu';
            // }
            // Untuk saat ini, kita tidak akan mengubah status jika diedit user biasa,
            // kecuali jika ada kebijakan khusus. Admin bisa mengubahnya via panel admin.
        } else {
            // Jika admin mengedit, dan mengirim field status (misalnya dari admin edit form)
            if($request->has('status')){
                $dataToUpdate['status'] = $request->status;
            }
        }

        if ($request->has('keuntungan_lokasi')) {
            $keuntungan = array_filter($request->keuntungan_lokasi, fn($value) => !is_null($value) && $value !== '');
            $dataToUpdate['keuntungan_lokasi'] = !empty($keuntungan) ? array_values($keuntungan) : null;
        } else {
            $dataToUpdate['keuntungan_lokasi'] = $lahan->keuntungan_lokasi; // Pertahankan nilai lama jika tidak ada input baru
        }

        if ($request->hasFile('gambar_utama')) {
            if ($lahan->gambar_utama && Storage::disk('public')->exists($lahan->gambar_utama)) {
                Storage::disk('public')->delete($lahan->gambar_utama);
            }
            $dataToUpdate['gambar_utama'] = $request->file('gambar_utama')->store('lahan_images/utama', 'public');
        }

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
        return redirect()->route('lahan.show', $lahan->id)->with('success', 'Lahan berhasil diperbarui.');
    }

    public function destroy(Lahan $lahan)
    {
        if (Auth::id() !== $lahan->user_id && (Auth::check() && optional(Auth::user())->role !== 'admin')) {
            return redirect()->route('lahan.index')->with('error', 'Anda tidak memiliki izin untuk menghapus lahan ini.');
        }
        if ($lahan->gambar_utama && Storage::disk('public')->exists($lahan->gambar_utama)) {
            Storage::disk('public')->delete($lahan->gambar_utama);
        }
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
