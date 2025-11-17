<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\QrToken;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSiswa = User::count();

        $absensiHariIni = Absensi::with('user')
            ->whereDate('waktu_absen', Carbon::today())
            ->get();

        $hadir = $absensiHariIni->count();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'hadir',
            'absensiHariIni'
        ));
    }

    public function generateQR()
    {
        return view('admin.qr');
    }

    // ==========================================================
    // 🔥 FINAL QR DINAMIS — DIJAMIN MUNCUL TANPA ERROR
    // ==========================================================
    public function qrJson()
    {
        $kode = rand(100000, 999999);
        $expired = now()->addMinutes(5)->format('H:i:s');

        // Generate SVG QR
        $svgRaw = QrCode::size(300)->generate($kode);

        // Encode Base64 supaya aman dikirim lewat JSON
        $svgBase64 = base64_encode($svgRaw);

        // Simpan token QR
        QrToken::create([
            'token' => $kode,
            'expired_at' => now()->addMinutes(5),
            'status' => 'aktif'
        ]);

        return response()->json([
            'code'       => $kode,
            'svg'        => $svgBase64,
            'expired_at' => $expired,
        ]);
    }

    public function rekap(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::today()->toDateString();

        $rekap = Absensi::with('user')
            ->whereDate('waktu_absen', $tanggal)
            ->get();

        return view('admin.rekap', compact('rekap'));
    }

    public function showAbsensiManual()
    {
        $users = User::all();
        $absensi = Absensi::with('user')->get();

        return view('admin.absensi-manual', compact('users', 'absensi'));
    }

    public function storeAbsensiManual(Request $request)
    {
        Absensi::create([
            'user_id'     => $request->user_id,
            'tanggal'     => $request->tanggal,
            'status'      => $request->status,
            'waktu_absen' => now(),
            'metode'      => 'manual'
        ]);

        return back()->with('success', 'Absensi manual berhasil dibuat.');
    }

    public function deleteAbsensiManual($id)
    {
        Absensi::find($id)->delete();

        return back()->with('success', 'Berhasil dihapus.');
    }
}
