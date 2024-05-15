<?php

namespace App\Actions\Simulation;

use App\Actions\Fixture\UpdateFixtureAction;
use App\Models\Fixture;
use App\Services\PredictionService;
use App\Traits\AsAction;
use Illuminate\Support\Collection;

class PlayWeekAction
{
    use AsAction;

    public function handle($fixtures)
    {
        if ($fixtures instanceof Collection) {
            $fixtures->each(function (Fixture $fixture) {
                $this->playWeek($fixture);
            });
        } else {
            $this->playWeek($fixtures);
        }
    }

    /**
     * Play the week of the fixture.
     *
     * @param \App\Models\Fixture $fixture
     *
     * @return void
     */
    protected function playWeek(Fixture $fixture)
    {
        if (!$fixture->isPlayed()) {
            $predictionService = new PredictionService();
            $scores = $predictionService->predictScores($fixture->host, $fixture->guest);

            UpdateFixtureAction::run($fixture, [
                'host_fc_goals' => $scores['hostGoals'],
                'guest_fc_goals' => $scores['guestGoals'],
                'played_at' => now(),
            ]);
        }
    }
}
