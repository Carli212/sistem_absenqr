<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;

class AutoAlphaAbsensi extends Command
{
    protected $signature = 'absensi:auto-alpha';
    protected $description = 'Menandai siswa ALPHA otomatis jika tidak absen';

    public function handle()
    {
        $today = Carbon::now('Asia/Jakarta')->toDateString();

        // Ambil semua user siswa
        $users = User::all();

        foreach ($users as $user) {

            $already = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', $today)
                ->exists();

            if (!$already) {
                Absensi::create([
                    'user_id'     => $user->id,
                    'tanggal'     => $today,
                    'waktu_absen' => null,
                    'status'      => 'alpha',
                    'metode'      => 'auto',
                    'ip_address'  => null,
                ]);
            }
        }

        $this->info('AUTO ALPHA berhasil dijalankan');
    }
}
