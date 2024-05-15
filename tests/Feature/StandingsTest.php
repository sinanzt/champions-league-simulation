<?php

namespace Tests\Feature;

use App\Models\Simulation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class StandingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_standings_page()
    {
        $simulation = Simulation::factory()->create();

        $response = $this->get(route('standings', $simulation->uid));
        $response->assertStatus(200);
        $response->assertSee($simulation->uid);

        $response->assertViewHas('standings');
        $response->assertViewHas('nextFixture');
        $response->assertViewHas('lastPlayedFixture');
        $response->assertViewHas('simulationUid', $simulation->uid);
    }
}
