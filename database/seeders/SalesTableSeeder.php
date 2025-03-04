<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;

class SalesTableSeeder extends Seeder
{
    public function run()
    {
        Sale::factory()->count(50)->create();
    }
}
