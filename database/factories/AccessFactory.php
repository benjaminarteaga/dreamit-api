<?php

namespace Database\Factories;

use App\Models\Access;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Person;
use App\Models\Building;
use App\Models\AccessType;

class AccessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Access::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'person_id' => Person::all()->random()->id,
            'building_id' => Building::all()->random()->id,
            'access_type_id' => AccessType::all()->random()->id
        ];
    }
}
