<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Simulation;
use App\Http\Resources\FixtureResource;


class FixturesController extends Controller
{
    public function index(Simulation $simulation)
    {
        $fixtures = FixtureResource::collection($simulation->fixtures)->collection->groupBy('week');
        $simulationUid = $simulation->uid;

        return view('fixture', ['fixtures' => $fixtures, 'simulationUid' => $simulationUid]);
    }
}
