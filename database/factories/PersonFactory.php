<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PersonRole;

class PersonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Person::class;

    /**
     * Rand number for Person Role ID.
     *
     * @var int
     */
    protected $role;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->role = PersonRole::all()->random()->id;

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'person_role_id' => $this->role,
            'rut' => $this->unique(),
        ];
    }

    /**
     *
     * Get unique person
     *
     * @return int
     */
    protected function unique()
    {
        do {
            $rut = $this->faker->numberBetween(80000000, 279999999);
        } while (Person::where(['rut' => $rut, 'person_role_id' => $this->role])->count());

        return $rut;
    }
}
