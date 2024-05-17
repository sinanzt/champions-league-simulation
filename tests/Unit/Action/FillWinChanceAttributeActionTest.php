<?php

namespace Tests\Unit\Actions\Standing;

use App\Actions\Standing\FillWinChanceAttributeAction;
use App\Models\Fixture;
use App\Models\Simulation;
use App\Models\Standing;
use App\Models\Team;
use App\Repositories\StandingRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class FillWinChanceAttributeActionTest extends TestCase
{
    use RefreshDatabase;

    public function testHandle()
    {
        $simulation = Simulation::factory()->create();

        $team1 = Team::factory()->create();
        $team2 = Team::factory()->create();

        $standings = new Collection([
            Standing::factory()->make([
                'team_id' => $team1->id,
                'played' => 3,
                'points' => 10,
            ]),
            Standing::factory()->make([
                'team_id' => $team2->id,
                'played' => 3,
                'points' => 8,
            ]),
        ]);

        $unplayedFixtures = new Collection([
            Fixture::factory()->make(['host_fc_id' => $team1->id, 'guest_fc_id' => $team2->id]),
            Fixture::factory()->make(['host_fc_id' => $team2->id, 'guest_fc_id' => $team1->id]),
        ]);

        $mockStandingRepository = $this->mock(StandingRepository::class, function ($mock) use ($unplayedFixtures) {
            $mock->shouldReceive('getUnplayedFixtures')->andReturn($unplayedFixtures);
        });

        $action = new FillWinChanceAttributeAction($mockStandingRepository);

        $result = $action->handle($simulation, $standings);

        $this->assertInstanceOf(Collection::class, $result);
        foreach ($result as $standing) {
            $this->assertNotNull($standing->winChance);
        }
    }

    public function testHandleWithNoWeeksLeft()
    {
        $simulation = Simulation::factory()->create();

        $team1 = Team::factory()->create();
        $team2 = Team::factory()->create();

        $standings = new Collection([
            Standing::factory()->make([
                'team_id' => $team1->id,
                'played' => 6,
                'points' => 10,
            ]),
            Standing::factory()->make([
                'team_id' => $team2->id,
                'played' => 6,
                'points' => 8,
            ]),
        ]);

        $unplayedFixtures = new Collection();

        $mockStandingRepository = $this->mock(StandingRepository::class, function ($mock) use ($unplayedFixtures) {
            $mock->shouldReceive('getUnplayedFixtures')->andReturn($unplayedFixtures);
        });

        $action = new FillWinChanceAttributeAction($mockStandingRepository);

        $result = $action->handle($simulation, $standings);

        $this->assertInstanceOf(Collection::class, $result);
        foreach ($result as $standing) {
            $this->assertEquals(0, $standing->winChance);
        }
    }
}
