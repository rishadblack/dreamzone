<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class EcommerceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $UnitList = [
            ['id' => 1, 'user_id' => 1, 'name' => 'PCS', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'user_id' => 1, 'name' => 'KG', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        Unit::insertOrIgnore($UnitList);

        $BrandList = [
            ['id' => 1, 'user_id' => 1, 'name' => 'Default', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'user_id' => 1, 'name' => 'Vivo', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        Brand::insertOrIgnore($BrandList);

        $CategoryList = [
            ['id' => 1, 'user_id' => 1, 'name' => 'Default', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'user_id' => 1, 'name' => 'Mobile', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        Category::insertOrIgnore($CategoryList);

        $Product = new Product();
        $Product->user_id = 1;
        $Product->type = 1;
        $Product->unit_id = 1;
        $Product->brand_id = 1;
        $Product->name = 'Test Product';
        $Product->code = '001';
        $Product->short_description = 'Test Product';
        $Product->description = 'Test Product';
        $Product->point = 500;
        $Product->sales_price = 100;
        $Product->purchase_price = 80;
        $Product->net_price = 100;
        $Product->status = 1;
        $Product->is_featured = true;
        $Product->save();

        $Product->Categories()->sync([1]);
    }
}
