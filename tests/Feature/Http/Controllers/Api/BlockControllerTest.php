<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Block;
use App\Models\Person;
use App\Models\Building;

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
        $person = Person::factory()->create();
        $building = Building::factory()->create();

        $data = [
            'person_id' => $person->id,
            'building_id' => $building->id
        ];

        $response = $this->postJson('/api/blocks', $data);

        $response->assertJsonStructure([
                'message',
                'block' => ['person_id', 'building_id']
            ])
            ->assertJson(['block' => $data])
            ->assertStatus(200);

        $this->assertDatabaseHas('blocks', $data);
    }

    /**
     * Show block test.
     *
     * @return void
     */
    public function test_show()
    {
        $block = Block::factory()->create();

        $response = $this->getJson("/api/blocks/$block->id");

        $response->assertJsonStructure(['id', 'person_id', 'building_id'])
            ->assertJson([
                'id' => $block->id,
                'person_id' => $block->person_id,
                'building_id' => $block->building_id,
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
        $block = Block::factory()->create();
        $fakeBlock = [
            'person_id' => Person::all()->random()->id,
            'building_id' => Building::all()->random()->id
        ];

        $response = $this->patchJson("/api/blocks/$block->id", $fakeBlock);

        $response->assertJsonStructure([
                'message',
                'block' => ['person_id', 'building_id',]
            ])
            ->assertJson(['block' => $fakeBlock])
            ->assertStatus(200);

        $this->assertDatabaseHas('blocks', $fakeBlock);
    }

    /**
     * Delete access test.
     *
     * @return void
     */
    public function test_delete()
    {
        $access = Block::factory()->create();

        $response = $this->deleteJson("/api/blocks/$access->id");

        $response->assertJsonStructure(['message'])
            ->assertStatus(200);

        $this->assertSoftDeleted($access);
    }
}
