<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->unique()->userName(),
            'attackRating' => $this->faker->numberBetween(70, 100),
            'midfieldRating' => $this->faker->numberBetween(70, 100),
            'defenceRating' => $this->faker->numberBetween(70, 100),
        ];
    }
}
