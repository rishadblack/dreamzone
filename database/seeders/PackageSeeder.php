<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $PackageList = [
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Start Up',
                'details' => '',
                'flash_condition' => 0,
                'point_value' => 1,
                'amount' => 25,
                'to_amount' => null,
                'type' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'Basic',
                'details' => '',
                'flash_condition' => 0,
                'point_value' => 1.25,
                'amount' => 100,
                'to_amount' => null,
                'type' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'Elite',
                'details' => '',
                'flash_condition' => 0,
                'point_value' => 1.5,
                'amount' => 500,
                'to_amount' => null,
                'type' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        Package::insertOrIgnore($PackageList);
    }
}
