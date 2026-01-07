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
        'device_id' => 'required|string',
    ]);

    $user = User::whereRaw('LOWER(nama) = ?', [strtolower($request->nama)])
        ->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Nama atau password salah.');
    }

    // ❌ DEVICE LOCK DIHAPUS DARI LOGIN

    // ✅ HANYA LOG AKTIVITAS
    $user->last_ip = $request->ip();
    $user->user_agent = $request->userAgent();
    $user->last_login_at = now();
    $user->save();

    ActivityLog::create([
        'user_id' => $user->id,
        'activity' => 'login_siswa',
        'description' => 'Siswa berhasil login',
        'ip' => $request->ip(),
        'device_id' => $request->device_id,
        'user_agent' => $request->userAgent()
    ]);

    $request->session()->regenerate();

    session([
        'siswa_id' => $user->id,
        'siswa_nama' => $user->nama,
        'device_id' => $request->device_id
    ]);

    return redirect()->route('user.scan');
}


    public function logout(Request $request)
    {
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
