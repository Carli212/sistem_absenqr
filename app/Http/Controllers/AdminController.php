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
    // =====================================================
    // 📌 DASHBOARD ADMIN
    // =====================================================
    public function dashboard()
    {
        $totalSiswa = User::count();

        $absensiHariIni = Absensi::with('user')
            ->whereDate('waktu_absen', Carbon::today('Asia/Jakarta'))
            ->orderBy('waktu_absen', 'asc')
            ->get();

        $hadir = $absensiHariIni->whereIn('status', ['hadir', 'terlambat'])->count();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'hadir',
            'absensiHariIni'
        ));
    }

    // =====================================================
    // 📌 QR PAGE
    // =====================================================
    public function generateQR()
    {
        return view('admin.qr');
    }

    // =====================================================
    // 📌 QR JSON (Auto Refresh)
    // =====================================================
    public function qrJson()
    {
        $kode = rand(100000, 999999);

        $svgRaw = QrCode::size(300)->generate($kode);
        $svgBase64 = base64_encode($svgRaw);

        QrToken::create([
            'token' => $kode,
            'expired_at' => now('Asia/Jakarta')->addMinutes(5),
            'status' => 'aktif'
        ]);

        return response()->json([
            'code' => $kode,
            'svg' => $svgBase64,
            'expired_at' => now('Asia/Jakarta')->addMinutes(5)->format('H:i:s'),
        ]);
    }

    // =====================================================
    // 📌 API ABSENSI TODAY JSON
    // =====================================================
    public function absensiTodayJson()
    {
        $absensi = Absensi::with('user')
            ->whereDate('waktu_absen', Carbon::today('Asia/Jakarta'))
            ->orderBy('waktu_absen', 'asc')
            ->get()
            ->map(function ($a) {
                return [
                    'nama' => $a->user->nama ?? '-',
                    'status' => ucfirst($a->status),
                    'waktu' => $a->waktu_absen
                        ? Carbon::parse($a->waktu_absen)->format('H:i:s')
                        : '-',
                ];
            });

        return response()->json(['data' => $absensi]);
    }

    // =====================================================
    // 📝 FORM ABSENSI MANUAL
    // =====================================================
    public function showAbsensiManual()
    {
        $users = User::orderBy('nama')->get();

        $absensi = Absensi::with('user')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.absensi-manual', compact('users', 'absensi'));
    }

    // =====================================================
    // 📝 SIMPAN ABSENSI MANUAL
    // =====================================================
    public function storeAbsensiManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,terlambat,alpha,izin,sakit,manual',
        ]);

        Absensi::create([
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
            'waktu_absen' => $request->tanggal . ' 00:00:00',
            'status' => $request->status,
            'metode' => 'manual',
            'ip_address' => null,
        ]);

        return back()->with('success', 'Absensi manual berhasil ditambahkan.');
    }

    // =====================================================
    // 🗑 HAPUS ABSENSI MANUAL
    // =====================================================
    public function deleteAbsensiManual($id)
    {
        Absensi::findOrFail($id)->delete();

        return back()->with('success', 'Data absensi berhasil dihapus.');
    }

    // =====================================================
    // ➕ FORM TAMBAH USER
    // =====================================================
    public function showCreateUser()
    {
        return view('admin.create-user');
    }

    // =====================================================
    // ➕ SIMPAN USER BARU
    // =====================================================
    public function storeUser(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:191',
            'tanggal_lahir' => 'required|string',
        ]);

        User::create([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'ip_address' => null,
            'foto' => null,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Siswa baru berhasil ditambahkan.');
    }

    // =====================================================
    // 📌 REKAP ABSENSI — INI YANG HILANG!
    // =====================================================
    public function rekap(Request $request)
    {
        $tanggal = $request->tanggal ?? now('Asia/Jakarta')->toDateString();

        $rekap = Absensi::with('user')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('waktu_absen')
            ->get();

        return view('admin.rekap', compact('rekap'));
    }

    // =====================================================
    // 📉 GRAPH JSON
    // =====================================================
    public function graphJson(Request $request)
    {
        $days = $request->days ?? 7;

        $labels = [];
        $earliest = [];
        $latest = [];

        for ($i = 0; $i < $days; $i++) {
            $date = Carbon::today('Asia/Jakarta')->subDays($i);
            $labels[] = $date->format('d M');

            $absensi = Absensi::whereDate('waktu_absen', $date)->get();

            if ($absensi->count()) {
                $first = $absensi->min('waktu_absen');
                $last  = $absensi->max('waktu_absen');

                $earliest[] = Carbon::parse($first)->diffInMinutes('00:00');
                $latest[]   = Carbon::parse($last)->diffInMinutes('00:00');
            } else {
                $earliest[] = null;
                $latest[]   = null;
            }
        }

        return response()->json([
            'labels' => array_reverse($labels),
            'earliest' => array_reverse($earliest),
            'latest' => array_reverse($latest)
        ]);
    }
}
