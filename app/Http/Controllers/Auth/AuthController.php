<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginSiswa()
    {
        return view('auth.login');
    }

    public function processLoginSiswa(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'password' => 'required|string',
        ]);

        // cari user berdasarkan nama (case-insensitive)
        $user = User::whereRaw('LOWER(nama) = ?', [strtolower($request->nama)])
                    ->first();

        if (!$user) {
            return back()->with('error', 'Nama tidak ditemukan.')->withInput();
        }

        // cek password BCRYPT
        if (!$user->password || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Nama atau password salah.')->withInput();
        }

        // simpan session
        session([
            'siswa_id'   => $user->id,
            'siswa_nama' => $user->nama,
        ]);

        return redirect()->route('user.scan');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.siswa.show');
    }
}
