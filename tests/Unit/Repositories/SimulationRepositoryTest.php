<?php

namespace Tests\Unit\Repositories;

use App\Models\Simulation;
use App\Repositories\SimulationRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimulationRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateSimulation()
    {
        $repository = new SimulationRepository();

        $simulation = $repository->create();

        $this->assertInstanceOf(Simulation::class, $simulation);
        $this->assertDatabaseHas('simulations', ['id' => $simulation->id]);
    }

    public function testDeleteStandings()
    {
        $simulation = Simulation::factory()->create();
        $repository = new SimulationRepository();

        $repository->deleteStandings($simulation);

        $this->assertEquals(0, $simulation->standings()->count());
    }

    public function testCreateStanding()
    {
        $simulation = Simulation::factory()->create();
        $repository = new SimulationRepository();

        $teamId = 1;
        $attributes = [
            'points' => 10,
            'played' => 5,
            'won' => 3,
            'lost' => 1,
            'draw' => 1,
        ];

        $repository->createStanding($simulation, $teamId, $attributes);

        $this->assertDatabaseHas('standings', [
            'simulation_id' => $simulation->id,
            'team_id' => $teamId,
            'points' => 10,
            'played' => 5,
            'won' => 3,
            'lost' => 1,
            'draw' => 1,
        ]);
    }
}
