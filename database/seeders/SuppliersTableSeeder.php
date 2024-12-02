<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SuppliersTableSeeder extends Seeder
{
    public function run()
    {
        $suppliers = [
            [
                'name' => 'Advanced Technology Co.',
                'phone' => '01000000001',
                'email' => 'supplier1@example.com',
                'address' => 'Cairo, Egypt',
            ],
            [
                'name' => 'Modern Devices Inc.',
                'phone' => '01000000002',
                'email' => 'supplier2@example.com',
                'address' => 'Alexandria, Egypt',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate($supplier);
        }
    }
}
