<?php

namespace App\Http\Controllers;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:4096'
        ]);

        $user = User::find(session('siswa_id'));

        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        // ===== Folder upload FINAL =====
        $path = public_path('uploads'); 
        
        // Jika folder belum ada, buat
        if (!is_dir($path)) mkdir($path, 0755, true);

        // Hapus foto lama jika ada
        if ($user->foto && file_exists($path . '/' . $user->foto)) {
            @unlink($path . '/' . $user->foto);
        }

        // Upload file baru
        $file = $request->file('foto');
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->extension();

        $file->move($path, $filename);

        // Simpan ke database
        $user->foto = $filename;
        $user->save();

        // Update session
        session(['siswa_foto' => $filename]);

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }


public function success()
{
    if (!session()->has('siswa_id')) {
        return redirect()->route('login.siswa.show');
    }

    $userId = session('siswa_id');
    $today  = Carbon::now('Asia/Jakarta')->toDateString();

    $absen = Absensi::where('user_id', $userId)
        ->whereDate('waktu_absen', $today)
        ->latest('waktu_absen')
        ->first();

    // Kalau belum absen, jangan boleh masuk halaman success
    if (!$absen) {
        return redirect()->route('user.dashboard');
    }

    return view('user.success', compact('absen'));
}
}
