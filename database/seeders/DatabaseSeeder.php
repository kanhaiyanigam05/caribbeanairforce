<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
        ]);
        
        $cities = [
            ['name' => 'Atlanta', 'slug' => 'atlanta', 'heading' => 'Caribbean Events and Parties in Atlanta Georgia'],
            ['name' => 'New York', 'slug' => 'new-york',  'heading' => 'Caribbean Events and Parties In New York'],
            ['name' => 'Florida', 'slug' => 'florida',  'heading' => 'Caribbean Events and Parties in Florida'],
            ['name' => 'Guyana', 'slug' => 'guyana',  'heading' => 'Caribbean Events Parties in Guyana Caribbean and events in Barbados'],
            ['name' => 'Barbados', 'slug' => 'barbados',  'heading' => 'Caribbean Events Parties in Guyana Caribbean and events in Barbados'],
            ['name' => 'Trinidad & Tobago', 'slug' => 'trinidad-tobago',  'heading' => 'Caribbean Events and Parties in Trinidad & Tobago'],
            ['name' => 'Jamaica', 'slug' => 'jamaica',  'heading' => 'Caribbean Events and Parties in Jamaica'],
            ['name' => 'Montego bay', 'slug' => 'montego-bay',  'heading' => 'Caribbean Events in and Parties in Monte-go bay Jamaica'],
        ];
        foreach ($cities as $city) {
            City::create([
                'name' => $city['name'],
                'heading' => $city['heading'],
            ]);
        }
    }
}
