<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomersTableSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            [
                'name' => 'أحمد محمد',
                'phone' => '01000000003',
                'email' => 'customer1@example.com',
                'address' => 'الجيزة، مصر',
            ],
            [
                'name' => 'سارة علي',
                'phone' => '01000000004',
                'email' => 'customer2@example.com',
                'address' => 'المنصورة، مصر',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
