<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(1)->create();

        $tags = [
            'red',
            'automatic',
            'manual',
            'sedan',
            'hatchback',
            'suv',
            'electric',
            'hybrid',
            'diesel',
            'petrol',
            '4wd',
            'leather-interior',
            'sunroof',
            'gps',
            'sport-package',
        ];

        foreach ($tags as $name ) {
            Tag::create([
                'name' => $name,
            ]);
        }
    }
}
