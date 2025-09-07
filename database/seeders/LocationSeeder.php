<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            Location::create([
                'name' => ['en' => "Location $i", 'ar' => "الموقع $i"],
                'latitude' => rand(-90, 90) + rand() / getrandmax(),
                'longitude' => rand(-180, 180) + rand() / getrandmax(),
                'redius_meter' => rand(100, 1000),
                'order_id' => $i,
                'active' => true,
                'city_id'=>City::where('active',1)->inRandomOrder()->first()->id,
                'region_id'=>City::where('active',1)->inRandomOrder()->first()->regions()->inRandomOrder()->first()->id,
            ]);
        }
    }
}
