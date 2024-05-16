<?php

namespace App\Actions\Standing;

use App\Models\Simulation;
use App\Traits\AsAction;
use Illuminate\Support\Collection;
use App\Repositories\StandingRepository;

class FillWinChanceAttributeAction
{
    use AsAction;

    public function __construct(
        public StandingRepository $standingRepository
    ){}

    public function handle(Simulation $simulation, Collection $standings)
    {
        $firstTeamStanding = $standings->first();

        $weeksLeft = 6 - $firstTeamStanding->played;

        $unplayedFixtures = $this->standingRepository->getUnplayedFixtures($simulation);

        $sumChance = 0;

        foreach ($standings as $key => $standing) {
            $currentPosition = $key + 1;

            if ($standing->played < 4 || !$weeksLeft) {
                $standing->winChance = -1;
                continue;
            }

            $maxPointsForStanding = $standing->points + (3 * $weeksLeft);
            if ($firstTeamStanding != $standing && $firstTeamStanding->points > $maxPointsForStanding) {
                $standing->winChance = 0;
                continue;
            }

            $chanceToWin = 0;
            foreach ($unplayedFixtures as $fixture) {
                if ($fixture->host_fc_id == $standing->team->id) {
                    $chanceToWin += 2;
                }

                if ($fixture->guest_fc_id == $standing->team->id) {
                    $chanceToWin += 1;
                }
            }

            $chanceToWin = ($chanceToWin - ($currentPosition / 2)) - (($firstTeamStanding->points - $standing->points) / 2);

            if ($chanceToWin > 0) {
                $standing->winChance = $chanceToWin;
                $sumChance += $chanceToWin;
                continue;
            }

            if ($currentPosition == 1 && empty($unplayedFixtures)) {
                $standing->winChance = abs($chanceToWin);
                $sumChance += abs($chanceToWin);
                continue;
            }
        }

        $onePointPercentValue = 100 / ($sumChance ?: 0.1);

        foreach ($standings as $standing) {
            if ($standing->winChance != -1 && $standing->winChance != 0) {
                $standing->winChance = round($standing->winChance * $onePointPercentValue,  2);
            }
        }

        return $standings;
    }
}
