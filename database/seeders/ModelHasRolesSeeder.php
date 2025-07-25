<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModelHasRolesSeeder extends Seeder
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
                'role_id'    => 1,
                'model_type' => 'App\\Models\\User',
                'model_id'   => 1
            ],
            [
                'role_id'    => 2,
                'model_type' => 'App\\Models\\User',
                'model_id'   => 2
            ],
            [
                'role_id'    => 3,
                'model_type' => 'App\\Models\\User',
                'model_id'   => 3
            ],
        ];

        DB::table('model_has_roles')->insert($data);
    }
}
