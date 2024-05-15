<?php

namespace Tests\Feature;

use App\Models\Simulation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimulationTest extends TestCase
{
    use RefreshDatabase;

    public function test_play_week_action()
    {
        $simulation = Simulation::factory()->create();

        $response = $this->post(route('simulation.playWeek', $simulation->uid));

        $response->assertRedirectContains('/standings');
    }

    public function test_play_all_action()
    {
        $simulation = Simulation::factory()->create();

        $response = $this->post(route('simulation.playAll', $simulation->uid));

        $response->assertRedirectContains('/fixtures');
    }

    public function test_reset_action()
    {
        $simulation = Simulation::factory()->create();

        $response = $this->post(route('simulation.reset', $simulation->uid));

        $response->assertRedirectContains('/standings');
    }
}
