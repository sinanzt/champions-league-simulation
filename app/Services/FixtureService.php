<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Collection;

class FixtureService
{
    /**
     * Teams to get Schedule
     *
     * @var Collection
     */
    protected Collection $teams;

    /**
     * Schedule
     *
     * @var Collection
     */
    protected Collection $schedule;

    /**
     * @var int|null How many rounds to generate
     */
    protected $rounds = 3;

    public function __construct(array $teams)
    {
        $this->teams = collect($teams);
        $this->schedule = collect();
    }

    public static function addTeams(array $teams): FixtureService
    {
        if (empty($teams)) {
            throw new Exception('You need at least 2 teams to generate the schedule.');
        }

        $instance = new static($teams);

        return $instance;
    }

    public function schedule(): Collection
    {
        if ($this->teams->isEmpty()) {
            throw new Exception('You need at least 2 teams to generate the schedule.');
        }

        $this->doubleRound();
        $this->checkForOdd();
        $this->doShuffle();
        $this->buildSchedule();
        $this->cleanSchedule();

        return $this->schedule;
    }

    protected function checkForOdd(): void
    {
        if ($this->teams->count() % 2 === 1) {
            $this->teams->push(null);
        }
    }

    protected function doShuffle(): void
    {
        $this->teams = collect($this->teams->shuffle());
    }

    public function doubleRound()
    {
        $this->rounds = (($count = $this->teams->count()) % 2 === 0 ? $count - 1 : $count) * 2;

        return $this;
    }

    protected function buildSchedule(): FixtureService
    {
        $teamsCount = $this->teams->count();
        $halfTeamCount = $teamsCount / 2;
        $rounds = $this->rounds ?? $teamsCount - 1;
        for ($round = 1; $round <= $rounds; $round += 1) {
            $this->schedule[$round] = collect();
            $this->teams->each(function ($team, $index) use ($halfTeamCount, $round) {
                if ($index >= $halfTeamCount) {
                    return false;
                }
                $team1 = $team;
                $team2 = $this->teams[$index + $halfTeamCount];
                $matchup = $round % 2 === 0 ? collect(['round' => $round, 'host' => $team1, 'guest' => $team2]) : collect(['round' => $round, 'host' => $team2, 'guest' => $team1]);
                $this->schedule[$round]->push($matchup);
            });
            $this->rotate();
        }
        return $this;
    }

    protected function rotate(): FixtureService
    {
        $teamsCount = $this->teams->count();
        if ($teamsCount < 3) {
            return $this;
        }
        $lastIndex = $teamsCount - 1;
        $factor = (int) ($teamsCount % 2 === 0 ? $teamsCount / 2 : ($teamsCount / 2) + 1);
        $topRightIndex = $factor - 1;
        $topRightItem = $this->teams[$topRightIndex];
        $bottomLeftIndex = $factor;
        $bottomLeftItem = $this->teams[$bottomLeftIndex];
        for ($i = $topRightIndex; $i > 0; $i -= 1) {
            $this->teams[$i] = $this->teams[$i - 1];
        }
        for ($i = $bottomLeftIndex; $i < $lastIndex; $i += 1) {
            $this->teams[$i] = $this->teams[$i + 1];
        }
        $this->teams[1] = $bottomLeftItem;
        $this->teams[$lastIndex] = $topRightItem;

        return $this;
    }

    protected function cleanSchedule(): FixtureService
    {
        $this->schedule = $this->schedule->transform(function ($rounds, $key) {
            return $rounds->filter(function ($round) {
                return !is_null($round->get('host')) && !is_null($round->get('guest'));
            })->values();
        })->values();
        return $this;
    }
}
