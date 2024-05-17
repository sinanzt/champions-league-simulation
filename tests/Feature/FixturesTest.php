<?php

namespace Tests\Feature;

use App\Models\Simulation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class FixturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_fixtures_page()
    {
        $simulation = Simulation::factory()->create();

        $response = $this->get(route('fixtures', $simulation->uid));
        $response->assertStatus(200);

        $response->assertSee($simulation->uid);

        $response->assertStatus(200)
            ->assertInertia(function (Assert $page) use ($simulation) {
                $page->component('Fixtures')
                    ->has('fixtures')
                    ->where('simulationUid', $simulation->uid);
            });
    }
}
