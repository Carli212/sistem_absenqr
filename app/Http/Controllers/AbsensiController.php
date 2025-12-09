<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function dashboard()
    {
        if (!session('siswa_id')) {
            return redirect()->route('login.siswa.show');
        }

        $userId = session('siswa_id');
        $user   = User::find($userId);

        // FOTO PROFIL (fallback)
        $fotoPath = public_path('uploads/' . ($user->foto ?? ''));
        $foto = (file_exists($fotoPath) && !empty($user->foto))
            ? asset('uploads/' . $user->foto)
            : asset('default-avatar.png');

        // ABSENSI HARI INI
        $today = now('Asia/Jakarta')->toDateString();
        $absenHariIni = Absensi::where('user_id', $userId)
            ->whereDate('waktu_absen', $today)
            ->first();

        $jam_absen = $absenHariIni ? $absenHariIni->waktu_absen : '-';

        // === RULE JAM (DIAMBIL DARI SETTINGS DB) ===
        // fallback kalau setting belum ada tetap aman
        $jamAwalMasuk  = Carbon::parse(setting('jam_awal', '06:30'));
        $jamTepatMasuk = Carbon::parse(setting('jam_tepat', '07:30'));
        $jamTerlambat  = Carbon::parse(setting('jam_terlambat', '08:00'));

        // DEFAULT STATUS
        $status_label   = "Belum Absen";
        $status_code    = "none";   // dipakai di UI untuk warna
        $selisihMenit   = 0;

        // HITUNG STATUS & SELISIH
        if ($absenHariIni) {
            $waktuMasuk = Carbon::parse($absenHariIni->waktu_absen);

            if ($waktuMasuk->lessThan($jamAwalMasuk)) {
                $status_label = "Datang Terlalu Awal";
                $status_code  = "early";
                $selisihMenit = $waktuMasuk->diffInMinutes($jamAwalMasuk);

            } elseif ($waktuMasuk->lessThanOrEqualTo($jamTepatMasuk)) {
                $status_label = "Datang Awal";
                $status_code  = "good";
                $selisihMenit = $jamTepatMasuk->diffInMinutes($waktuMasuk);

            } elseif ($waktuMasuk->lessThanOrEqualTo($jamTerlambat)) {
                $status_label = "Tepat Waktu";
                $status_code  = "ontime";
                $selisihMenit = 0;

            } else {
                $status_label = "Terlambat";
                $status_code  = "late";
                $selisihMenit = $waktuMasuk->diffInMinutes($jamTerlambat);
            }
        }

        // Backward compatibility kalau masih ada yang pakai $status di view lain
        $status = $status_label;

        // RIWAYAT
        $riwayat = Absensi::where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        return view('user.dashboard', compact(
            'status',        // legacy
            'status_label',  // label jelas
            'status_code',   // kode untuk styling
            'jam_absen',
            'selisihMenit',
            'riwayat',
            'foto',
            'absenHariIni'
        ));
    }
}
