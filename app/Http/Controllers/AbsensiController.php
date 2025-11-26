<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function dashboard()
    {
        if (!session('siswa_id')) {
            return redirect()->route('login.siswa.show');
        }

        $userId = session('siswa_id');

        // pakai timezone Asia/Jakarta
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

        $statusHariIni = $absenHariIni ? ucfirst($absenHariIni->status) : 'Belum Absen';

        /**
         * 2. TOTAL HADIR BULAN INI
         */
        $totalBulanIni = Absensi::where('user_id', $userId)
            ->whereYear('waktu_absen', $year)
            ->whereMonth('waktu_absen', $month)
            ->whereIn('status', ['hadir', 'terlambat'])
            ->count();

        /**
         * 3. HITUNG MENIT DATANG
         */
        $menitDatang = null;
        if ($absenHariIni && $absenHariIni->waktu_absen) {

            $jamMasuk     = Carbon::createFromTime(7, 30, 0, 'Asia/Jakarta');
            $jamTerlambat = Carbon::createFromTime(8, 0, 0, 'Asia/Jakarta');

            $waktuMasuk = Carbon::parse($absenHariIni->waktu_absen, 'Asia/Jakarta');

            if ($waktuMasuk->lt($jamMasuk)) {
                $menitDatang = -1 * $waktuMasuk->diffInMinutes($jamMasuk);
            } elseif ($waktuMasuk->between($jamMasuk, $jamTerlambat)) {
                $menitDatang = $waktuMasuk->diffInMinutes($jamMasuk);
            } else {
                $menitDatang = $waktuMasuk->diffInMinutes($jamTerlambat) + 30;
            }
        }

        /**
         * 4. RIWAYAT
         */
        $riwayat = Absensi::where('user_id', $userId)
            ->orderBy('waktu_absen', 'desc')
            ->take(10)
            ->get();

        return view('user.dashboard', [
            'riwayat'        => $riwayat,
            'statusHariIni'  => $statusHariIni,
            'totalBulanIni'  => $totalBulanIni,
            'menitDatang'    => $menitDatang,
            'absenHariIni'   => $absenHariIni,
        ]);
    }
}
