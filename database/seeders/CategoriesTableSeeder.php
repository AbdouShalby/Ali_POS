<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Phones'],
            ['name' => 'Tablets'],
            ['name' => 'Accessories'],
            ['name' => 'Home Appliances'],
            ['name' => 'Computers'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }
    }
}
