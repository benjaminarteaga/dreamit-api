<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Person;
use Faker\Factory as Faker;

class PersonControllerTest extends TestCase
{
    use WithFaker;

    /**
     * Get all persons test.
     *
     * @return void
     */
    public function test_get_all()
    {
        $persons = Person::factory()->count(5)->make();

        $response = $this->getJson('/api/persons');

        $response->assertJsonStructure([
            '*' => [
                    'first_name',
                    'last_name',
                    'rut',
                    'person_role_id'
                ]
        ])->assertStatus(200);
    }

    /**
     * Store new person test.
     *
     * @return void
     */
    public function test_store()
    {
        $faker = Faker::create();

        $person = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'person_role_id' => rand(1, 2),
            'rut' => $faker->unique()->numberBetween(80000000, 279999999),
        ];

        $response = $this->postJson('/api/persons', $person);

        $response->assertJsonStructure([
                'message',
                'person' => ['id', 'first_name', 'last_name', 'rut', 'person_role_id']
            ])
            ->assertJson(['person' => $person])
            ->assertStatus(200);

        $this->assertDatabaseHas('persons', $person);
    }

    /**
     * Show person test.
     *
     * @return void
     */
    public function test_show()
    {
        $person = Person::factory()->create();

        $response = $this->getJson("/api/persons/$person->id");

        $response->assertJsonStructure(['id', 'first_name', 'last_name', 'rut', 'person_role_id'])
            ->assertJson([
                'id' => $person->id,
                'first_name' => $person->first_name,
                'last_name' => $person->last_name,
                'rut' => $person->rut,
                'person_role_id' => $person->person_role_id,
            ])
            ->assertStatus(200);
    }

    /**
     * Update person test.
     *
     * @return void
     */
    public function test_update()
    {
        $faker = Faker::create();

        $person = Person::factory()->create();
        $fakePerson = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'person_role_id' => rand(1, 2),
            'rut' => $faker->unique()->numberBetween(80000000, 279999999),
        ];

        $response = $this->patchJson("/api/persons/$person->id", $fakePerson);

        $response->assertJsonStructure([
                'message',
                'person' => ['id', 'first_name', 'last_name', 'rut', 'person_role_id']
            ])
            ->assertJson(['person' => $fakePerson])
            ->assertStatus(200);

        $this->assertDatabaseHas('persons', $fakePerson);
    }

    /**
     * Delete person test.
     *
     * @return void
     */
    public function test_delete()
    {
        $person = Person::factory()->create();

        $response = $this->deleteJson("/api/persons/$person->id");

        $response->assertJsonStructure(['message'])
            ->assertStatus(200);

        $this->assertSoftDeleted($person);
    }
}
