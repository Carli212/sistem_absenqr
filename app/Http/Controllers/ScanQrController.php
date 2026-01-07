<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrToken;
use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;

class ScanQrController extends Controller
{
    public function showScan()
    {
        return view('user.scan');
    }

    public function processScan(Request $request)
    {
        // ===============================
        // 1️⃣ SESSION VALIDATION
        // ===============================
        if (!session()->has('siswa_id')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Session habis, silakan login ulang'
            ], 401);
        }

        $request->validate([
            'kode' => 'required|string'
        ]);

        $user = User::find(session('siswa_id'));
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak valid'
            ], 401);
        }

        // ===============================
        // 2️⃣ CEK QR TOKEN
        // ===============================
        $token = QrToken::where('token', $request->kode)
            ->where('status', 'aktif')
            ->first();

        if (!$token || Carbon::now('Asia/Jakarta')->gt($token->expired_at)) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR tidak valid atau kedaluwarsa'
            ], 400);
        }

        $today = Carbon::now('Asia/Jakarta')->toDateString();

        // ===============================
        // 3️⃣ CEK SUDAH ABSEN?
        // ===============================
        $already = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->exists();

        if ($already) {
            return response()->json([
                'status' => 'info',
                'message' => '✅ Kamu sudah absen hari ini'
            ]);
        }

        // ===============================
        // 4️⃣ 🔒 DEVICE LOCK (FINAL)
        // ===============================
        $currentDevice = session('device_id');
        $currentIp     = $request->ip();

        // FIRST TIME ABSEN
        if (is_null($user->device_id)) {
            $user->device_id = $currentDevice;
            $user->ip_address = $currentIp;
            $user->save();
        } else {
            // DEVICE MISMATCH
            if ($user->device_id !== $currentDevice) {
                return response()->json([
                    'status' => 'error',
                    'message' => '❌ Perangkat tidak cocok dengan akun ini'
                ], 403);
            }

            // (OPSIONAL) IP LOCK
            if ($user->ip_address && $user->ip_address !== $currentIp) {
                return response()->json([
                    'status' => 'error',
                    'message' => '❌ Jaringan tidak sesuai'
                ], 403);
            }
        }

        // ===============================
        // 5️⃣ SIMPAN ABSENSI
        // ===============================
        $now = Carbon::now('Asia/Jakarta');

        $status = $now->format('H:i') <= '08:00'
            ? 'hadir'
            : 'terlambat';

        Absensi::create([
            'user_id'     => $user->id,
            'tanggal'     => $today,
            'waktu_absen' => $now,
            'status'      => $status,
            'metode'      => 'qr',
            'ip_address'  => $currentIp,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => '🎉 Absensi berhasil'
        ]);
    }
}
