<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
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
            'tanggal_lahir' => 'required|string',
        ]);

        // Cocokkan string, karena DB kamu dd/mm/yyyy
        $user = User::where('nama', $request->nama)
                    ->where('tanggal_lahir', $request->tanggal_lahir)
                    ->first();

        if (!$user) {
            return back()->with('error', 'Nama atau tanggal lahir tidak cocok.')
                         ->withInput();
        }

        // Simpan IP Address
        if (Schema::hasColumn('users', 'ip_address')) {
            $user->ip_address = $request->ip();
            $user->save();
        }

        // Simpan session
        session([
            'siswa_id'   => $user->id,
            'siswa_nama' => $user->nama,
            'ip_address' => $user->ip_address,
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