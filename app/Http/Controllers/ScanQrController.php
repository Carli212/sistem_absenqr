<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrToken;
use App\Models\Absensi;
use App\Models\User;
use App\Models\ActivityLog;
use Carbon\Carbon;

class ScanQrController extends Controller
{
    public function showScan()
    {
        if (!session('siswa_id')) {
            return redirect()->route('login.siswa.show')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('user.scan');
    }

    public function processScan(Request $request)
    {
        $kode = $request->input('kode');

        // Jika scanner memakai JSON
        if (!$kode) {
            $payload = json_decode($request->getContent(), true);
            $kode = $payload['kode'] ?? null;
        }

        if (!$kode) return "Kode QR tidak ditemukan";

        // Ambil token dari database
        $token = QrToken::where('token', $kode)
            ->where('status', 'aktif')
            ->first();

        // =============================
        // QR TIDAK VALID → MODE SAVAGE
        // =============================
        if (!$token) {

            session()->flash('savage_mode', [
                'type' => 'qr_invalid',
                'name' => session('siswa_nama'),
            ]);

            ActivityLog::create([
                'user_id' => session('siswa_id'),
                'activity' => 'scan_failed',
                'description' => 'QR tidak valid',
                'ip' => $request->ip(),
                'device_id' => session('device_id'),
                'user_agent' => $request->userAgent()
            ]);

            return "Kode QR tidak valid";
        }

        // =============================
        // QR EXPIRED → MODE SAVAGE
        // =============================
        if (Carbon::now('Asia/Jakarta')->gt($token->expired_at)) {

            session()->flash('savage_mode', [
                'type' => 'qr_expired',
                'name' => session('siswa_nama'),
            ]);

            ActivityLog::create([
                'user_id' => session('siswa_id'),
                'activity' => 'scan_failed',
                'description' => 'QR expired',
                'ip' => $request->ip(),
                'device_id' => session('device_id'),
                'user_agent' => $request->userAgent()
            ]);

            return "Kode QR kadaluwarsa";
        }

        // Ambil user
        $userId = session('siswa_id');
        $user = User::find($userId);

        // =============================
        // CEK DEVICE LOCK
        // =============================
        if ($user->device_id !== session('device_id')) {

            session()->flash('savage_mode', [
                'type' => 'device_mismatch',
                'name' => $user->nama,
            ]);

            ActivityLog::create([
                'user_id' => $userId,
                'activity' => 'scan_failed',
                'description' => 'Device tidak cocok',
                'ip' => $request->ip(),
                'device_id' => session('device_id'),
                'user_agent' => $request->userAgent()
            ]);

            return "Perangkat ini tidak diizinkan untuk absen";
        }

        // =============================
        // CEK SUDAH ABSEN

        $sudah = Absensi::where('user_id', $userId)
            ->whereDate('waktu_absen', Carbon::today('Asia/Jakarta'))
            ->first();

        if ($sudah) {
            return "Kamu sudah absen";
        }

        // =============================
        // TENTUKAN STATUS ABSENSI
        // =============================
        $now = Carbon::now('Asia/Jakarta');
        $jamMasuk = Carbon::createFromTime(7, 30, 0, 'Asia/Jakarta');
        $jamTerlambat = Carbon::createFromTime(8, 0, 0, 'Asia/Jakarta');

        if ($now->lt($jamMasuk)) {
            $status = 'hadir';
            $notifType = 'early';

        } elseif ($now->between($jamMasuk, $jamTerlambat)) {
            $status = 'hadir';
            $notifType = 'ontime';

        } else {
            $status = 'terlambat';
            $notifType = 'late';
        }

        // =============================
        // MODE SAVAGE: TELAT PARAH
        // =============================
        if ($status === 'terlambat' && $now->diffInMinutes($jamTerlambat) > 30) {

            session()->flash('savage_mode', [
                'type' => 'late_extreme',
                'name' => $user->nama,
                'time' => $now->format('H:i:s')
            ]);
        }

        // =============================
        // SIMPAN ABSENSI
        // =============================
        Absensi::create([
            'user_id'    => $userId,
            'tanggal'    => $now->toDateString(),
            'waktu_absen'=> $now->format('Y-m-d H:i:s'),
            'status'     => $status,
            'metode'     => 'qr',
            'ip_address' => $request->ip(),
            'device_id'  => session('device_id'),
            'user_agent' => $request->userAgent(),
        ]);

        // =============================
        // LOG BERHASIL
        // =============================
        ActivityLog::create([
            'user_id' => $userId,
            'activity' => 'scan_success',
            'description' => 'QR valid',
            'ip' => $request->ip(),
            'device_id' => session('device_id'),
            'user_agent' => $request->userAgent()
        ]);

        // =============================
        // NOTIFIKASI NORMAL
        // =============================
        session()->flash('notif_absen', [
            'type' => $notifType,
            'time' => $now->format('H:i:s')
        ]);

        return "OK";
    }
}
