<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace benar

use App\Http\Controllers\Controller;
use App\Models\Message; // Import model Message
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Jika Anda ingin semua method di controller ini dilindungi oleh middleware admin
    // public function __construct()
    // {
    //     $this->middleware('admin');
    // }

    /**
     * Menampilkan daftar semua pesan masuk dengan filter.
     */
    public function index(Request $request)
    {
        $query = Message::query()->with('user'); // Eager load relasi user jika ada

        // Filter berdasarkan Nama atau Email Pengirim
        if ($request->filled('search_pengirim')) {
            $searchTerm = $request->search_pengirim;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%')
                  // Jika pesan bisa dikirim oleh user yang login dan Anda ingin mencari berdasarkan nama user juga:
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', '%' . $searchTerm . '%')
                                ->orWhere('email', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Filter berdasarkan Status Baca
        if ($request->filled('search_status_baca')) {
            $statusBaca = $request->search_status_baca;
            // Nilai dari form adalah '0' untuk Belum Dibaca (false) dan '1' untuk Sudah Dibaca (true)
            if ($statusBaca === '0' || $statusBaca === '1') {
                $query->where('is_read', (bool)$statusBaca);
            }
        }

        // Pengurutan (contoh: pesan terbaru dulu, lalu yang belum dibaca)
        $query->orderBy('is_read', 'asc')->orderBy('created_at', 'desc');

        $messages = $query->paginate(10); // Ambil 10 data per halaman

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Menampilkan detail satu pesan.
     * Juga menandai pesan sebagai sudah dibaca.
     */
    public function show(Message $message)
    {
        // Tandai pesan sebagai sudah dibaca jika belum
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        $message->load('user'); // Eager load user jika belum
        return view('admin.messages.show', compact('message'));
    }

    /**
     * Menghapus pesan oleh admin.
     */
    public function destroy(Message $message)
    {
        // Tambahkan otorisasi jika perlu
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Pesan berhasil dihapus.');
    }

    // Opsional: Method untuk toggle status baca dari halaman index (jika diperlukan)
    // public function toggleRead(Message $message)
    // {
    //     $message->update(['is_read' => !$message->is_read]);
    //     return redirect()->back()->with('success', 'Status baca pesan berhasil diubah.');
    // }
}
