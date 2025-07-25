<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fotos = ['photo1.jpg', 'photo2.jpg', 'photo3.jpeg'];
        $data = [
            [
                'nama_lengkap'   => 'Andi Saputra',
                'no_karyawan'    => 'KRY001',
                'tempat_lahir'   => 'Jakarta',
                'tanggal_lahir'  => '1990-01-15',
                'jenis_kelamin'  => '1',
                'foto'           => 'photo1.jpg',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nama_lengkap'   => 'Budi Hartono',
                'no_karyawan'    => 'KRY002',
                'tempat_lahir'   => 'Bandung',
                'tanggal_lahir'  => '1985-06-20',
                'jenis_kelamin'  => '1',
                'foto'           => 'photo2.jpg',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nama_lengkap'   => 'Citra Dewi',
                'no_karyawan'    => 'KRY003',
                'tempat_lahir'   => 'Surabaya',
                'tanggal_lahir'  => '1992-09-10',
                'jenis_kelamin'  => '2',
                'foto'           => 'photo3.jpeg',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ];

        DB::table('karyawans')->insert($data);
    }
}
