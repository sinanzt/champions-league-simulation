<?php

namespace App\Repositories;

use App\Models\Simulation;

class SimulationRepository
{
    public function create()
    {
        return Simulation::create();
    }

    public function deleteStandings(Simulation $simulation)
    {
        $simulation->standings()->delete();
    }

    public function deleteFixtures(Simulation $simulation)
    {
        $simulation->fixtures()->delete();
    }

    public function createStanding(Simulation $simulation, int $teamId, array $attributes = [])
    {
        $defaultAttributes = [
            'points' => 0,
            'played' => 0,
            'won' => 0,
            'lost' => 0,
            'draw' => 0,
        ];

        $attributes = array_merge($defaultAttributes, $attributes);
        $attributes['team_id'] = $teamId;

        $simulation->standings()->create($attributes);
    }

    public function getUnplayedFixtures(Simulation $simulation)
    {
        return $simulation->getUnplayedFixtures();
    }

    public function getNextFixture(Simulation $simulation)
    {
        return $simulation->nextFixture();
    }

    public function getLastPlayedFixture(Simulation $simulation)
    {
        return $simulation->lastPlayedFixture();
    }
}