<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
       public function run(): void
    {
        $data = [
            [
                'karyawan_id'   => 1,
                'nama_keluarga' => 'Budi Santoso',
                'hubungan'      => '1', // Ayah
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'karyawan_id'   => 1,
                'nama_keluarga' => 'Siti Aminah',
                'hubungan'      => '2', // Ibu
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'karyawan_id'   => 2,
                'nama_keluarga' => 'Dewi Lestari',
                'hubungan'      => '4', // Istri
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'karyawan_id'   => 2,
                'nama_keluarga' => 'Rafi Maulana',
                'hubungan'      => '5', // Anak
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'karyawan_id'   => 3,
                'nama_keluarga' => 'Nuraini',
                'hubungan'      => '6', // Saudara
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'karyawan_id'   => 3,
                'nama_keluarga' => 'Fikri',
                'hubungan'      => '7', // Lainnya
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ];

        DB::table('keluargas')->insert($data);
    }
}
