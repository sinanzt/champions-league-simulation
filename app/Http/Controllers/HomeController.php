<?php

namespace App\Http\Controllers;

use App\Actions\Simulation\CreateNewSimulation;
use App\Repositories\TeamRepository;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct(
        public TeamRepository $teamRepository,
    ){}

    public function index()
    {
        $teams = $this->teamRepository->getTeams();

        return Inertia::render('Home', compact('teams'));
    }

    public function generateSimulation()
    {
        $simulation = CreateNewSimulation::run();

        return redirect()->route('fixtures', $simulation->uid);
    }
}
