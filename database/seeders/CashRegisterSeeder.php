<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CashRegisterSeeder extends Seeder
{
    public function run()
    {
        DB::table('cash_registers')->insert([
            [
                'transaction_type' => 'Product Sale',
                'amount' => 200.00,
                'balance' => 200.00,
                'description' => 'Sold a phone',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'transaction_type' => 'Crypto Purchase',
                'amount' => -100.00,
                'balance' => 100.00,
                'description' => 'Bought USDT',
                'created_at' => Carbon::now()->subHour(),
                'updated_at' => Carbon::now()->subHour(),
            ],
            [
                'transaction_type' => 'Maintenance Service',
                'amount' => 50.00,
                'balance' => 150.00,
                'description' => 'Phone repair service',
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(2),
            ],
        ]);
    }
}
