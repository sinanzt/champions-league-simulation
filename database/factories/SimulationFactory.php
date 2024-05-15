<?php

namespace Database\Factories;

use App\Actions\Fixture\GenerateNewFixtureAction;
use App\Actions\Standing\CreateStandingsAction;
use App\Models\Simulation;
use Illuminate\Database\Eloquent\Factories\Factory;

class SimulationFactory extends Factory
{
    protected $model = Simulation::class;

    public function definition()
    {
        return [
            'uid' => $this->faker->unique()->uuid,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Simulation $simulation) {
            GenerateNewFixtureAction::run($simulation);

            CreateStandingsAction::run($simulation);
        });
    }
}
