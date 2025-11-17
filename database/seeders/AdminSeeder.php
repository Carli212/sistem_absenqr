<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'nama' => 'admin',
            'nomor_wa' => '081234567890',
            'password' => Hash::make('12345'),
        ]);
    }
}
