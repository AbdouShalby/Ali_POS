<?php

namespace Database\Factories;

use App\Models\CryptoGateway;
use Illuminate\Database\Eloquent\Factories\Factory;

class CryptoGatewayFactory extends Factory
{
    protected $model = CryptoGateway::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'balance' => $this->faker->randomFloat(8, 0, 10000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
