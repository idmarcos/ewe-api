<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'gender_id' => 1,
            'name' => 'Test',
            'surname' => 'Test',
            'bio' => 'Prueba de perfil',
            'birthdate' => '1999-02-08',
            'telephone' => 666666666,
        ];
    }
}
