<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating; // Pastikan Anda sudah membuat model Rating
use App\Models\Lahan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    /**
     * Menyimpan rating baru untuk sebuah lahan.
     * Form rating biasanya ada di halaman detail lahan.
     */
    public function store(Request $request, Lahan $lahan) // Menggunakan Lahan $lahan untuk Route Model Binding
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk memberi rating.');
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Cek apakah user sudah pernah memberi rating untuk lahan ini
        $existingRating = Rating::where('user_id', Auth::id())
                                ->where('lahan_id', $lahan->id)
                                ->first();

        if ($existingRating) {
            return back()->with('error', 'Anda sudah pernah memberi rating untuk lahan ini.');
        }

        Rating::create([
            'user_id' => Auth::id(),
            'lahan_id' => $lahan->id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Terima kasih atas rating Anda!');
    }
}