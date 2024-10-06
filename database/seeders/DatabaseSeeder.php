<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UnitsTableSeeder::class,
            BrandsTableSeeder::class,
            CategoriesTableSeeder::class,
            SuppliersTableSeeder::class,
            CustomersTableSeeder::class,
            ProductsTableSeeder::class,
            MobileDetailsTableSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
