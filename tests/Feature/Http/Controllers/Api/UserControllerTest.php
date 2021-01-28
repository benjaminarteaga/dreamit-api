<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserControllerTest extends TestCase
{
    use WithFaker;

    /**
     * Get all users test.
     *
     * @return void
     */
    public function test_get_all()
    {
        $users = User::factory()->count(5)->make();

        $response = $this->getJson('/api/users');

        $response->assertJsonStructure([
            '*' => [
                    'name',
                    'email',
                ]
        ])->assertStatus(200);
    }

    /**
     * Store new user test.
     *
     * @return void
     */
    public function test_store()
    {
        $user = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];

        $data = array_merge([
            'password' => Hash::make('123'),
            'remember_token' => Str::random(10),
        ], $user);

        $response = $this->postJson('/api/users', $data);

        $response->assertJsonStructure([
                'message',
                'user' => ['id', 'name', 'email']
            ])
            ->assertJson(['user' => $user])
            ->assertStatus(200);

        $this->assertDatabaseHas('users', $user);
    }

    /**
     * Update user test.
     *
     * @return void
     */
    public function test_update()
    {
        $user = User::factory()->create();
        $fakeUser = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];

        $response = $this->patchJson("/api/users/$user->id", $fakeUser);

        $response->assertJsonStructure([
                'message',
                'user' => ['id', 'name', 'email']
            ])
            ->assertJson(['user' => $fakeUser])
            ->assertStatus(200);

        $this->assertDatabaseHas('users', $fakeUser);
    }

    /**
     * Delete user test.
     *
     * @return void
     */
    public function test_delete()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/$user->id");

        $response->assertJsonStructure(['message'])
            ->assertStatus(200);

        $this->assertSoftDeleted($user);
    }
}
