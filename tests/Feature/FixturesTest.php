<?php

namespace Tests\Feature;

use App\Models\Simulation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class FixturesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_fixtures_page()
    {
        $simulation = Simulation::factory()->create();

        $response = $this->get(route('fixtures', $simulation->uid));
        $response->assertStatus(200);

        $response->assertSee($simulation->uid);

        $response->assertViewHas('fixtures');
        $response->assertViewHas('simulationUid', $simulation->uid);
    }
}
