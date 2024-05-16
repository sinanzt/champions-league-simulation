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
            'attack_rating' => $this->faker->numberBetween(70, 100),
            'midfield_rating' => $this->faker->numberBetween(70, 100),
            'defence_rating' => $this->faker->numberBetween(70, 100),
        ];
    }
}
