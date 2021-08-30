<?php

namespace Database\Factories;

use App\Models\Family;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Person::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $relationships = ['mother', 'father', 'sister', 'brother', 'cousin', 'aunt', 'uncle'];
        return [
            'name' => $this->faker->name(),
            'family_id' => function () {
                return Family::factory()->create()->id;
            },
            'relationship' => $relationships[array_rand($relationships)]
        ];
    }
}
