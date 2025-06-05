<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingManagementController extends Controller
{
    public function index(Request $request)
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
                $query->orderBy('rating', 'desc')->orderBy('created_at', 'desc'); // Rating tertinggi, lalu terbaru
                break;
            case 'rating_rendah':
                $query->orderBy('rating', 'asc')->orderBy('created_at', 'desc'); // Rating terendah, lalu terbaru
                break;
            case 'terbaru':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $ratings = $query->paginate(10);

        return view('admin.ratings.index', compact('ratings'));
    }

    public function destroy(Rating $rating)
    {
        $rating->delete();
        return redirect()->route('admin.ratings.index')->with('success', 'Rating berhasil dihapus.');
    }
}
