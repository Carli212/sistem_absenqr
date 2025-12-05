<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\QrToken;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // DASHBOARD ADMIN
    public function dashboard()
    {
        $totalSiswa = User::count();
        $today = Carbon::today('Asia/Jakarta')->toDateString();

        // ambil absensi hari ini berdasarkan waktu_absen (source of truth)
        $absensiHariIni = Absensi::with('user')
            ->whereDate('waktu_absen', $today)
            ->orderBy('waktu_absen', 'asc')
            ->get();

        // hitung hadir (hadir + terlambat)
        $hadir = Absensi::whereDate('waktu_absen', $today)
            ->whereIn('status', ['hadir', 'terlambat'])
            ->count();

        return view('admin.dashboard', compact('totalSiswa', 'hadir', 'absensiHariIni'));
    }

    // TAMPILKAN HALAMAN QR
    public function generateQR()
    {
        return view('admin.qr');
    }

    // API: Buat token QR (JSON) untuk polling di view admin.qr
    public function qrJson()
    {
        $kode = rand(100000, 999999);

        // generate SVG QR (string)
        $svgRaw = QrCode::size(300)->generate($kode);
        $svgBase64 = base64_encode($svgRaw);

        QrToken::create([
            'token' => (string) $kode,
            'expired_at' => now('Asia/Jakarta')->addMinutes(5),
            'status' => 'aktif'
        ]);

        return response()->json([
            'code' => $kode,
            'svg' => $svgBase64,
            'expired_at' => now('Asia/Jakarta')->addMinutes(5)->format('Y-m-d H:i:s'),
        ]);
    }

    // API: Ambil absensi hari ini (dipakai polling tabel di dashboard admin)
    public function absensiTodayJson()
    {
        $today = Carbon::today('Asia/Jakarta')->toDateString();

        $absensi = Absensi::with('user')
            ->whereDate('waktu_absen', $today)
            ->orderBy('waktu_absen', 'asc')
            ->get()
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'nama' => $a->user->nama ?? '-',
                    'tanggal_lahir' => $a->user->tanggal_lahir ?? '-',
                    'status' => ucfirst($a->status),
                    'waktu' => $a->waktu_absen
                        ? Carbon::parse($a->waktu_absen, 'Asia/Jakarta')->format('H:i:s')
                        : '-',
                    'ip' => $a->ip_address ?? '-',
                    'metode' => $a->metode ?? '-',
                ];
            });

        return response()->json(['data' => $absensi]);
    }

    // TAMPILAN FORM ABSENSI MANUAL
    public function showAbsensiManual()
    {
        $users = User::orderBy('nama')->get();

        $absensi = Absensi::with('user')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.absensi-manual', compact('users', 'absensi'));
    }

    // SIMPAN ABSENSI MANUAL (gunakan timezone Asia/Jakarta agar whereDate konsisten)
    public function storeAbsensiManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,terlambat,alpha,izin,sakit,manual',
        ]);

        // gunakan waktu saat ini (Asia/Jakarta) tetapi tetap pada tanggal yang diinput
        $timeNow = now('Asia/Jakarta')->format('H:i:s');
        $waktuAbsen = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $request->tanggal . ' ' . $timeNow,
            'Asia/Jakarta'
        )->toDateTimeString();

        Absensi::create([
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
            'waktu_absen' => $waktuAbsen,
            'status' => $request->status,
            'metode' => 'manual',
            'ip_address' => null,
        ]);

        return back()->with('success', 'Absensi manual berhasil ditambahkan.');
    }

    // HAPUS ABSENSI MANUAL
    public function deleteAbsensiManual($id)
    {
        $abs = Absensi::findOrFail($id);
        $abs->delete();

        return back()->with('success', 'Data absensi berhasil dihapus.');
    }

    // FORM TAMBAH USER
    public function showCreateUser()
    {
        return view('admin.create-user');
    }

    // SIMPAN USER (mendukung password manual atau auto-generate)
    public function storeUser(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:191',
            // password optional: jika disediakan harus min 4, jika tidak maka auto-generate
            'password' => 'nullable|string|min:4',
            'tanggal_lahir' => 'nullable|date',
            'status' => 'nullable|in:aktif,lulus',
        ]);

        // jika admin tidak mengisi password, auto-generate yang mudah diingat (8 chars)
        $plainPassword = $request->password;
        if (empty($plainPassword)) {
            $plainPassword = Str::random(8);
        }

        $user = User::create([
            'nama' => $request->nama,
            'password' => Hash::make($plainPassword),
            'tanggal_lahir' => $request->tanggal_lahir,
            // simpan status bila kolom tersedia di DB (jika tidak, field akan diabaikan)
            'ip_address' => null,
            'foto' => null,
        ]);

        // beri informasi password plain ke admin lewat session flash (hanya sekali tampil)
        return redirect()->route('admin.dashboard')
            ->with('success', 'Siswa baru berhasil ditambahkan.')
            ->with('new_user_id', $user->id)
            ->with('new_user_password', $plainPassword);
    }

    // REKAP ABSENSI HARIAN (view)
    public function rekap(Request $request)
    {
        $tanggal = $request->tanggal ?? now('Asia/Jakarta')->toDateString();

        $rekap = Absensi::with('user')
            ->whereDate('waktu_absen', $tanggal)
            ->orderBy('waktu_absen', 'asc')
            ->get();

        return view('admin.rekap', compact('rekap', 'tanggal'));
    }

    // EXPORT REKAP (CSV sederhana, bisa dibuka di Excel)
    public function rekapExport(Request $request)
    {
        $tanggal = $request->tanggal ?? now('Asia/Jakarta')->toDateString();

        $data = Absensi::with('user')
            ->whereDate('waktu_absen', $tanggal)
            ->orderBy('waktu_absen', 'asc')
            ->get();

        $filename = "rekap-absensi-{$tanggal}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data) {
            $handle = fopen('php://output', 'w');

            // header
            fputcsv($handle, ['Nama', 'Tanggal', 'Waktu', 'Status', 'Metode', 'IP Address']);

            foreach ($data as $row) {
                $tanggal = $row->waktu_absen
                    ? Carbon::parse($row->waktu_absen, 'Asia/Jakarta')->format('Y-m-d')
                    : ($row->tanggal ?? '');

                $waktu = $row->waktu_absen
                    ? Carbon::parse($row->waktu_absen, 'Asia/Jakarta')->format('H:i:s')
                    : '';

                fputcsv($handle, [
                    $row->user->nama ?? '-',
                    $tanggal,
                    $waktu,
                    $row->status ?? '',
                    $row->metode ?? '',
                    $row->ip_address ?? '',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ⚙ PENGATURAN SISTEM (VIEW)
    public function settings()
    {
        // Ambil nilai dari helper "setting()" (sudah kamu buat)
        $jamAwal      = setting('jam_awal', '06:30');
        $jamTepat     = setting('jam_tepat', '07:30');
        $jamTerlambat = setting('jam_terlambat', '08:00');
        $modeAbsen    = setting('mode_absen', 'normal');

        return view('admin.settings', compact(
            'jamAwal',
            'jamTepat',
            'jamTerlambat',
            'modeAbsen'
        ));
    }

    // ⚙ PENGATURAN SISTEM (SIMPAN)
    public function updateSettings(Request $request)
    {
        $request->validate([
            'jam_awal'      => 'required|date_format:H:i',
            'jam_tepat'     => 'required|date_format:H:i',
            'jam_terlambat' => 'required|date_format:H:i',
            'mode_absen'    => 'required|in:strict,normal,relaxed',
        ]);

        $pairs = [
            'jam_awal'      => $request->jam_awal,
            'jam_tepat'     => $request->jam_tepat,
            'jam_terlambat' => $request->jam_terlambat,
            'mode_absen'    => $request->mode_absen,
        ];

        foreach ($pairs as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Pengaturan absensi berhasil disimpan.');
    }

    // GRAPH JSON: earliest/latest (minutes from midnight) per day (default last 7 days)
    public function graphJson(Request $request)
    {
        $days = intval($request->get('days', 7));
        $days = max(1, min(30, $days)); // batasi 1..30
        $labels = [];
        $earliest = [];
        $latest = [];
        $earliestNames = [];
        $latestNames = [];

        $today = Carbon::today('Asia/Jakarta');

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $labels[] = $date->format('d M');

            $absForDay = Absensi::with('user')
                ->whereDate('waktu_absen', $date->toDateString())
                ->orderBy('waktu_absen', 'asc')
                ->get();

            if ($absForDay->isEmpty()) {
                $earliest[] = null;
                $latest[] = null;
                $earliestNames[] = null;
                $latestNames[] = null;
            } else {
                $first = $absForDay->first();
                $last = $absForDay->last();

                $tE = Carbon::parse($first->waktu_absen, 'Asia/Jakarta');
                $tL = Carbon::parse($last->waktu_absen, 'Asia/Jakarta');

                $earliest[] = $tE->hour * 60 + $tE->minute;
                $latest[] = $tL->hour * 60 + $tL->minute;

                $earliestNames[] = $first->user->nama ?? '-';
                $latestNames[] = $last->user->nama ?? '-';
            }
        }

        return response()->json([
            'labels' => $labels,
            'earliest' => $earliest,
            'latest' => $latest,
            'earliestNames' => $earliestNames,
            'latestNames' => $latestNames,
        ]);
    }
}
