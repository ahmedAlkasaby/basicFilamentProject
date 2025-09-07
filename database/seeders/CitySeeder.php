<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            City::create([
                'name' => [
                    'en' => "City $i",
                    'ar' => "مدينة $i",
                ],
                'order_id' => $i,
                'active' => true,
            ]);
            for ($j = 1; $j <= 5; $j++) {
                City::find($i)->regions()->create([
                    'name' => [
                        'en' => "Region $j of City $i",
                        'ar' => "منطقة $j من مدينة $i",
                    ],
                    'order_id' => $j,
                    'active' => true,
                ]);
            }
        }
    }
}
