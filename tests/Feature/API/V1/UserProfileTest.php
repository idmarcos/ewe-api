<?php

namespace Tests\Feature\API\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\UserProfile;

class UserProfileTest extends TestCase
{
    protected $route = 'api/v1/user/profiles';

    public function testShowProfileWithoutToken()
    {
        $response = $this->getJson($this->route);
        
        $response->assertStatus(401)
                ->assertExactJson([
                    'message' => 'Unauthenticated.'
                ]);
    }

    public function testShowEmptyProfile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson($this->route);

        $response->assertStatus(404)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Perfil de usuario no encontrado.',
                    'data' => []
                ]);
    }

    public function testShowProfile()
    {
        $user = User::factory()->create();
        $profile = UserProfile::factory()->create();
        $profile->gender;

        $response = $this->actingAs($user)->getJson($this->route);

        $response->assertStatus(200)
                ->assertExactJson([
                    'success' => true,
                    'message' => 'Perfil de usuario.',
                    'data' => [$profile->toArray()]
                ]);
    }

    public function testUpdateProfileWithoutToken()
    {
        $response = $this->putJson($this->route);
        
        $response->assertStatus(401)
                ->assertExactJson([
                    'message' => 'Unauthenticated.'
                ]);
    }

    public function testUpdateProfileWithoutData()
    {
        $user = User::factory()->create();
        $data = [];

        $response = $this->actingAs($user)->putJson($this->route, $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Invalid data',
                    'data' => [
                        'gender_id' => ['The gender id field is required.'],
                        'name' => ['The name field is required.']
                    ]
                ]);
    }

    public function testUpdateProfileWithoutGenderData()
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'Test'
        ];

        $response = $this->actingAs($user)->putJson($this->route, $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Invalid data',
                    'data' => [
                        'gender_id' => ['The gender id field is required.']
                    ]
                ]);
    }

    public function testUpdateProfileWithoutNameData()
    {
        $user = User::factory()->create();
        $data = [
            'gender_id' => 1
        ];

        $response = $this->actingAs($user)->putJson($this->route, $data);

        $response->assertStatus(422)
                ->assertExactJson([
                    'success' => false,
                    'message' => 'Invalid data',
                    'data' => [
                        'name' => ['The name field is required.']
                    ]
                ]);
    }

    public function testUpdateProfileWhenUserHasProfile()
    {
        $user = User::factory()->create();
        $profile = UserProfile::factory()->create();
        $data = [
            'gender_id' => 2,
            'name' => 'Test1',
            'surname' => 'Test1',
            'bio' => 'Prueba de perfil 1',
            'birthdate' => '1998-02-08',
            'telephone' => 666666661,
        ];

        $response = $this->actingAs($user)->putJson($this->route, $data);

        $updated_profile = UserProfile::find(1);
        $updated_profile->gender;

        $response->assertStatus(200)
                ->assertExactJson([
                    'success' => true,
                    'message' => 'Perfil de usuario actualizado.',
                    'data' => [$updated_profile->toArray()]
                ]);
    }

    public function testUpdateProfileWhenUserNoHasProfile()
    {
        $user = User::factory()->create();
        $data = [
            'gender_id' => 1,
            'name' => 'Test',
            'surname' => 'Test',
            'bio' => 'Prueba de perfil',
            'birthdate' => '1999-02-08',
            'telephone' => 666666666,
        ];

        $response = $this->actingAs($user)->putJson($this->route, $data);

        $profile = UserProfile::find(1);
        $profile->gender;

        $response->assertStatus(200)
                ->assertExactJson([
                    'success' => true,
                    'message' => 'Perfil de usuario actualizado.',
                    'data' => [$profile->toArray()]
                ]);
    }
}
