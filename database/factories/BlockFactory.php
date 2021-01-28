<?php

namespace Database\Factories;

use App\Models\Block;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Person;
use App\Models\Building;

class BlockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Block::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $person_id = Person::all()->random()->id;
            $building_id = Building::all()->random()->id;
        } while (Block::where(['person_id' => $person_id, 'building_id' => $building_id])->count());

        return [
            'person_id' => $person_id,
            'building_id' => $building_id,
        ];
    }
}
