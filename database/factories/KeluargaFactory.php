<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use Faker\Generator as Faker;

class KeluargaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_keluarga' => $this->faker->name,
            'hubungan' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6', '7']),
            'karyawan_id' => null, // diisi nanti dari seeder
        ];
    }
}
