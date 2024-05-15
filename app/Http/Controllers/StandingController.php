<?php

namespace App\Http\Controllers;

use App\Actions\Standing\FillWinChanceAttributeAction;
use App\Http\Resources\FixtureResource;
use App\Http\Resources\StandingResource;
use App\Models\Simulation;
use Inertia\Inertia;

class StandingController extends Controller
{
    public function index(Simulation $simulation)
    {
        $standings = FillWinChanceAttributeAction::run($simulation, $simulation->standings);
        $standings = StandingResource::collection($standings);
        $nextFixture = FixtureResource::collection($simulation->nextFixture())->collection->groupBy('week');
        $lastPlayedFixture = FixtureResource::collection($simulation->lastPlayedFixture())->collection->groupBy('week');
        $simulationUid = $simulation->uid;

        return view('simulation', ['standings' => $standings, 'nextFixture' => $nextFixture, 'lastPlayedFixture' => $lastPlayedFixture, 'simulationUid' => $simulationUid]);
    }
}
