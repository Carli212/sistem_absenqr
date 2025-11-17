<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user = User::find(session('siswa_id'));

        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        // Hapus foto lama
        if ($user->foto && file_exists(public_path('profile/'.$user->foto))) {
            unlink(public_path('profile/'.$user->foto));
        }

        // Upload foto baru
        $file = $request->file('foto');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('profile'), $namaFile);

        // Simpan
        $user->foto = $namaFile;
        $user->save();

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }
}