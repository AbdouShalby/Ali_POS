<?php

namespace Database\Seeders;

use App\Models\CryptoGateway;
use Illuminate\Database\Seeder;

class CryptoGatewaySeeder extends Seeder
{
    public function run()
    {
        $gateways = [
            [
                'name' => 'USDT',
                'balance' => 0
            ],
            [
                'name' => 'BTC',
                'balance' => 0
            ],
            [
                'name' => 'ETH',
                'balance' => 0
            ]
        ];

        foreach ($gateways as $gateway) {
            CryptoGateway::create($gateway);
        }
    }
} 