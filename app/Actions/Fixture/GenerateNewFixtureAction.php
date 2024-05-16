<?php

namespace App\Actions\Fixture;

use App\Models\Fixture;
use App\Models\Simulation;
use App\Repositories\TeamRepository;
use App\Repositories\FixtureRepository;
use App\Services\FixtureService;
use App\Traits\AsAction;

class GenerateNewFixtureAction
{
    use AsAction;

    public function __construct(
        public TeamRepository $teamRepository,
        public FixtureRepository $fixtureRepository
    ){}

    public function handle(Simulation $simulation)
    {
        $teams = $this->teamRepository->getAllTeamIds();
        $schedule = FixtureService::addTeams($teams)->schedule();

        foreach ($schedule as $round => $fixtures) {
            foreach ($fixtures as $fixture) {
                $this->fixtureRepository->create([
                    'simulation_id' => $simulation->id,
                    'week' => $fixture['round'],
                    'host_fc_id' => $fixture['host'],
                    'guest_fc_id' => $fixture['guest'],
                    'played_at' => null,
                ]);
            }
        }
    }
}
