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
                'name' => 'General Uddokta',
                'details' => '',
                'flash_condition' => 0,
                'point_value' => 10,
                'amount' => 0,
                'to_amount' => null,
                'type' => 2,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'Pro-Uddokta',
                'details' => '',
                'flash_condition' => 0,
                'point_value' => 100,
                'amount' => 100,
                'to_amount' => null,
                'type' => 2,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        Package::insertOrIgnore($PackageList);
    }
}
