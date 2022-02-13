<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [
                'country' => 'España',
                'iso' => 'ES',
                'iso3' => 'ESP',
                'code' => 724
            ],
            [
                'country' => 'Portugal',
                'iso' => 'PT',
                'iso3' => 'PRT',
                'code' => 620
            ]
        ];
        $n=count($countries);

        for($i=0; $i<$n; $i++){
            \DB::table('countries')->insert([
                'country' => $countries[$i]['country'],
                'iso' => $countries[$i]['iso'],
                'iso3' => $countries[$i]['iso3'],
                'code' => $countries[$i]['code'],
            ]);
        }
    }
}
