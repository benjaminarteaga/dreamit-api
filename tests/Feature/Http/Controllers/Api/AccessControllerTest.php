<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Access;
use App\Models\Person;
use App\Models\Building;
use App\Models\AccessType;
use App\Models\Block;

class AccessControllerTest extends TestCase
{
    use WithFaker;

    /**
     * Get all accesses test.
     *
     * @return void
     */
    public function test_get_all()
    {
        $access = Access::factory()->count(5)->make();

        $response = $this->getJson('/api/accesses');

        $response->assertJsonStructure([
            '*' => [
                    'person_id',
                    'building_id',
                    'access_type_id',
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
        $person = Person::factory()->create();
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

        $response = $this->postJson('/api/accesses', $data);

        $access['person_id'] = $person->id;

        $response->assertJsonStructure([
                'message',
                'access' => ['person_id', 'building_id', 'access_type_id',]
            ])
            ->assertJson(['access' => $access])
            ->assertStatus(200);

        $this->assertDatabaseHas('accesses', $access);
    }

    /**
     * Try to store a new access for a blocked person test.
     *
     * @return void
     */
    public function test_blocked_access()
    {
        $block = Block::factory()->create();
        $person = Person::find($block->person_id);
        $building = Building::find($block->building_id);
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

        $response = $this->postJson('/api/accesses', $data);

        $access['person_id'] = $person->id;

        $response->assertJsonStructure([
                'message',
                'block' => ['person_id', 'building_id'],
                'access' => ['person_id', 'building_id', 'access_type_id']
            ])
            ->assertJson([
                'block' => [
                    'id' => $block->id,
                    'person_id' => $block->person_id,
                    'building_id' => $block->building_id,
                ],
                'access' => $access
            ])
            ->assertStatus(422);
    }

    /**
     * Show access test.
     *
     * @return void
     */
    public function test_show()
    {
        $access = Access::factory()->create();

        $response = $this->getJson("/api/accesses/$access->id");

        $response->assertJsonStructure(['person_id', 'building_id', 'access_type_id',])
            ->assertJson([
                'id' => $access->id,
                'person_id' => $access->person_id,
                'building_id' => $access->building_id,
                'access_type_id' => $access->access_type_id,
            ])
            ->assertStatus(200);
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

        $response = $this->patchJson("/api/accesses/$access->id", $fakeAccess);

        $response->assertJsonStructure([
                'message',
                'access' => ['person_id', 'building_id', 'access_type_id',]
            ])
            ->assertJson(['access' => $fakeAccess])
            ->assertStatus(200);

        $this->assertDatabaseHas('accesses', $fakeAccess);
    }

    /**
     * Delete access test.
     *
     * @return void
     */
    public function test_delete()
    {
        $access = Access::factory()->create();

        $response = $this->deleteJson("/api/accesses/$access->id");

        $response->assertJsonStructure(['message'])
            ->assertStatus(200);

        $this->assertSoftDeleted($access);
    }
}
