<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Simulation\PlayWeekAction;
use App\Actions\Simulation\ResetSimulationAction;
use App\Models\Simulation;
use App\Repositories\SimulationRepository;


class SimulationController extends Controller
{
    public function __construct(public SimulationRepository $simulationRepository)
    {}

    public function playWeek(Simulation $simulation)
    {
        $nextFixture = $this->simulationRepository->getNextFixture($simulation);
        PlayWeekAction::run($nextFixture);

        return redirect()->route('standings', $simulation->uid);
    }

    public function playAll(Simulation $simulation)
    {
        foreach ($simulation->fixtures as $fixture) {
            PlayWeekAction::run($fixture);
        }

        return redirect()->route('fixtures', $simulation->uid);
    }

    public function reset(Simulation $simulation)
    {
        ResetSimulationAction::run($simulation);

        return redirect()->route('standings', $simulation->uid);
    }
}
