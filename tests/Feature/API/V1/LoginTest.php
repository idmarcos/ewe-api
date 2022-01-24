<?php

namespace Tests\Feature\API\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class LoginTest extends TestCase
{
    public function testLoginWithoutData()
    {
        $data = [];

        $response = $this->postJson('api/sign-in', $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Error de validación.',
                    'data' => [
                        'email' => ['The email field is required.'],
                        'password' => ['The password field is required.']
                    ]
                ]);
    }

    public function testLoginWithoutEmailData()
    {
        $pass = bcrypt('password');
        $data = [
            'password' => $pass
        ];

        $response = $this->postJson('api/sign-in', $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Error de validación.',
                    'data' => [
                        'email' => ['The email field is required.']
                    ]
                ]);
    }

    public function testLoginWithoutPasswordData()
    {
        $data = [
            'email' => 'Test@ewe.com'
        ];

        $response = $this->postJson('api/sign-in', $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Error de validación.',
                    'data' => [
                        'password' => ['The password field is required.']
                    ]
                ]);
    }

    public function testLoginWithInvalidFormatEmail()
    {
        $pass = bcrypt('password');
        $data = [
            'email' => 'Testewe.com',
            'password' => $pass
        ];

        $response = $this->postJson('api/sign-in', $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Error de validación.',
                    'data' => [
                        'email' => ['The email must be a valid email address.']
                    ]
                ]);
    }

    public function testLoginWithNoRegisteredEmail()
    {
        $pass = bcrypt('password');
        $data = [
            'email' => 'Test@ewe.com',
            'password' => $pass
        ];

        $response = $this->postJson('api/sign-in', $data);

        $response->assertStatus(401)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Usuario y/o contraseña inválidos.',
                    'data' => [
                        'error' => 'Unauthorized'
                    ]
                ]);
    }

    public function testLoginWithIncorrectPassword()
    {
        $pass = bcrypt('password');

        User::create([
            'name' => 'Test User',
            'email' => 'Test@ewe.com',
            'password' => $pass
        ]);

        $data = [
            'email' => 'Test@ewe.com',
            'password' => bcrypt('otra_password')
        ];

        $response = $this->postJson('api/sign-in', $data);

        $response->assertStatus(401)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Usuario y/o contraseña inválidos.',
                    'data' => [
                        'error' => 'Unauthorized'
                    ]
                ]);
    }

    public function testLoginSuccessfully()
    {
        $pass = bcrypt('password');

        User::create([
            'name' => 'Test User',
            'email' => 'Test@ewe.com',
            'password' => $pass
        ]);

        $data = [
            'email' => 'Test@ewe.com',
            'password' => 'password'
        ];

        $response = $this->postJson('api/sign-in', $data);

        $response->assertStatus(200)
                ->assertExactJson([
                    'success' => true,
                    'message' => 'Usuario logueado',
                    'data' => [
                        'token' => $response->original['data']['token'],
                        'name' => 'Test User'
                    ]
                ]);
    }
}
