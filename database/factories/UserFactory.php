<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $namaIndonesia = [
            'Budi Santoso', 'Adit Pratama', 'Rizky Ramadhan', 'Fajar Nugraha', 'Rian Saputra',
            'Bayu Mahendra', 'Iqbal Firmansyah', 'Agus Kurniawan', 'Dedi Permana', 'Faris Hidayat',
            'Tina Amelia', 'Sari Utami', 'Maya Rahmawati', 'Dewi Lestari', 'Nina Anggraini',
            'Putri Aisyah', 'Aulia Rahmah', 'Salsa Maharani', 'Dina Pratiwi', 'Bella Arsyad',
            'Joko Prasetyo', 'Wahyu Cahyono', 'Hendra Wijaya', 'Danu Widodo', 'Rudi Hartono'
        ];

        return [
            'nama'          => $this->faker->randomElement($namaIndonesia),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '2010-01-01'),
            'ip_address'    => null,
            'foto'          => null
        ];
    }
}
