<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders=[
            'Femenino',
            'Masculino'
        ];
        $n=count($genders);

        for($i=0; $i<$n; $i++){
            \DB::table('genders')->insert([
                'gender' => $genders[$i]
            ]);
        }
    }
}
