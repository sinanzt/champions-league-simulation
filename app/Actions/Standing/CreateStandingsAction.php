<?php

namespace App\Actions\Standing;

use App\Models\Simulation;
use App\Models\Team;
use App\Traits\AsAction;

class CreateStandingsAction
{
    use AsAction;

    public function handle(Simulation $simulation)
    {
        $teams = Team::all();
        foreach ($teams as $team) {
            $simulation->standings()->create([
                'team_id' => $team->id,
                'points' => 0,
                'played' => 0,
                'won' => 0,
                'lost' => 0,
                'draw' => 0,
            ]);
        }
    }
}
