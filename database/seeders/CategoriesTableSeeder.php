<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'هواتف'],
            ['name' => 'أجهزة لوحية'],
            ['name' => 'إكسسوارات'],
            ['name' => 'أجهزة منزلية'],
            ['name' => 'أجهزة كمبيوتر'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
