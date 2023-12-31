<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Country::count() == 0) {
            $values = array();

            $countries = Http::get('https://restcountries.com/v3.1/all');
    
            foreach ($countries->json() as $country) {
                array_push($values, [
                    'name' => $country['name']['common']
                ]);
            }
    
            Country::insert($values);
        }
    }
}
