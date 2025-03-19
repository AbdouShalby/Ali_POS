<?php

namespace Database\Factories;

use App\Models\Maintenance;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceFactory extends Factory
{
    protected $model = Maintenance::class;

    public function definition()
    {
        return [
            'customer_name' => $this->faker->name,
            'phone_number' => $this->faker->phoneNumber,
            'device_type' => $this->faker->word,
            'problem_description' => $this->faker->sentence,
            'cost' => $this->faker->randomFloat(2, 50, 500),
            'password' => $this->faker->password,
            'status' => $this->faker->randomElement(['in_maintenance', 'completed', 'delivered']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
