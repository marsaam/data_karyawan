<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  public function run(): void
    {
        $users = [
            [
                'name' => 'Nuraini',
                'email' => 'superadmin@example.com',
                'role_id' => 1,
            ],
            [
                'name' => 'Bulan Tsabita',
                'email' => 'admin@example.com',
                'role_id' => 2,
            ],
            [
                'name' => 'Gita Wulan',
                'email' => 'user@example.com',
                'role_id' => 3,
            ],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => bcrypt('12345678'),
                    'role' => $data['role_id'],
                ]
            );

            $role = Role::find($data['role_id']);
            if ($role) {
                $user->assignRole($role->name);
            }
        }
    }
}
