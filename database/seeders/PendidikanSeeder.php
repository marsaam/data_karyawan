<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PendidikanSeeder extends Seeder
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
                'jenjang'       => '3', // D4/S1
                'institusi'     => 'Universitas Indonesia',
                'tanggal_lulus' => '2012-07-01',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'karyawan_id'   => 1,
                'jenjang'       => '4', // S2
                'institusi'     => 'Institut Teknologi Bandung',
                'tanggal_lulus' => '2015-07-01',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'karyawan_id'   => 2,
                'jenjang'       => '2', // D3
                'institusi'     => 'Politeknik Negeri Jakarta',
                'tanggal_lulus' => '2010-06-20',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'karyawan_id'   => 2,
                'jenjang'       => '3', // D4/S1
                'institusi'     => 'Universitas Padjadjaran',
                'tanggal_lulus' => '2013-06-30',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'karyawan_id'   => 3,
                'jenjang'       => '1', // SMA/K
                'institusi'     => 'SMA Negeri 1 Surabaya',
                'tanggal_lulus' => '2009-05-15',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'karyawan_id'   => 3,
                'jenjang'       => '3', // D4/S1
                'institusi'     => 'Universitas Airlangga',
                'tanggal_lulus' => '2014-07-10',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ];

        DB::table('pendidikans')->insert($data);
    }
}
