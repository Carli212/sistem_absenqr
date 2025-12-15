<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ActivityLog;
use Carbon\Carbon;

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
            'device_id' => 'nullable|string'
        ]);

        // Cari user berdasarkan nama (case insensitive)
        $user = User::whereRaw('LOWER(nama) = ?', [strtolower($request->nama)])
            ->first();

        if (!$user) {
            return back()->with('error', 'Nama tidak ditemukan.')->withInput();
        }

        // Cek password
        if (!$user->password || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Nama atau password salah.')->withInput();
        }

        /**
         * ============================
         * DEVICE-ID VALIDATION
         * ============================
         */
        $deviceId = $request->device_id;

        // Jika user belum pernah login → daftarkan device sekarang
        if (!$user->device_id) {
            $user->device_id = $deviceId;
        } else {
            // Jika beda → tolak
            if ($user->device_id !== $deviceId) {
                return back()->with('device_error', 'Perangkat ini tidak cocok dengan akun ini!');
            }
        }

        // Update info login
        $user->last_ip = $request->ip();
        $user->user_agent = $request->userAgent();
        $user->last_login_at = Carbon::now('Asia/Jakarta');
        $user->save();


        /**
         * ============================
         * LOG AKTIVITAS
         * ============================
         */
        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'login_siswa',
            'description' => 'Siswa berhasil login',
            'ip' => $request->ip(),
            'device_id' => $deviceId,
            'user_agent' => $request->userAgent()
        ]);


        // Simpan session
        session([
            'siswa_id'   => $user->id,
            'siswa_nama' => $user->nama,
            'siswa_foto' => $user->foto ?? null,
            'device_id'  => $user->device_id
        ]);

        return redirect()->route('user.scan');
    }

    public function logout(Request $request)
    {
        // Log aktivitas logout
        if (session('siswa_id')) {
            ActivityLog::create([
                'user_id' => session('siswa_id'),
                'activity' => 'logout_siswa',
                'description' => 'Siswa logout',
                'ip' => $request->ip(),
                'device_id' => session('device_id'),
                'user_agent' => $request->userAgent()
            ]);
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.siswa.show');
    }
}
