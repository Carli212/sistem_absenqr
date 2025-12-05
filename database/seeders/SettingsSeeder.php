<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $defaults = [
            ['key' => 'jam_awal', 'value' => '06:30:00'],
            ['key' => 'jam_tepat', 'value' => '07:30:00'],
            ['key' => 'jam_terlambat', 'value' => '08:00:00'],
            ['key' => 'timezone', 'value' => 'Asia/Jakarta'],
        ];

        foreach ($defaults as $setting) {
            if (!DB::table('settings')->where('key', $setting['key'])->exists()) {
                DB::table('settings')->insert($setting);
            }
        }
    }
}
