<?php

namespace Database\Factories;

use App\Models\CryptoTransaction;
use App\Models\CryptoGateway;
use Illuminate\Database\Eloquent\Factories\Factory;

class CryptoTransactionFactory extends Factory
{
    protected $model = CryptoTransaction::class;

    public function definition()
    {
        return [
            'crypto_gateway_id' => CryptoGateway::factory(),
            'amount' => $this->faker->randomFloat(8, -1000, 1000),
            'profit_percentage' => $this->faker->optional()->randomFloat(2, 0, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
