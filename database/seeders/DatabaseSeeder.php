<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Package;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Zura',
            'email' => 'zura@example.com',
            'password' => bcrypt('pass23')
        ]);

        Feature::create([
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7926EdxTjPz4ZLjI-SY3QShswywXRYbZfBw&s',
            'route_name' => 'feature1.index',
            'name' => 'Calculate Sum',
            'description' => 'Calculate sum of two numbers',
            'required_credits' => 1,
            'active' => true
        ]);

        Feature::create([
            'image' => 'https://cdn-icons-png.flaticon.com/512/2569/2569198.png',
            'route_name' => 'feature2.index',
            'name' => 'Calculate Difference',
            'description' => 'Calculate difference of two numbers',
            'required_credits' => 3,
            'active' => true
        ]);

        Package::create([
            'name' => 'Basic',
            'price' => 5,
            'credits' => 20
        ]);
        Package::create([
            'name' => 'Silver',
            'price' => 20,
            'credits' => 100
        ]);
        Package::create([
            'name' => 'Gold',
            'price' => 50,
            'credits' => 500
        ]);
    }
}
