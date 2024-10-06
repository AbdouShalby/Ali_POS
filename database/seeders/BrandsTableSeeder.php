<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            ['name' => 'سامسونج'],
            ['name' => 'آبل'],
            ['name' => 'هواوي'],
            ['name' => 'شاومي'],
            ['name' => 'إل جي'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
