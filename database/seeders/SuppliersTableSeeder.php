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
                'name' => 'شركة التقنية المتقدمة',
                'phone' => '01000000001',
                'email' => 'supplier1@example.com',
                'address' => 'القاهرة، مصر',
            ],
            [
                'name' => 'مؤسسة الأجهزة الحديثة',
                'phone' => '01000000002',
                'email' => 'supplier2@example.com',
                'address' => 'الإسكندرية، مصر',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
