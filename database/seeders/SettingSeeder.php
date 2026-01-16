<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $SettingList = [
            [
                'id' => 1,
                'parameter' => 'access_user_login',
                'value' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'id' => 2,
                'parameter' => 'access_user_register',
                'value' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'parameter' => 'access_withdrawal',
                'value' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'parameter' => 'access_transfer',
                'value' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Setting::insertOrIgnore($SettingList);
    }
}
