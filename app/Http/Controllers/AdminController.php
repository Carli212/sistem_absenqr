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
    /* === DASHBOARD === */
    public function dashboard()
    {
        $today = now('Asia/Jakarta')->toDateString();

        return view('admin.dashboard', [
            'totalSiswa' => User::count(),
            'hadir' => Absensi::whereDate('waktu_absen', $today)
                ->whereIn('status', ['hadir', 'terlambat'])
                ->count(),
            'absensiHariIni' => Absensi::with('user')
                ->whereDate('waktu_absen', $today)
                ->orderBy('waktu_absen', 'asc')
                ->get()
        ]);
    }

    /* === GRAFIK REALTIME (FILTER) === */
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
        } elseif ($range === 'bulan-ini') {
            $start = $today->copy()->startOfMonth();
            $end   = $today;
        } else {
            // fallback
            $start = $today->copy()->startOfWeek(Carbon::MONDAY);
            $end   = $today;
        }

        $dates       = [];
        $bestTimes   = [];
        $latestTimes = [];
        $bestNames   = [];
        $latestNames = [];

        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end->copy()->addDay());

        foreach ($period as $date) {

            // lewati Sabtu & Minggu
            if ($date->isWeekend()) {
                continue;
            }

            $formatted = $date->format('Y-m-d');
            $label     = $date->locale('id_ID')->translatedFormat('d M');

            $records = Absensi::with('user')
                ->whereDate('waktu_absen', $formatted)
                ->orderBy('waktu_absen')
                ->get();

            $dates[] = $label;

            if ($records->isEmpty()) {
                $bestTimes[]   = null;
                $latestTimes[] = null;
                $bestNames[]   = '-';
                $latestNames[] = '-';
            } else {
                $first = $records->first();
                $last  = $records->last();

                $bestNames[]   = $first->user->nama ?? '-';
                $latestNames[] = $last->user->nama ?? '-';

                $bestTimes[]   = Carbon::parse($first->waktu_absen)->hour * 60 + Carbon::parse($first->waktu_absen)->minute;
                $latestTimes[] = Carbon::parse($last->waktu_absen)->hour * 60 + Carbon::parse($last->waktu_absen)->minute;
            }
        }

        return response()->json([
            'labels'      => $dates,
            'bestTimes'   => $bestTimes,
            'latestTimes' => $latestTimes,
            'bestNames'   => $bestNames,
            'latestNames' => $latestNames,
        ]);
    }

    /* === KOMPATIBILITAS LAMA: /graph/json === */
    public function graphJson(Request $request)
    {
        // supaya route lama tetap jalan, kita arahkan ke filter default (minggu-ini)
        if (!$request->has('range')) {
            $request->merge(['range' => 'minggu-ini']);
        }
        return $this->graphFilter($request);
    }

    /* === RANKING (jika masih dipakai) === */
    public function rankingKehadiran()
    {
        $month = now('Asia/Jakarta')->month;
        $year  = now('Asia/Jakarta')->year;

        return response()->json(
            Absensi::with('user')
                ->whereMonth('waktu_absen', $month)
                ->whereYear('waktu_absen', $year)
                ->whereIn('status', ['hadir', 'terlambat'])
                ->select('user_id', DB::raw('COUNT(*) as total_hadir'))
                ->groupBy('user_id')
                ->orderByDesc('total_hadir')
                ->get()
                ->map(fn ($row) => [
                    'nama'        => $row->user->nama ?? 'Tidak terdaftar',
                    'total_hadir' => $row->total_hadir,
                ])
        );
    }

    /* === QR CODE === */
    public function generateQR()
    {
        return view('admin.qr');
    }

    public function qrJson()
    {
        $kode = rand(100000, 999999);
        $svg  = base64_encode(QrCode::size(300)->generate($kode));

        QrToken::create([
            'token'      => $kode,
            'expired_at' => now('Asia/Jakarta')->addMinutes(5),
            'status'     => 'aktif',
        ]);

        return response()->json([
            'code'       => $kode,
            'svg'        => $svg,
            'expired_at' => now('Asia/Jakarta')->addMinutes(5)->format('Y-m-d H:i:s'),
        ]);
    }

    /* === ABSENSI MANUAL === */
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
            'status'  => 'required|in:hadir,terlambat,alpha,izin,sakit',
        ]);

        Absensi::create([
            'user_id'     => $request->user_id,
            'tanggal'     => $request->tanggal,
            'waktu_absen' => $request->tanggal . ' ' . now('Asia/Jakarta')->format('H:i:s'),
            'status'      => $request->status,
            'metode'      => 'manual',
        ]);

        return back()->with('success', 'Absensi manual berhasil ditambahkan.');
    }

    public function deleteAbsensiManual($id)
    {
        Absensi::findOrFail($id)->delete();
        return back()->with('success', 'Data absensi berhasil dihapus.');
    }

    /* === KALENDAR === */
    public function calendar()
    {
        $year  = now()->year;
        $month = now()->month;

        return view('admin.calendar', [
            'today'  => now()->format('Y-m-d'),
            'events' => $this->getCalendarEvents($year, $month),
        ]);
    }

    public function calendarDetail($date)
    {
        return response()->json([
            'data' => Absensi::with('user')
                ->whereDate('waktu_absen', $date)
                ->orderBy('waktu_absen')
                ->get()
                ->map(fn ($row) => [
                    'nama'   => $row->user->nama ?? '-',
                    'status' => ucfirst($row->status),
                    'waktu'  => Carbon::parse($row->waktu_absen)->format('H:i'),
                    'metode' => strtoupper($row->metode ?? '-'),
                ]),
        ]);
    }

    public function calendarData($year, $month)
    {
        return response()->json([
            'daysInMonth' => Carbon::create($year, $month, 1)->daysInMonth,
            'firstDay'    => Carbon::create($year, $month, 1)->dayOfWeek,
            'today'       => now()->format('Y-m-d'),
            'events'      => $this->getCalendarEvents($year, $month),
        ]);
    }

    private function getCalendarEvents($year, $month)
    {
        return Absensi::with('user')
            ->whereMonth('waktu_absen', $month)
            ->whereYear('waktu_absen', $year)
            ->get()
            ->map(fn ($row) => [
                'date'   => Carbon::parse($row->waktu_absen)->format('Y-m-d'),
                'status' => $row->status,
                'nama'   => $row->user->nama ?? '-',
                'time'   => Carbon::parse($row->waktu_absen)->format('H:i'),
            ]);
    }

    /* === SETTINGS === */
    public function settings()
    {
        return view('admin.settings', [
            'jamAwal'     => setting('jam_awal', '06:30'),
            'jamTepat'    => setting('jam_tepat', '07:30'),
            'jamTerlambat'=> setting('jam_terlambat', '08:00'),
            'modeAbsen'   => setting('mode_absen', 'normal'),
        ]);
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->only('jam_awal', 'jam_tepat', 'jam_terlambat', 'mode_absen') as $key => $value) {
            DB::table('settings')->updateOrInsert(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    /* === REKAP & EXPORT === */
    public function rekapExport(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();

        $data = Absensi::with('user')
            ->whereDate('waktu_absen', $tanggal)
            ->get();

        $filename = "rekap-absensi-{$tanggal}.csv";

        return response()->streamDownload(function () use ($data) {
            $csv = fopen('php://output', 'w');
            fputcsv($csv, ['Nama', 'Tanggal', 'Waktu', 'Status', 'Metode', 'IP']);

            foreach ($data as $row) {
                fputcsv($csv, [
                    $row->user->nama ?? '-',
                    Carbon::parse($row->waktu_absen)->format('Y-m-d'),
                    Carbon::parse($row->waktu_absen)->format('H:i'),
                    ucfirst($row->status),
                    strtoupper($row->metode ?? '-'),
                    $row->ip_address ?? '',
                ]);
            }

            fclose($csv);
        }, $filename);
    }

    public function rekap(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();

        return view('admin.rekap', [
            'rekap' => Absensi::with('user')
                ->whereDate('waktu_absen', $tanggal)
                ->orderBy('waktu_absen', 'asc')
                ->get(),
            'tanggal' => $tanggal,
        ]);
    }

    /* === CREATE USER (ADMIN PANEL) === */
    public function showCreateUser()
    {
        return view('admin.create-user');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:191',
            'password'      => 'nullable|string|min:4',
            'tanggal_lahir' => 'nullable|date',
            'status'        => 'nullable|in:aktif,lulus',
        ]);

        // kalau password kosong → generate otomatis
        $passwordPlain = $request->password ?: Str::random(8);

        $user = User::create([
            'nama'          => $request->nama,
            'password'      => Hash::make($passwordPlain),
            'tanggal_lahir' => $request->tanggal_lahir,
            'status'        => $request->status ?? 'aktif',
        ]);

        return redirect()->route('admin.user.create')
            ->with('success', 'Siswa baru berhasil ditambahkan.')
            ->with('new_user_password', $request->password ? null : $passwordPlain);
    }
}
