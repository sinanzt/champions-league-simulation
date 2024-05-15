<?php

namespace Database\Factories;

use App\Models\Fixture;
use App\Models\Simulation;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class FixtureFactory extends Factory
{
    protected $model = Fixture::class;

    public function definition()
    {
        return [
            'simulation_id' => Simulation::factory(),
            'week' => $this->faker->numberBetween(1, 6),
            'host_fc_id' => Team::factory(),
            'host_fc_goals' => $this->faker->numberBetween(0, 5),
            'guest_fc_id' => Team::factory(),
            'guest_fc_goals' => $this->faker->numberBetween(0, 5),
            'played_at' => $this->faker->dateTime(),
        ];
    }

    public function notPlayed()
    {
        return $this->state(function (array $attributes) {
            return [
                'played_at' => null,
            ];
        });
    }
}
