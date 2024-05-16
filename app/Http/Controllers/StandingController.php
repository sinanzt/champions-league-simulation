<?php

namespace App\Http\Controllers;

use App\Actions\Standing\FillWinChanceAttributeAction;
use App\Http\Resources\FixtureResource;
use App\Http\Resources\StandingResource;
use App\Models\Simulation;
use App\Repositories\SimulationRepository;
use Inertia\Inertia;

class StandingController extends Controller
{

    public function __construct(public SimulationRepository $simulationRepository)
    {}

    public function index(Simulation $simulation)
    {
        $standings = FillWinChanceAttributeAction::run($simulation, $simulation->standings);
        $standings = StandingResource::collection($standings);

        $nextFixture = $this->simulationRepository->getNextFixture($simulation);
        $lastPlayedFixture = $this->simulationRepository->getLastPlayedFixture($simulation);

        $groupedNextFixture = FixtureResource::collection($nextFixture)->collection->groupBy('week');
        $lastPlayedFixture = FixtureResource::collection($lastPlayedFixture)->collection->groupBy('week');
        $simulationUid = $simulation->uid;

        return view('simulation', ['standings' => $standings, 'nextFixture' => $groupedNextFixture, 'lastPlayedFixture' => $lastPlayedFixture, 'simulationUid' => $simulationUid]);
    }
}
