<?php

use App\Services\FixtureService;
use PHPUnit\Framework\TestCase;

class FixtureServiceTest extends TestCase
{
    public function testAddTeamsAndScheduleGeneration()
    {
        $teams = [
            'Team A', 'Team B', 'Team C', 'Team D'
        ];

        $service = FixtureService::addTeams($teams);

        $schedule = $service->schedule();

        $this->assertNotEmpty($schedule);

        foreach ($schedule as $round) {
            $this->assertEquals(count($teams) / 2, count($round));
            
            foreach ($round as $matchup) {
                $this->assertArrayHasKey('host', $matchup);
                $this->assertArrayHasKey('guest', $matchup);
            }
        }
    }
}
