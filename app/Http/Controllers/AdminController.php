<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\QrToken;
use Carbon\Carbon;
use Carbon\CarbonPeriod; // ← WAJIB
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

        // HADIR (hadir + terlambat = sudah datang)
        $hadir = Absensi::whereDate('waktu_absen', $today)
            ->whereIn('status', ['hadir', 'terlambat'])
            ->count();

        // HADIR MURNI
        $hadirHariIni = Absensi::whereDate('waktu_absen', $today)
            ->where('status', 'hadir')
            ->count();

        // TERLAMBAT
        $terlambatHariIni = Absensi::whereDate('waktu_absen', $today)
            ->where('status', 'terlambat')
            ->count();

        // SUDAH ABSEN
        $sudahAbsen = Absensi::whereDate('waktu_absen', $today)
            ->distinct('user_id')
            ->count('user_id');

        // BELUM ABSEN
        $belumAbsen = max($totalSiswa - $sudahAbsen, 0);

        // STATUS QR
        $qrAktif = QrToken::where('status', 'aktif')
            ->where('expired_at', '>', now())
            ->exists();

        // DATA TABEL HARI INI
        $absensiHariIni = Absensi::with('user')
            ->whereDate('waktu_absen', $today)
            ->orderBy('waktu_absen')
            ->get();

        // STATUS QR
        $qrAktif = QrToken::where('status', 'aktif')
            ->where('expired_at', '>', now())
            ->exists();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'hadir',
            'hadirHariIni',
            'terlambatHariIni',
            'belumAbsen',
            'qrAktif',
            'absensiHariIni'
        ));
    }


    /* ================= GRAFIK ================= */
    public function graphFilter(Request $request)
    {
        $today = Carbon::today('Asia/Jakarta');
        $start = $today->copy()->startOfWeek(Carbon::MONDAY);

        $labels = [];
        $bestTimes = [];
        $latestTimes = [];
        $bestNames = [];
        $latestNames = [];

        foreach (CarbonPeriod::create($start, $today) as $date) {
            if ($date->isWeekend())
                continue;

            $labels[] = $date->translatedFormat('d M');

            $records = Absensi::with('user')
                ->whereDate('waktu_absen', $date->toDateString())
                ->orderBy('waktu_absen')
                ->get();

            if ($records->isEmpty()) {
                $bestTimes[] = null;
                $latestTimes[] = null;
                $bestNames[] = '-';
                $latestNames[] = '-';
            } else {
                $first = $records->first();
                $last = $records->last();

                $bestNames[] = $first->user->nama ?? '-';
                $latestNames[] = $last->user->nama ?? '-';

                $bestTimes[] = Carbon::parse($first->waktu_absen)->hour * 60
                    + Carbon::parse($first->waktu_absen)->minute;

                $latestTimes[] = Carbon::parse($last->waktu_absen)->hour * 60
                    + Carbon::parse($last->waktu_absen)->minute;
            }
        }

        return response()->json([
            'labels' => $labels,
            'bestTimes' => $bestTimes,
            'latestTimes' => $latestTimes,
            'bestNames' => $bestNames,
            'latestNames' => $latestNames,
        ]);
    }
    public function rankingKehadiran()
    {
        return response()->json(
            Absensi::select('user_id', DB::raw('COUNT(*) as total'))
                ->whereIn('status', ['hadir', 'terlambat'])
                ->groupBy('user_id')
                ->with('user')
                ->orderByDesc('total')
                ->get()
                ->map(fn($r) => [
                    'nama' => $r->user->nama,
                    'total' => $r->total
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
        $code = rand(100000, 999999);

        QrToken::create([
            'token' => $code,
            'expired_at' => now()->addMinutes(5),
            'status' => 'aktif'
        ]);

        return response()->json([
            'code' => $code,
            'svg' => base64_encode(QrCode::size(300)->generate($code))
        ]);
    }

    /* ================= ABSENSI MANUAL ================= */
    public function showAbsensiManual()
    {
        return view('admin.absensi-manual', [
            'users' => User::orderBy('nama')->get(),
            'absensi' => Absensi::with('user')
                ->orderBy('waktu_absen', 'desc')->get()
        ]);
    }

    public function storeAbsensiManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpha'
        ]);

        $absensi = Absensi::where('user_id', $request->user_id)
            ->whereDate('waktu_absen', $request->tanggal)
            ->first();

        if ($absensi) {
            // UPDATE saja
            $absensi->update([
                'status' => $request->status,
                'metode' => 'manual'
            ]);

            return back()->with('success', 'Status absensi berhasil diperbarui.');
        }

        // BELUM ADA → BUAT BARU
        Absensi::create([
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
            'waktu_absen' => $request->tanggal . ' ' . now()->format('H:i:s'),
            'status' => $request->status,
            'metode' => 'manual'
        ]);

        return back()->with('success', 'Absensi manual berhasil ditambahkan.');
    }

    public function deleteAbsensiManual($id)
    {
        Absensi::findOrFail($id)->delete();
        return back()->with('success', 'Absensi berhasil dihapus');
    }

    /* ================= REKAP ================= */
    public function rekap(Request $request)
    {
        $rekap = Absensi::with('user')
            ->when($request->tanggal, function ($q) use ($request) {
                $q->whereDate('waktu_absen', $request->tanggal);
            })
            ->orderBy('waktu_absen', 'desc')
            ->paginate(10); // ✅ PAKAI PAGINATION

        return view('admin.rekap', compact('rekap'));
    }

    /* ================= KALENDER ================= */
    public function calendar()
    {
        return view('admin.calendar');
    }

    public function calendarDetail($date)
    {
        return response()->json([
            'data' => Absensi::with('user')
                ->whereDate('waktu_absen', $date)->get()
        ]);
    }

    public function calendarData($year, $month)
    {
        return response()->json([
            'firstDay' => Carbon::create($year, $month, 1)->dayOfWeek,
            'daysInMonth' => Carbon::create($year, $month)->daysInMonth,
            'events' => Absensi::whereYear('waktu_absen', $year)
                ->whereMonth('waktu_absen', $month)->get(),
            'today' => now()->toDateString()
        ]);
    }

    /* ================= CREATE USER ================= */
    public function showCreateUser()
    {
        return view('admin.create-user');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'password' => 'nullable|min:4'
        ]);

        $pwd = $request->password ?: Str::random(8);

        User::create([
            'nama' => $request->nama,
            'password' => Hash::make($pwd)
        ]);

        return back()->with('success', 'Siswa ditambahkan')
            ->with('new_user_password', $request->password ? null : $pwd);
    }
    /* ================= MANAJEMEN PESERTA ================= */
    public function manageUser()
    {
        $today = Carbon::today('Asia/Jakarta');

        // User + absensi hari ini
        $users = User::with([
            'absensis' => function ($q) use ($today) {
                $q->whereDate('waktu_absen', $today);
            }
        ])->orderBy('nama')->get();

        // Statistik BENAR
        $total = $users->count();

        $aktifHariIni = Absensi::whereDate('waktu_absen', $today)
            ->distinct('user_id')
            ->count('user_id');

        $tidakAktifHariIni = $total - $aktifHariIni;

        $baruBulanIni = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.users', compact(
            'users',
            'total',
            'aktifHariIni',
            'tidakAktifHariIni',
            'baruBulanIni'
        ));
    }


    /* ================= UPDATE STATUS ABSENSI ================= */
    public function updateAbsensiStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpha'
        ]);

        $absensi = Absensi::findOrFail($id);
        $absensi->update([
            'status' => $request->status,
            'metode' => 'manual'
        ]);

        return back()->with('success', 'Status absensi berhasil diperbarui.');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        User::findOrFail($id)->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'Data peserta berhasil diperbarui');
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('success', 'Peserta berhasil dihapus');
    }
    public function liveMonitor()
    {
        $today = now('Asia/Jakarta')->toDateString();

        $absenTerbaru = Absensi::with('user')
            ->whereDate('waktu_absen', $today)
            ->orderByDesc('waktu_absen')
            ->limit(10)
            ->get()
            ->map(function ($a) {
                return [
                    'nama' => $a->user->nama,
                    'status' => $a->status,
                    'waktu' => $a->waktu_absen
                        ?Carbon::parse($a->waktu_absen)->format('H:i:s')
                        : '-'
                ];
            });

        $totalSiswa = User::count();

        $sudahAbsen = Absensi::whereDate('waktu_absen', $today)
            ->distinct('user_id')
            ->count('user_id');

        return response()->json([
            'list' => $absenTerbaru,
            'total' => $totalSiswa,
            'sudahAbsen' => $sudahAbsen,
            'belumAbsen' => max($totalSiswa - $sudahAbsen, 0)
        ]);
    }

    /* ================= SETTINGS ================= */
    public function settings()
    {
        return view('admin.settings', [
            'jamAwal' => setting('jam_awal', '06:30'),
            'jamTepat' => setting('jam_tepat', '07:30'),
            'jamTerlambat' => setting('jam_terlambat', '08:00'),
            'modeAbsen' => setting('mode_absen', 'normal')
        ]);
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->except('_token') as $k => $v) {
            DB::table('settings')->updateOrInsert(
                ['key' => $k],
                ['value' => $v]
            );
        }

        return back()->with('success', 'Pengaturan disimpan');
    }
}
