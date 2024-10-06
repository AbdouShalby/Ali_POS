<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitsTableSeeder extends Seeder
{
    public function run()
    {
        $units = [
            ['name' => 'قطعة', 'short_name' => 'PCS'],
            ['name' => 'كيلوجرام', 'short_name' => 'KG'],
            ['name' => 'لتر', 'short_name' => 'L'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
