<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
// --- Import untuk Ekspor ---
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RatingsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class RatingManagementController extends Controller
{
    /**
     * Method privat untuk membangun query filter rating.
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getRatingQuery(Request $request)
    {
        $query = Rating::query()->with(['user', 'lahan']);

        // Filter berdasarkan Nama Lahan
        if ($request->filled('search_lahan')) {
            $searchTermLahan = $request->search_lahan;
            $query->whereHas('lahan', function ($q) use ($searchTermLahan) {
                $q->where('judul', 'like', '%' . $searchTermLahan . '%');
            });
        }

        // Filter berdasarkan Nama atau Email User (Pemberi Rating)
        if ($request->filled('search_user')) {
            $searchTermUser = $request->search_user;
            $query->whereHas('user', function ($q) use ($searchTermUser) {
                $q->where('name', 'like', '%' . $searchTermUser . '%')
                  ->orWhere('email', 'like', '%' . $searchTermUser . '%');
            });
        }

        // Filter berdasarkan Rating Tepat (Bintang)
        if ($request->filled('exact_rating')) {
            $exactRating = (int) $request->exact_rating;
            if ($exactRating >= 1 && $exactRating <= 5) {
                $query->where('rating', '=', $exactRating);
            }
        }

        // Pengurutan
        $sortBy = $request->input('sort_by', 'terbaru'); // Default ke terbaru
        switch ($sortBy) {
            case 'terlama':
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating_tinggi':
                $query->orderBy('rating', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'rating_rendah':
                $query->orderBy('rating', 'asc')->orderBy('created_at', 'desc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        return $query;
    }

    /**
     * Menampilkan daftar semua rating dengan filter.
     */
    public function index(Request $request)
    {
        $query = $this->getRatingQuery($request);
        $ratings = $query->paginate(10); // Menambahkan paginasi
        return view('admin.ratings.index', compact('ratings'));
    }

    /**
     * Menangani ekspor data rating ke Excel atau PDF.
     */
    public function export(Request $request, $format)
    {
        $query = $this->getRatingQuery($request); // Menggunakan query yang sudah difilter
        $filename = 'laporan-rating-' . date('Y-m-d') . '.' . $format;

        if ($format == 'xlsx') {
            return Excel::download(new RatingsExport($query), $filename);
        }

        if ($format == 'pdf') {
            $data = $query->get(); // Ambil semua data yang cocok
            $pdf = Pdf::loadView('admin.ratings.pdf', compact('data'));
            return $pdf->download($filename);
        }
        
        return redirect()->back()->with('error', 'Format ekspor tidak didukung.');
    }

    /**
     * Menghapus rating oleh admin.
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return redirect()->route('admin.ratings.index')->with('success', 'Rating berhasil dihapus.');
    }
}
