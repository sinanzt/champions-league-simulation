<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Simulation;
use App\Http\Resources\FixtureResource;
use Inertia\Inertia;


class FixturesController extends Controller
{
    public function index(Simulation $simulation)
    {
        $fixtures = FixtureResource::collection($simulation->fixtures)->collection->groupBy('week');
        $simulationUid = $simulation->uid;

        return Inertia::render('Fixtures', compact('fixtures', 'simulationUid'));
    }
}
