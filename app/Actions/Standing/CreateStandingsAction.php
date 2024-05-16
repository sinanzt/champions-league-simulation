<?php

namespace App\Actions\Standing;

use App\Models\Simulation;
use App\Traits\AsAction;
use App\Repositories\TeamRepository;
use App\Repositories\StandingRepository;

class CreateStandingsAction
{
    use AsAction;

    public function __construct(
        public TeamRepository $teamRepository,
        public StandingRepository $standingRepository
    ){}

    public function handle(Simulation $simulation)
    {
        $teams = $this->teamRepository->getTeams();
        foreach ($teams as $team) {
            $this->standingRepository->createStanding($simulation, $team->id);
        }
    }
}
