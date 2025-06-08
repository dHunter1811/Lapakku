<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
// --- Import untuk Ekspor ---
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LahanExport;
use Barryvdh\DomPDF\Facade\Pdf;

class LahanManagementController extends Controller
{
    /**
     * Method privat untuk membangun query filter lahan agar bisa dipakai ulang.
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getLahanQuery(Request $request)
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
                $query->orderBy('created_at', 'desc');
                break;
        }
        return $query;
    }

    /**
     * Menampilkan daftar semua lahan untuk manajemen admin.
     */
    public function index(Request $request)
    {
        $query = $this->getLahanQuery($request);
        $lahanList = $query->paginate(10);
        return view('admin.lahan.index', compact('lahanList'));
    }

    /**
     * Menangani ekspor data lahan ke Excel atau PDF.
     */
    public function export(Request $request, $format)
    {
        $query = $this->getLahanQuery($request); // Menggunakan query yang sudah difilter
        $filename = 'laporan-data-lahan-' . date('Y-m-d') . '.' . $format;

        if ($format === 'xlsx') {
            return Excel::download(new LahanExport($query), $filename);
        } elseif ($format === 'pdf') {
            $data = $query->get(); // Ambil semua data yang cocok untuk PDF
            $pdf = Pdf::loadView('admin.lahan.pdf', compact('data'));
            return $pdf->download($filename);
        }
        
        return redirect()->back()->with('error', 'Format ekspor tidak didukung.');
    }

    /**
     * Menampilkan form untuk admin mengedit lahan.
     */
    public function edit(Lahan $lahan)
    {
        $lahan->load('user');
        return view('admin.lahan.edit', compact('lahan'));
    }

    /**
     * Memperbarui data lahan oleh admin.
     */
    public function update(Request $request, Lahan $lahan)
    {
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
            'status' => 'required|string|in:Menunggu,Disetujui,Ditolak',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.lahan.edit', $lahan->id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $dataToUpdate = $request->only([
            'judul', 'deskripsi', 'tipe_lahan', 'lokasi', 'harga_sewa', 'alamat_lengkap', 'status',
            'latitude', 'longitude', 'no_whatsapp'
        ]);

        if ($request->has('keuntungan_lokasi')) {
            $keuntungan = array_filter($request->keuntungan_lokasi, fn($value) => !is_null($value) && $value !== '');
            $dataToUpdate['keuntungan_lokasi'] = !empty($keuntungan) ? array_values($keuntungan) : null;
        } else {
            $dataToUpdate['keuntungan_lokasi'] = null;
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

        return redirect()->route('admin.lahan.index')->with('success', 'Data lahan berhasil diperbarui.');
    }

    public function approve(Lahan $lahan)
    {
        $lahan->update(['status' => 'Disetujui']);
        return redirect()->back()->with('success', 'Lahan "' . $lahan->judul . '" berhasil disetujui.');
    }

    public function reject(Lahan $lahan)
    {
        $lahan->update(['status' => 'Ditolak']);
        return redirect()->back()->with('success', 'Lahan "' . $lahan->judul . '" berhasil ditolak.');
    }

    public function destroy(Lahan $lahan)
    {
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
        return redirect()->route('admin.lahan.index')->with('success', 'Lahan "' . $lahan->judul . '" berhasil dihapus permanen.');
    }
}
