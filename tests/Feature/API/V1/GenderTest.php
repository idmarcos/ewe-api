<?php

namespace Tests\Feature\API\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Gender;
use App\Models\User;

class GenderTest extends TestCase
{
    protected $route = 'api/v1/genders';

    public function testShowGenders()
    {
        $user = User::factory()->create();
        $genders = Gender::all();
        
        $response = $this->actingAs($user)->getJson($this->route);

        $response->assertStatus(200)
                ->assertExactJson([
                    'success' => true,
                    'message' => 'Lista de géneros.',
                    'data' => $genders
                ]);
    }
}
