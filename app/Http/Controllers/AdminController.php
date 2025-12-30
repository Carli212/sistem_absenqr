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

        return view('admin.dashboard', [
            'totalSiswa' => User::count(),
            'hadir' => Absensi::whereDate('waktu_absen', $today)
                ->whereIn('status', ['hadir','terlambat'])->count(),
            'absensiHariIni' => Absensi::with('user')
                ->whereDate('waktu_absen', $today)
                ->orderBy('waktu_absen')->get(),
        ]);
    }

    /* ================= GRAFIK ================= */
    public function graphFilter()
    {
        $today = Carbon::today('Asia/Jakarta');
        $start = $today->copy()->startOfWeek();

        $labels = $bestTimes = $latestTimes = $bestNames = $latestNames = [];

        foreach (Carbon::period($start, $today) as $date) {
            if ($date->isWeekend()) continue;

            $labels[] = $date->translatedFormat('d M');

            $records = Absensi::with('user')
                ->whereDate('waktu_absen', $date)->orderBy('waktu_absen')->get();

            if ($records->isEmpty()) {
                $bestTimes[] = $latestTimes[] = null;
                $bestNames[] = $latestNames[] = '-';
            } else {
                $bestNames[] = $records->first()->user->nama ?? '-';
                $latestNames[] = $records->last()->user->nama ?? '-';
                $bestTimes[] = Carbon::parse($records->first()->waktu_absen)->hour * 60;
                $latestTimes[] = Carbon::parse($records->last()->waktu_absen)->hour * 60;
            }
        }

        return response()->json(compact(
            'labels','bestTimes','latestTimes','bestNames','latestNames'
        ));
    }
public function rankingKehadiran()
{
    return response()->json(
        Absensi::select('user_id', DB::raw('COUNT(*) as total'))
            ->whereIn('status', ['hadir','terlambat'])
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($r) => [
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
        $code = rand(100000,999999);

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
                ->orderBy('waktu_absen','desc')->get()
        ]);
    }

public function storeAbsensiManual(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'tanggal' => 'required|date',
        'status'  => 'required|in:hadir,terlambat,izin,sakit,alpha'
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
        'user_id'     => $request->user_id,
        'tanggal'     => $request->tanggal,
        'waktu_absen' => $request->tanggal.' '.now()->format('H:i:s'),
        'status'      => $request->status,
        'metode'      => 'manual'
    ]);

    return back()->with('success', 'Absensi manual berhasil ditambahkan.');
}

    public function deleteAbsensiManual($id)
    {
        Absensi::findOrFail($id)->delete();
        return back()->with('success','Absensi berhasil dihapus');
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
            'data'=>Absensi::with('user')
                ->whereDate('waktu_absen',$date)->get()
        ]);
    }

    public function calendarData($year,$month)
    {
        return response()->json([
            'firstDay'=>Carbon::create($year,$month,1)->dayOfWeek,
            'daysInMonth'=>Carbon::create($year,$month)->daysInMonth,
            'events'=>Absensi::whereYear('waktu_absen',$year)
                ->whereMonth('waktu_absen',$month)->get(),
            'today'=>now()->toDateString()
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
            'nama'=>'required',
            'password'=>'nullable|min:4'
        ]);

        $pwd = $request->password ?: Str::random(8);

        User::create([
            'nama'=>$request->nama,
            'password'=>Hash::make($pwd)
        ]);

        return back()->with('success','Siswa ditambahkan')
            ->with('new_user_password',$request->password?null:$pwd);
    }
/* ================= MANAJEMEN PESERTA ================= */
public function manageUser()
{
    return view('admin.users', [
        'users' => User::orderBy('nama')->get()
    ]);
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

    /* ================= SETTINGS ================= */
    public function settings()
    {
        return view('admin.settings', [
            'jamAwal'=>setting('jam_awal','06:30'),
            'jamTepat'=>setting('jam_tepat','07:30'),
            'jamTerlambat'=>setting('jam_terlambat','08:00'),
            'modeAbsen'=>setting('mode_absen','normal')
        ]);
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->except('_token') as $k=>$v) {
            DB::table('settings')->updateOrInsert(
                ['key'=>$k], ['value'=>$v]
            );
        }

        return back()->with('success','Pengaturan disimpan');
    }
}
