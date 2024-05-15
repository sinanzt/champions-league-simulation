<?php

namespace App\Actions\Simulation;

use App\Actions\Fixture\GenerateNewFixtureAction;
use App\Actions\Standing\CreateStandingsAction;
use App\Models\Simulation;
use App\Traits\AsAction;

class CreateNewSimulation
{
    use AsAction;

    public function handle()
    {
        $simulation = Simulation::create();
        CreateStandingsAction::run($simulation);
        GenerateNewFixtureAction::run($simulation);

        return $simulation;
    }
}
