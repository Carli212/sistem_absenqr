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

        $ipNow = $request->ip();

        // cari user sesuai input (case-insensitive lebih aman)
        $user = User::whereRaw('LOWER(nama) = ?', [strtolower($request->nama)])
            ->where('tanggal_lahir', $request->tanggal_lahir)
            ->first();

        if (!$user) {
            return back()->with('error', 'Nama atau tanggal lahir tidak cocok.')
                ->withInput();
        }

        // Jika kolom ip_address ada, cek aturan 1 IP = 1 akun (opsional)
        if (Schema::hasColumn('users', 'ip_address')) {
            $other = User::where('ip_address', $ipNow)
                ->where('id', '<>', $user->id)
                ->first();

            if ($other) {
                return back()->with('error', 'Perangkat ini sudah terdaftar untuk akun lain. Hubungi admin.')
                    ->withInput();
            }

            // simpan ip ke user jika kosong
            if (empty($user->ip_address)) {
                $user->ip_address = $ipNow;
                $user->save();
            }
        }

        // Simpan session
        session([
            'siswa_id'   => $user->id,
            'siswa_nama' => $user->nama,
            'ip_address' => $user->ip_address ?? $ipNow,
        ]);

        // PENTING: redirect ke halaman scan (bukan langsung dashboard)
        return redirect()->route('user.scan');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.siswa.show');
    }
}
