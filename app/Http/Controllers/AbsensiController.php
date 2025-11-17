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

        $today     = Carbon::today();
        $now       = Carbon::now();
        $month     = $now->month;
        $year      = $now->year;

        // Ambil absen hari ini
        $absenHariIni = Absensi::where('user_id', $userId)
            ->whereDate('waktu_absen', $today)
            ->first();

        // Tentukan status hari ini
        if ($absenHariIni) {
            $statusHariIni = ucfirst($absenHariIni->status);
        } else {
            // Belum absen (bukan otomatis alfa)
            $statusHariIni = 'Belum Absen';
        }

        // Hitung hadir + telat saja
        $totalBulanIni = Absensi::where('user_id', $userId)
            ->whereYear('waktu_absen', $year)
            ->whereMonth('waktu_absen', $month)
            ->whereIn('status', ['hadir', 'terlambat'])
            ->count();

        // Riwayat terbaru
        $riwayat = Absensi::where('user_id', $userId)
            ->orderBy('waktu_absen', 'desc')
            ->take(10)
            ->get();

        return view('user.dashboard', [
            'riwayat'        => $riwayat,
            'statusHariIni'  => $statusHariIni,
            'totalBulanIni'  => $totalBulanIni,
        ]);
    }
}
