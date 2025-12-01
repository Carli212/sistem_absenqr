<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrToken;
use App\Models\Absensi;
use Carbon\Carbon;

class ScanQrController extends Controller
{
    public function showScan()
    {
        if (!session('siswa_id')) {
            return redirect()->route('login.siswa.show')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('user.scan');
    }

    public function processScan(Request $request)
    {
        // Ambil kode baik dari form POST maupun dari JSON body
        $kode = $request->input('kode');

        if (!$kode) {
            $payload = json_decode($request->getContent(), true);
            $kode = $payload['kode'] ?? null;
        }

        if (!$kode) {
            return "Kode QR tidak ditemukan";
        }

        $kode = trim($kode);

        $token = QrToken::where('token', $kode)
            ->where('status', 'aktif')
            ->first();

        if (!$token) {
            return "Kode QR tidak valid";
        }

        if (Carbon::now('Asia/Jakarta')->gt($token->expired_at)) {
            return "Kode QR kadaluwarsa";
        }

        $userId = session('siswa_id');

        $sudah = Absensi::where('user_id', $userId)
            ->whereDate('waktu_absen', Carbon::today('Asia/Jakarta'))
            ->first();

        if ($sudah) {
            return "Kamu sudah absen";
        }

        $now = Carbon::now('Asia/Jakarta');
        $jamMasuk = Carbon::createFromTime(7,30,0,'Asia/Jakarta');
        $jamTerlambat = Carbon::createFromTime(8,0,0,'Asia/Jakarta');

        if ($now->lt($jamMasuk)) {
            $status = 'hadir';
        } elseif ($now->between($jamMasuk, $jamTerlambat)) {
            $status = 'hadir';
        } else {
            $status = 'terlambat';
        }

        Absensi::create([
            'user_id' => $userId,
            'tanggal' => $now->toDateString(),
            'waktu_absen' => $now->format('Y-m-d H:i:s'),
            'status' => $status,
            'metode' => 'qr',
            'ip_address' => request()->ip(),
        ]);

        return "OK";
    }
}
