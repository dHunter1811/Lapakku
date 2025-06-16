<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
// --- Import untuk Ekspor ---
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Barryvdh\DomPDF\Facade\Pdf;

class UserManagementController extends Controller
{
    /**
     * Method privat untuk membangun query filter pengguna.
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getUserQuery(Request $request)
    {
        $query = User::query()->withCount('lahan'); // Eager load count relasi lahan

        // Filter berdasarkan Nama atau Email Pengguna
        if ($request->filled('search_nama_email')) {
            $searchTerm = $request->search_nama_email;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter berdasarkan Role Pengguna
        if ($request->filled('search_role')) {
            $query->where('role', $request->search_role);
        }

        // Pengurutan (contoh: nama A-Z dulu)
        $query->orderBy('name', 'asc');

        return $query;
    }

    /**
     * Menampilkan daftar semua pengguna dengan filter.
     */
    public function index(Request $request)
    {
        $query = $this->getUserQuery($request);
        $users = $query->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menangani ekspor data pengguna ke Excel atau PDF.
     */
    public function export(Request $request, $format)
    {
        $query = $this->getUserQuery($request); // Menggunakan query yang sudah difilter
        $filename = 'laporan-pengguna-' . date('Y-m-d') . '.' . $format;

        if ($format == 'xlsx') {
            return Excel::download(new UsersExport($query), $filename);
        }

        if ($format == 'pdf') {
            $data = $query->get(); // Ambil semua data yang cocok
            $pdf = Pdf::loadView('admin.users.pdf', compact('data'));
            return $pdf->download($filename);
        }
        
        return redirect()->back()->with('error', 'Format ekspor tidak didukung.');
    }

    /**
     * Menampilkan form untuk membuat pengguna baru oleh admin (opsional).
     */
    public function create()
    {
        return redirect()->route('admin.users.index')->with('info', 'Fitur tambah user manual belum diimplementasikan.');
    }

    /**
     * Menyimpan pengguna baru oleh admin (opsional).
     */
    public function store(Request $request)
    {
        return redirect()->route('admin.users.index');
    }

    /**
     * Menampilkan detail pengguna.
     */
    public function show(User $user)
    {
        $user->loadCount('lahan');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Menampilkan form untuk mengedit pengguna.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data pengguna oleh admin.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'alamat' => 'nullable|string|max:1000',
            'no_telepon' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto profil
        ];
        
        // Hanya validasi role jika admin tidak mengedit dirinya sendiri
        if (Auth::id() !== $user->id) {
            $rules['role'] = 'required|string|in:user,admin';
        }

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('admin.users.edit', $user->id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $dataToUpdate = $request->only(['name', 'email', 'alamat', 'no_telepon']);
        
        if (Auth::id() !== $user->id) {
            $dataToUpdate['role'] = $request->role;
        }

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        // Handle upload foto profil
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $dataToUpdate['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->update($dataToUpdate);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna oleh admin.
     */
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Hapus foto profil dari storage sebelum menghapus user
        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        
        // Dengan onDelete('cascade') di migrasi lahan, lahan milik user ini akan ikut terhapus.
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
