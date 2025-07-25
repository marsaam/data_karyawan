<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use Faker\Generator as Faker;

class KaryawanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_lengkap' => $this->faker->name,
            'no_karyawan' => strtoupper('NK-' . Str::random(5)),
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-20 years'),
            'jenis_kelamin' => $this->faker->randomElement(['1', '2']),
            'foto' => null,
            // 'id_pendidikan' => null,
            // 'id_keluarga' => null,
        ];
    }
}
