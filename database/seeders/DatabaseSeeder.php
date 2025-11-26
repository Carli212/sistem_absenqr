<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeder admin (punya kamu)
        $this->call([
            AdminSeeder::class,

            // Seeder siswa dummy
            UserSeeder::class,
        ]);
    }
}
