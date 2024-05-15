<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Actions\Simulation\CreateNewSimulation;

class HomeController extends Controller
{
    public function index()
    {
        $teams = Team::all();

        return view('home', ['teams' => $teams]);
    }

    public function generateSimulation()
    {
        $simulation = CreateNewSimulation::run();

        return redirect()->route('fixtures', $simulation->uid);
    }
}
