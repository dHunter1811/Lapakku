<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
// --- Import untuk Ekspor ---
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MessagesExport;
use Barryvdh\DomPDF\Facade\Pdf;

class MessageController extends Controller
{
    /**
     * Method privat untuk membangun query filter pesan.
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getMessageQuery(Request $request)
    {
        $query = Message::query()->with('user'); // Eager load relasi user jika ada

        // Filter berdasarkan Nama atau Email Pengirim
        if ($request->filled('search_pengirim')) {
            $searchTerm = $request->search_pengirim;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', '%' . $searchTerm . '%')
                                ->orWhere('email', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Filter berdasarkan Status Baca
        if ($request->filled('search_status_baca')) {
            $statusBaca = $request->search_status_baca;
            if ($statusBaca === '0' || $statusBaca === '1') {
                $query->where('is_read', (bool)$statusBaca);
            }
        }

        // Pengurutan (pesan yang belum dibaca dan terbaru akan muncul paling atas)
        $query->orderBy('is_read', 'asc')->orderBy('created_at', 'desc');

        return $query;
    }

    /**
     * Menampilkan daftar semua pesan masuk dengan filter.
     */
    public function index(Request $request)
    {
        $query = $this->getMessageQuery($request);
        $messages = $query->paginate(10); // Menambahkan paginasi
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Menangani ekspor data pesan masuk ke Excel atau PDF.
     */
    public function export(Request $request, $format)
    {
        $query = $this->getMessageQuery($request); // Menggunakan query yang sudah difilter
        $filename = 'laporan-pesan-masuk-' . date('Y-m-d') . '.' . $format;

        if ($format == 'xlsx') {
            return Excel::download(new MessagesExport($query), $filename);
        }

        if ($format == 'pdf') {
            $data = $query->get(); // Ambil semua data yang cocok
            $pdf = Pdf::loadView('admin.messages.pdf', compact('data'));
            return $pdf->download($filename);
        }

        return redirect()->back()->with('error', 'Format ekspor tidak didukung.');
    }

    /**
     * Menampilkan detail satu pesan dan menandainya sebagai sudah dibaca.
     */
    public function show(Message $message)
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        $message->load('user');
        return view('admin.messages.show', compact('message'));
    }

    /**
     * Menghapus pesan oleh admin.
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
