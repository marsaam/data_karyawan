<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Karyawan;
use App\Models\Keluarga;
use App\Models\Pendidikan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            KaryawanSeeder::class,
            KeluargaSeeder::class,
            PendidikanSeeder::class,
            PermissionSeeder::class,
            // ModelHasRolesSeeder::class,
            RoleHasPermissionsSeeder::class,

            // Tambah seeder lain di sini kalau ada
        ]);
        // Buat 25 Karyawan
        // Karyawan::factory()
        //     ->count(25)
        //     ->create()
        //     ->each(function ($karyawan) {
        //         // Tiap karyawan punya 1–3 keluarga
        //         Keluarga::factory()->count(rand(1, 3))->create([
        //             'karyawan_id' => $karyawan->id
        //         ]);

        //         // Tiap karyawan punya 1–2 pendidikan
        //         Pendidikan::factory()->count(rand(1, 2))->create([
        //             'karyawan_id' => $karyawan->id
        //         ]);
        //     });
    }
}
