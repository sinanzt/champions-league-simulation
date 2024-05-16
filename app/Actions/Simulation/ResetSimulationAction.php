<?php

namespace App\Actions\Simulation;

use App\Actions\Fixture\GenerateNewFixtureAction;
use App\Actions\Standing\CreateStandingsAction;
use App\Models\Simulation;
use App\Repositories\SimulationRepository;
use App\Traits\AsAction;

class ResetSimulationAction
{
    use AsAction;

    public function __construct(public SimulationRepository $simulationRepository)
    {}

    public function handle(Simulation $simulation)
    {
        $this->refreshStandings($simulation);
        $this->refreshFixtures($simulation);
    }

    public function refreshStandings(Simulation $simulation)
    {
        $this->simulationRepository->deleteStandings($simulation);
        CreateStandingsAction::run($simulation);
    }

    public function refreshFixtures(Simulation $simulation)
    {
        $this->simulationRepository->deleteFixtures($simulation);
        GenerateNewFixtureAction::run($simulation);
    }
}