<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use Faker\Generator as Faker;

class PendidikanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'jenjang' => $this->faker->randomElement(['1', '2', '3', '4']),
            'institusi' => $this->faker->company . ' University',
            'tanggal_lulus' => $this->faker->date('Y-m-d', '-1 years'),
            'karyawan_id' => null, // diisi nanti dari seeder
        ];
    }
}
