<?php

namespace Tests\Feature\API\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Country;
use App\Models\User;

class CountryTest extends TestCase
{
    protected $route = 'api/v1/countries';

    public function testShowCountriesWithoutToken()
    {
        $response = $this->getJson($this->route);
        
        $response->assertStatus(401)
                ->assertExactJson([
                    'message' => 'Unauthenticated.'
                ]);
    }

    public function testShowCountries()
    {
        $user = User::factory()->create();
        $countries = Country::all();
        
        $response = $this->actingAs($user)->getJson($this->route);

        $response->assertStatus(200)
                ->assertExactJson([
                    'success' => true,
                    'message' => 'Lista de países.',
                    'data' => $countries->toArray()
                ]);
    }
}
