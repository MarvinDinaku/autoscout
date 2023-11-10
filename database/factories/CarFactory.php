<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;


class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition()
    {
        return [
            'brand' => $this->faker->company,
            'model' => $this->faker->word,
            'registration_date' => $this->faker->date,
            'engine_size' => $this->faker->randomFloat(2, 1.0, 5.0),
            'price' => $this->faker->randomFloat(2, 5000, 50000),
        ];
    }
}
