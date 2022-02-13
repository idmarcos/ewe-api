<?php

namespace Tests\Feature\API\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Region;
use App\Models\User;

class RegionTest extends TestCase
{
    protected $route = 'api/v1/regions';

    public function testShowRegionsWithoutToken()
    {
        $response = $this->getJson($this->route);
        
        $response->assertStatus(401)
                ->assertExactJson([
                    'message' => 'Unauthenticated.'
                ]);
    }

    public function testShowRegions()
    {
        $user = User::factory()->create();
        $regions = Region::all();
        
        $response = $this->actingAs($user)->getJson($this->route);

        $response->assertStatus(200)
                ->assertExactJson([
                    'success' => true,
                    'message' => 'Lista de regiones.',
                    'data' => $regions->toArray()
                ]);
    }

    public function testShowRegionsWithCountryData()
    {
        $data = [
            'country_id' => 1
        ];
        $user = User::factory()->create();
        $regions = Region::where('country_id', $data['country_id'])->get();
        
        $response = $this->actingAs($user)->json('GET', $this->route, $data);

        $response->assertStatus(200)
                ->assertExactJson([
                    'success' => true,
                    'message' => 'Lista de regiones.',
                    'data' => $regions->toArray()
                ]);
    }
}
