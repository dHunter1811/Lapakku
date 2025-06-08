<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User; // Pastikan User model di-import

class UserProfileController extends Controller
{
    /**
     * Menampilkan form untuk mengedit profil pengguna yang sedang login.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user')); // Buat view resources/views/profile/edit.blade.php
    }

    /**
     * Memperbarui profil pengguna yang sedang login.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id], // Email harus unik kecuali untuk user saat ini
            'alamat' => ['nullable', 'string', 'max:1000'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'current_password' => ['nullable', 'required_with:new_password', 'string', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    return $fail(__('Password saat ini tidak cocok.'));
                }
            }],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required_with' => 'Password saat ini diperlukan jika Anda ingin mengubah password.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Update data dasar
        $user->name = $request->name;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->no_telepon = $request->no_telepon;

        // Update password jika diisi
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        // Update foto profil jika ada yang diupload
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada dan bukan path default (walaupun accessor sudah menangani default)
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            // Simpan foto baru
            $user->profile_photo_path = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
