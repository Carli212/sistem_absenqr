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
        $jamAwalMasuk = Carbon::parse(setting('jam_awal', '06:30:00'));
        $jamTepatMasuk = Carbon::parse(setting('jam_tepat', '07:30:00'));
        $jamTerlambat = Carbon::parse(setting('jam_terlambat', '08:00:00'));

        // STATUS HITUNGAN
        if ($absenHariIni) {
            $waktuMasuk = Carbon::parse($absenHariIni->waktu_absen);

            if ($waktuMasuk->lessThan($jamAwalMasuk)) {
                $status = "Datang terlalu awal";
                $selisihMenit = $waktuMasuk->diffInMinutes($jamAwalMasuk);

            } elseif ($waktuMasuk->lessThanOrEqualTo($jamTepatMasuk)) {
                $status = "Datang awal";
                $selisihMenit = $jamTepatMasuk->diffInMinutes($waktuMasuk);

            } elseif ($waktuMasuk->lessThanOrEqualTo($jamTerlambat)) {
                $status = "Tepat waktu";
                $selisihMenit = 0;

            } else {
                $status = "Terlambat";
                $selisihMenit = $waktuMasuk->diffInMinutes($jamTerlambat);
            }
        } else {
            $status = "Belum Absen";
            $selisihMenit = 0;
        }

        // RIWAYAT
        $riwayat = Absensi::where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        return view('user.dashboard', compact(
            'status',
            'jam_absen',
            'selisihMenit',
            'riwayat',
            'foto',
            'absenHariIni'
        ));
    }
}
