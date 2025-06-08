<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace benar

use App\Http\Controllers\Controller;
use App\Models\User; // Import model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mengecek Auth::id()
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    // Jika Anda ingin semua method di controller ini dilindungi oleh middleware admin
    // public function __construct()
    // {
    //     $this->middleware('admin');
    // }

    /**
     * Menampilkan daftar semua pengguna dengan filter.
     */
    public function index(Request $request)
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
        // Anda bisa menambahkan input 'sort_by' di form jika ingin opsi sorting lebih banyak
        $query->orderBy('name', 'asc');

        $users = $query->paginate(10); // Ambil 10 data per halaman

        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru oleh admin (opsional).
     */
    public function create()
    {
        // return view('admin.users.create');
        // Biasanya admin tidak membuat user secara manual dari sini,
        // tapi jika perlu, Anda bisa membuat view-nya.
        return redirect()->route('admin.users.index')->with('info', 'Fitur tambah user manual belum diimplementasikan.');
    }

    /**
     * Menyimpan pengguna baru oleh admin (opsional).
     */
    public function store(Request $request)
    {
        // Validasi dan logika pembuatan user jika Anda mengimplementasikan form create
        // ...
        // User::create([...]);
        // return redirect()->route('admin.users.index')->with('success', 'User baru berhasil ditambahkan.');
        return redirect()->route('admin.users.index');
    }

    /**
     * Menampilkan detail pengguna.
     */
    public function show(User $user)
    {
        $user->loadCount('lahan'); // Muat jumlah lahan yang dimiliki
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
            'role' => 'required|string|in:user,admin', // Sesuaikan dengan role yang ada
            'alamat' => 'nullable|string|max:1000',
            'no_telepon' => 'nullable|string|max:20',
        ];

        // Validasi password hanya jika diisi
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
        
        // Jangan biarkan admin mengubah role dirinya sendiri menjadi user biasa jika hanya ada 1 admin
        // atau jika itu adalah akun admin yang sedang login (kecuali ada mekanisme lain)
        if (Auth::id() !== $user->id || $request->role === 'admin') {
             $dataToUpdate['role'] = $request->role;
        } else if (Auth::id() === $user->id && $request->role !== 'admin') {
            // Jika admin mencoba mengubah role dirinya sendiri menjadi bukan admin
            return redirect()->route('admin.users.edit', $user->id)
                         ->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri menjadi non-admin.')
                         ->withInput();
        }


        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $user->update($dataToUpdate);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna oleh admin.
     */
    public function destroy(User $user)
    {
        // Tambahkan proteksi agar admin tidak bisa menghapus dirinya sendiri
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Pertimbangkan apa yang terjadi dengan lahan milik user yang dihapus.
        // Defaultnya (dengan onDelete('cascade') pada foreign key di tabel lahans), lahan akan ikut terhapus.
        // Jika tidak ingin lahan terhapus, Anda perlu mengubah constraint atau set user_id pada lahan menjadi null atau ke user default.
        // $user->lahan()->update(['user_id' => ID_USER_ADMIN_DEFAULT_LAIN]); // Contoh memindahkan kepemilikan
        // atau
        // $user->lahan()->delete(); // Jika ingin menghapus lahan juga secara eksplisit

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
