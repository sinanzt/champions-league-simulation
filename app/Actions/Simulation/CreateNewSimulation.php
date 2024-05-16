<?php

namespace App\Actions\Simulation;

use App\Actions\Fixture\GenerateNewFixtureAction;
use App\Actions\Standing\CreateStandingsAction;
use App\Repositories\SimulationRepository;

use App\Traits\AsAction;

class CreateNewSimulation
{
    use AsAction;

    public function __construct(
        public SimulationRepository $simulationRepository,
    ){}

    public function handle()
    {
        $simulation = $this->simulationRepository->create();
        CreateStandingsAction::run($simulation);
        GenerateNewFixtureAction::run($simulation);

        return $simulation;
    }
}
