<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Block;

class BlockControllerTest extends TestCase
{
    use WithFaker;

    /**
     * Get all blocks test.
     *
     * @return void
     */
    public function test_get_all()
    {
        $access = Block::factory()->count(5)->make();

        $response = $this->getJson('/api/blocks');

        $response->assertJsonStructure([
            '*' => [
                    'person_id',
                    'building_id',
                ]
        ])->assertStatus(200);
    }

    /**
     * Store new access test.
     *
     * @return void
     */
    public function test_store()
    {
        $person = Person::all()->random();
        $building = Building::all()->random();
        $access_type = AccessType::all()->random();

        $access = [
            'building_id' => $building->id,
            'access_type_id' => $access_type->id
        ];

        $data = array_merge([
            'first_name' => $person->first_name,
            'last_name' => $person->last_name,
            'rut' => $person->rut,
            'person_role_id' => $person->person_role_id
        ], $access);

        $response = $this->postJson('/api/blocks', $data);

        $access['person_id'] = $person->id;

        $response->assertJsonStructure([
                'message',
                'access' => ['person_id', 'building_id', 'access_type_id',]
            ])
            ->assertJson(['access' => $access])
            ->assertStatus(200);

        $this->assertDatabaseHas('blocks', $access);
    }

    /**
     * Update access test.
     *
     * @return void
     */
    public function test_update()
    {
        $access = Access::factory()->create();
        $fakeAccess = [
            'person_id' => Person::all()->random()->id,
            'building_id' => Building::all()->random()->id,
            'access_type_id' => AccessType::all()->random()->id
        ];

        $response = $this->patchJson("/api/blocks/$access->id", $fakeAccess);

        $response->assertJsonStructure([
                'message',
                'access' => ['person_id', 'building_id', 'access_type_id',]
            ])
            ->assertJson(['access' => $fakeAccess])
            ->assertStatus(200);

        $this->assertDatabaseHas('blocks', $fakeAccess);
    }

    /**
     * Delete access test.
     *
     * @return void
     */
    public function test_delete()
    {
        $access = Access::factory()->create();

        $response = $this->deleteJson("/api/blocks/$access->id");

        $response->assertJsonStructure(['message'])
            ->assertStatus(200);

        $this->assertSoftDeleted($access);
    }
}
