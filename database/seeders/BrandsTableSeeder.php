<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            ['name' => 'Samsung'],
            ['name' => 'Apple'],
            ['name' => 'Huawei'],
            ['name' => 'Xiaomi'],
            ['name' => 'LG'],
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate($brand);
        }
    }
}
