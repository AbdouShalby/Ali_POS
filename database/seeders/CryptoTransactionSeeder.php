<?php

namespace Database\Seeders;

use App\Models\CryptoGateway;
use App\Models\CryptoTransaction;
use Illuminate\Database\Seeder;

class CryptoTransactionSeeder extends Seeder
{
    public function run()
    {
        $gateways = CryptoGateway::all();

        foreach ($gateways as $gateway) {
            // إنشاء معاملات شراء
            for ($i = 0; $i < 5; $i++) {
                $amount = rand(100, 1000);
                $profitPercentage = rand(-5, 5);
                
                $transaction = new CryptoTransaction([
                    'crypto_gateway_id' => $gateway->id,
                    'amount' => $amount,
                    'profit_percentage' => $profitPercentage,
                    'type' => 'buy'
                ]);
                
                $transaction->calculateFinalAmount();
                $transaction->save();
                $transaction->updateBalances();
            }

            // إنشاء معاملات بيع
            for ($i = 0; $i < 5; $i++) {
                $amount = rand(100, 1000);
                $profitPercentage = rand(-5, 5);
                
                $transaction = new CryptoTransaction([
                    'crypto_gateway_id' => $gateway->id,
                    'amount' => -$amount, // سالب للبيع
                    'profit_percentage' => $profitPercentage,
                    'type' => 'sell'
                ]);
                
                $transaction->calculateFinalAmount();
                $transaction->save();
                $transaction->updateBalances();
            }
        }
    }
}
