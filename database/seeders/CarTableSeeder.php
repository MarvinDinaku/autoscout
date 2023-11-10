<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarTableSeeder extends Seeder
{
    public function run()
    {
        // Use the CarModel alias to create 20 fake car records
        Car::factory(20)->create();
    }
}
