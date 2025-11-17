<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Absensi;
use App\Models\QrToken;
use Carbon\Carbon;

class ScanQrController extends Controller
{
    /**
     * Tampilkan halaman scan QR
     */
    public function showScan()
    {
        if (!session('siswa_id')) {
            return redirect()->route('login.siswa.show');
        }

        return view('user.scan');
    }

    /**
     * Proses hasil scan QR
     */
    public function processScan()
    {
        // Validasi input
        $validator = Validator::make(request()->all(), [
            'kode' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Form tidak lengkap.');
        }

        $kode = request('kode');

        // Validasi Token QR
        $qr = QrToken::where('token', $kode)
            ->where('status', 'aktif')
            ->where('expired_at', '>', now())
            ->first();

        if (!$qr) {
            return back()->with('error', 'Kode QR tidak valid atau kadaluwarsa.');
        }

        $userId = session('siswa_id');
        $today  = Carbon::today()->toDateString();

        // Cek apakah sudah absen hari ini
        $sudahAbsen = Absensi::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->exists();

        if ($sudahAbsen) {
            return redirect()->route('user.dashboard')
                ->with('error', 'Kamu sudah absen hari ini.');
        }

        // Penentuan status kehadiran
        $jamAbsen     = now()->format('H:i');
        $jamMasuk     = "07:30";
        $jamTerlambat = "08:00";

        if ($jamAbsen <= $jamMasuk) {
            $status = 'hadir';
        } elseif ($jamAbsen <= $jamTerlambat) {
            $status = 'terlambat';
        } else {
            $status = 'alpha';
        }

        // Simpan absensi
        Absensi::create([
            'user_id'     => $userId,
            'tanggal'     => $today,
            'waktu_absen' => now(),
            'status'      => $status,
            'metode'      => 'QR',
        ]);

        return redirect()->route('user.success')
            ->with('success', 'Absensi berhasil direkam!');
    }
}