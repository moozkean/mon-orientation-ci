<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['name' => 'Abidjan', 'region' => 'Lagunes', 'postal_code' => '01'],
            ['name' => 'Yamoussoukro', 'region' => 'Bélier', 'postal_code' => '02'],
            ['name' => 'Bouaké', 'region' => 'Gbêkê', 'postal_code' => '03'],
            ['name' => 'Daloa', 'region' => 'Haut-Sassandra', 'postal_code' => '04'],
            ['name' => 'Korhogo', 'region' => 'Poro', 'postal_code' => '05'],
            ['name' => 'San-Pédro', 'region' => 'San-Pédro', 'postal_code' => '06'],
            ['name' => 'Man', 'region' => 'Tonkpi', 'postal_code' => '07'],
            ['name' => 'Bondoukou', 'region' => 'Gontougo', 'postal_code' => '08'],
            ['name' => 'Gagnoa', 'region' => 'Gôh', 'postal_code' => '09'],
            ['name' => 'Bassam', 'region' => 'Sud-Comoé', 'postal_code' => '10'],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(['name' => $city['name']], $city);
        }
    }
}
