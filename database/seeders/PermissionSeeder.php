<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
      public function run()
    {
        $permissions = [
            'create karyawan',
            'edit karyawan',
            'delete karyawan',
            'view karyawan',
            'create user',
            'edit user',
            'delete user',
            'view user',
            'create role',
            'edit role',
            'delete role',
            'view role',
            'ekspor PDF karyawan',
            'ekspor PDF user',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
