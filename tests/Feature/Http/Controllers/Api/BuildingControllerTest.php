<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Building;
use Faker\Factory as Faker;

class BuildingControllerTest extends TestCase
{
    /**
     * Get all buildings test.
     *
     * @return void
     */
    public function test_get_all()
    {
        $buildings = Building::factory()->count(5)->make();

        $response = $this->getJson('/api/buildings');

        $response->assertJsonStructure([
            '*' => [
                    'name',
                    'address',
                ]
        ])->assertStatus(200);
    }

    /**
     * Store new building test.
     *
     * @return void
     */
    public function test_store()
    {
        $faker = Faker::create();
        $building = [
            'name' => $faker->company,
            'address' => $faker->address,
        ];

        $response = $this->postJson('/api/buildings', $building);

        $response->assertJsonStructure([
                'message',
                'building' => ['name', 'address']
            ])
            ->assertJson(['building' => $building])
            ->assertStatus(200);

        $this->assertDatabaseHas('buildings', $building);
    }

    /**
     * Show building test.
     *
     * @return void
     */
    public function test_show()
    {
        $building = Building::factory()->create();

        $response = $this->getJson("/api/buildings/$building->id");

        $response->assertJsonStructure(['id', 'name', 'address'])
            ->assertJson([
                'id' => $building->id,
                'name' => $building->name,
                'address' => $building->address,
            ])
            ->assertStatus(200);
    }

    /**
     * Update building test.
     *
     * @return void
     */
    public function test_update()
    {
        $faker = Faker::create();

        $building = Building::factory()->create();
        $fakeBuilding = [
            'name' => $faker->company,
            'address' => $faker->address,
        ];

        $response = $this->patchJson("/api/buildings/$building->id", $fakeBuilding);

        $response->assertJsonStructure([
                'message',
                'building' => ['id', 'name', 'address']
            ])
            ->assertJson(['building' => $fakeBuilding])
            ->assertStatus(200);

        $this->assertDatabaseHas('buildings', $fakeBuilding);
    }

    /**
     * Delete building test.
     *
     * @return void
     */
    public function test_delete()
    {
        $building = Building::factory()->create();

        $response = $this->deleteJson("/api/buildings/$building->id");

        $response->assertJsonStructure(['message'])
            ->assertStatus(200);

        $this->assertSoftDeleted($building);
    }
}
