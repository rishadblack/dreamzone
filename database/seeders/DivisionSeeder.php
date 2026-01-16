<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $DivisionList = [
            ['id' => 1, 'country_id' => 19, 'name' => 'Barisal', 'bn_name' => 'বরিশাল', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'country_id' => 19, 'name' => 'Chittagong', 'bn_name' => 'চট্টগ্রাম', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'country_id' => 19, 'name' => 'Dhaka', 'bn_name' => 'ঢাকা', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'country_id' => 19, 'name' => 'Khulna', 'bn_name' => 'খুলনা', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'country_id' => 19, 'name' => 'Rajshahi', 'bn_name' => 'রাজশাহী', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'country_id' => 19, 'name' => 'Rangpur', 'bn_name' => 'রংপুর', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'country_id' => 19, 'name' => 'Sylhet', 'bn_name' => 'সিলেট', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'country_id' => 19, 'name' => 'Mymensingh', 'bn_name' => 'ময়মনসিংহ', 'created_at' => now(), 'updated_at' => now()],
        ];

        Division::insertOrIgnore($DivisionList);
    }
}
