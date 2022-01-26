<?php

namespace Tests\Feature\API\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class RegisterTest extends TestCase
{
    protected $route = 'api/v1/sign-up';

    public function testRegisterUserWithoutData()
    {
        $data = [];

        $response = $this->postJson($this->route, $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Error de validación.',
                    'data' => [
                        'name' => ['The name field is required.'],
                        'email' => ['The email field is required.'],
                        'password' => ['The password field is required.']
                    ]
                ]);
    }

    public function testRegisterUserWithoutNameData()
    {
        $pass = bcrypt('password');
        $data = [
            'email' => 'Test@ewe.com',
            'password' => $pass,
            'password_confirmation' => $pass
        ];

        $response = $this->postJson($this->route, $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Error de validación.',
                    'data' => [
                        'name' => ['The name field is required.']
                    ]
                ]);
    }
    
    public function testRegisterUserWithoutEmailData()
    {
        $pass = bcrypt('password');
        $data = [
            'name' => 'Test User',
            'password' => $pass,
            'password_confirmation' => $pass
        ];
        
        $response = $this->postJson($this->route, $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Error de validación.',
                    'data' => [
                        'email' => ['The email field is required.']
                    ]
                ]);
    }
    
    public function testRegisterUserWithoutPasswordData()
    {
        $pass = bcrypt('password');
        $data = [
            'name' => 'Test User',
            'email' => 'Test@ewe.com'
        ];
        
        $response = $this->postJson($this->route, $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Error de validación.',
                    'data' => [
                        'password' => ['The password field is required.']
                    ]
                ]);
    }
    
    public function testRegisterUserWithoutPasswordConfirmData()
    {
        $pass = bcrypt('password');
        $data = [
            'name' => 'Test User',
            'email' => 'Test@ewe.com',
            'password' => $pass
        ];
        
        $response = $this->postJson($this->route, $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Error de validación.',
                    'data' => [
                        'password' => ['The password confirmation does not match.']
                    ]
                ]);
    }
    
    public function testRegisterUserWithDifferentPasswords()
    {
        $pass1 = bcrypt('password1');
        $pass2 = bcrypt('password2');
        $data = [
            'name' => 'Test User',
            'email' => 'Test@ewe.com',
            'password' => $pass1,
            'password_confirmation' => $pass2
        ];

        $response = $this->postJson($this->route, $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Error de validación.',
                    'data' => [
                        'password' => ['The password confirmation does not match.']
                    ]
                ]);
    }

    public function testRegisterUserSuccessfully()
    {
        $pass = bcrypt('password');
        $data = [
            'name' => 'Test User',
            'email' => 'Test@ewe.com',
            'password' => $pass,
            'password_confirmation' => $pass
        ];
        
        $response = $this->postJson($this->route, $data);

        $response->assertStatus(200)
                ->assertExactJson([
                    'success' => true,
                    'message' => 'Usuario creado correctamente.',
                    'data' => [
                        'token' => $response->original['data']['token'],
                        'name' => 'Test User'
                    ]
                ]);
    }
    
    public function testRegisterWithExistsUserEmail()
    {
        $pass = bcrypt('password');

        User::create([
            'name' => 'Test User',
            'email' => 'Test@ewe.com',
            'password' => $pass
        ]);

        $data = [
            'name' => 'Test User',
            'email' => 'Test@ewe.com',
            'password' => $pass,
            'password_confirmation' => $pass
        ];
        
        $response = $this->postJson($this->route, $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Error de validación.',
                    'data' => [
                        'email' => ['The email has already been taken.']
                    ]
                ]);
    }
}
