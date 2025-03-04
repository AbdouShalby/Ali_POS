<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Debt;

class DebtsTableSeeder extends Seeder
{
    public function run()
    {
        Debt::factory()->count(50)->create();
    }
}
