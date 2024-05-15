<?php

namespace App\Actions\Simulation;

use App\Actions\Fixture\GenerateNewFixtureAction;
use App\Actions\Standing\CreateStandingsAction;
use App\Models\Simulation;
use App\Traits\AsAction;

class ResetSimulationAction
{
    use AsAction;

    public function handle(Simulation $simulation)
    {
        $this->refreshStandings($simulation);

        $this->refreshFixtures($simulation);
    }

    public function refreshStandings(Simulation $simulation)
    {
        $simulation->standings()->delete();

        CreateStandingsAction::run($simulation);
    }

    public function refreshFixtures(Simulation $simulation)
    {
        $simulation->fixtures()->delete();

        GenerateNewFixtureAction::run($simulation);
    }
}
