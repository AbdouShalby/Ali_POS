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
                'name' => 'Ahmed Mohamed',
                'phone' => '01000000003',
                'email' => 'customer1@example.com',
                'address' => 'Giza, Egypt',
            ],
            [
                'name' => 'Sara Ali',
                'phone' => '01000000004',
                'email' => 'customer2@example.com',
                'address' => 'Mansoura, Egypt',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::firstOrCreate($customer);
        }
    }
}
