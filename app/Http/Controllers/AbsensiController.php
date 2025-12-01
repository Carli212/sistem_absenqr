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

        // Data user
        $user = User::find($userId);
        $foto = $user->foto ?? null;

        // Waktu
        $today = Carbon::today('Asia/Jakarta');
        $now   = Carbon::now('Asia/Jakarta');
        $month = $now->month;
        $year  = $now->year;

        /**
         * 1. ABSENSI HARI INI
         */
        $absenHariIni = Absensi::where('user_id', $userId)
            ->whereDate('waktu_absen', $today)
            ->first();

        // status untuk UI (hadir, terlambat, izin, sakit, alpha, belum absen)
        $status = $absenHariIni ? strtolower($absenHariIni->status) : 'belum absen';

        // Jam absen
        $jam_absen = $absenHariIni
            ? Carbon::parse($absenHariIni->waktu_absen)->format('H:i:s')
            : '-';

        /**
         * 2. HITUNG SELISIH MENIT DATANG
         */
        $selisihMenit = null;

        if ($absenHariIni && $absenHariIni->waktu_absen) {

            $waktuMasuk = Carbon::parse($absenHariIni->waktu_absen, 'Asia/Jakarta');
            $jamMasuk     = Carbon::createFromTime(7, 30, 0, 'Asia/Jakarta');
            $jamTerlambat = Carbon::createFromTime(8, 0, 0, 'Asia/Jakarta');

            if ($waktuMasuk->lt($jamMasuk)) {
                // Datang lebih awal (negatif)
                $selisihMenit = -$waktuMasuk->diffInMinutes($jamMasuk);

            } elseif ($waktuMasuk->between($jamMasuk, $jamTerlambat)) {
                // Hadir normal
                $selisihMenit = $waktuMasuk->diffInMinutes($jamMasuk);

            } else {
                // Terlambat
                // dihitung dari 07:30 → 08:00 (30 menit) + selisih telat
                $selisihMenit = 30 + ($waktuMasuk->diffInMinutes($jamTerlambat));
            }
        }

        /**
         * 3. RIWAYAT ABSENSI
         */
        $riwayat = Absensi::where('user_id', $userId)
            ->orderBy('waktu_absen', 'desc')
            ->take(10)
            ->get();

        /**
         * 4. TOTAL HADIR BULAN INI
         */
        $totalBulanIni = Absensi::where('user_id', $userId)
            ->whereYear('waktu_absen', $year)
            ->whereMonth('waktu_absen', $month)
            ->whereIn('status', ['hadir', 'terlambat'])
            ->count();

        return view('user.dashboard', [
            'status'        => $status,
            'jam_absen'     => $jam_absen,
            'selisihMenit'  => $selisihMenit,
            'riwayat'       => $riwayat,
            'foto'          => $foto,
            'totalBulanIni' => $totalBulanIni,
        ]);
    }
}
