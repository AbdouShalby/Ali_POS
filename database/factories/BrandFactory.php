<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = \App\Models\Brand::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
        ];
    }
}
