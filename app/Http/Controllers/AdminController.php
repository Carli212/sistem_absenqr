<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\QrToken;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /* ================= DASHBOARD ================= */
    public function dashboard()
    {
        $today = now('Asia/Jakarta')->toDateString();

        $totalSiswa = User::count();

        $hadir = Absensi::where('tanggal', $today)
            ->whereIn('status', ['hadir', 'terlambat'])
            ->count();

        $absensiHariIni = Absensi::with('user')
            ->where('tanggal', $today)
            ->orderBy('waktu_absen', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'hadir',
            'absensiHariIni'
        ));
    }

    /* ================= GRAFIK ================= */
    public function graphFilter(Request $request)
    {
        $range = $request->get('range', 'minggu-ini');
        $today = Carbon::today('Asia/Jakarta');

        if ($range === 'minggu-ini') {
            $start = $today->copy()->startOfWeek(Carbon::MONDAY);
            $end   = $today;
        } elseif ($range === 'minggu-lalu') {
            $start = $today->copy()->subWeek()->startOfWeek(Carbon::MONDAY);
            $end   = $start->copy()->endOfWeek(Carbon::FRIDAY);
        } else {
            $start = $today->copy()->startOfMonth();
            $end   = $today;
        }

        $labels = $bestTimes = $latestTimes = $bestNames = $latestNames = [];

        foreach (Carbon::period($start, $end) as $date) {
            if ($date->isWeekend()) continue;

            $labels[] = $date->translatedFormat('d M');

            $records = Absensi::with('user')
                ->where('tanggal', $date->toDateString())
                ->orderBy('waktu_absen')
                ->get();

            if ($records->isEmpty()) {
                $bestTimes[] = $latestTimes[] = null;
                $bestNames[] = $latestNames[] = '-';
            } else {
                $first = $records->first();
                $last  = $records->last();

                $bestNames[]   = $first->user->nama ?? '-';
                $latestNames[] = $last->user->nama ?? '-';

                $bestTimes[]   = Carbon::parse($first->waktu_absen)->hour * 60
                               + Carbon::parse($first->waktu_absen)->minute;

                $latestTimes[] = Carbon::parse($last->waktu_absen)->hour * 60
                               + Carbon::parse($last->waktu_absen)->minute;
            }
        }

        return response()->json(compact(
            'labels',
            'bestTimes',
            'latestTimes',
            'bestNames',
            'latestNames'
        ));
    }

    /* ================= RANKING ================= */
    public function rankingKehadiran()
    {
        $month = now('Asia/Jakarta')->month;
        $year  = now('Asia/Jakarta')->year;

        return response()->json(
            Absensi::with('user')
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->whereIn('status', ['hadir', 'terlambat'])
                ->select('user_id', DB::raw('COUNT(*) as total_hadir'))
                ->groupBy('user_id')
                ->orderByDesc('total_hadir')
                ->get()
                ->map(fn ($row) => [
                    'nama'        => $row->user->nama ?? '-',
                    'total_hadir' => $row->total_hadir
                ])
        );
    }

    /* ================= QR ================= */
    public function generateQR()
    {
        return view('admin.qr');
    }

    public function qrJson()
    {
        $kode = rand(100000, 999999);

        QrToken::create([
            'token'      => $kode,
            'expired_at' => now('Asia/Jakarta')->addMinutes(5),
            'status'     => 'aktif'
        ]);

        return response()->json([
            'code'       => $kode,
            'svg'        => base64_encode(QrCode::size(300)->generate($kode)),
            'expired_at' => now('Asia/Jakarta')->addMinutes(5)->format('Y-m-d H:i:s')
        ]);
    }

    /* ================= ABSENSI MANUAL ================= */
    public function showAbsensiManual()
    {
        return view('admin.absensi-manual', [
            'users'   => User::orderBy('nama')->get(),
            'absensi' => Absensi::with('user')->latest()->get(),
        ]);
    }

    public function storeAbsensiManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'status'  => 'required'
        ]);

        Absensi::create([
            'user_id'     => $request->user_id,
            'tanggal'     => $request->tanggal,
            'waktu_absen' => $request->tanggal . ' ' . now('Asia/Jakarta')->format('H:i:s'),
            'status'      => $request->status,
            'metode'      => 'manual'
        ]);

        return back()->with('success', 'Absensi manual berhasil.');
    }

    /* ================= CREATE USER ================= */
    public function storeUser(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:191',
            'password' => 'nullable|string|min:4'
        ]);

        $plain = $request->password ?: Str::random(8);

        User::create([
            'nama'     => $request->nama,
            'password' => Hash::make($plain),
        ]);

        return back()->with('success', 'User berhasil ditambahkan.')
                     ->with('new_user_password', $request->password ? null : $plain);
    }
}
