<?php

namespace Database\Factories;

use App\Models\Simulation;
use App\Models\Standing;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class StandingFactory extends Factory
{
    protected $model = Standing::class;

    public function definition()
    {
        return [
            'team_id' => Team::factory(),
            'simulation_id' => Simulation::factory(),
            'points' => $this->faker->numberBetween(0, 100),
            'played' => $this->faker->numberBetween(0, 100),
            'won' => $this->faker->numberBetween(0, 100),
            'lost' => $this->faker->numberBetween(0, 100),
            'draw' => $this->faker->numberBetween(0, 100),
        ];
    }
}
