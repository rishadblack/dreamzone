<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $RoleList = [
            [
                'id' => '1',
                'name' => 'superadmin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '2',
                'name' => 'manager',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '3',
                'name' => 'user',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '4',
                'name' => 'guest',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        Role::insertOrIgnore($RoleList);
    }
}
