<?php

namespace App\Repositories;

use App\Models\Standing;

class StandingRepository
{
    public function getStandingBySimulationAndTeam($simulationId, $teamId)
    {
        return Standing::bySimulation($simulationId)->byTeam($teamId)->first();
    }

    public function createStanding($simulation, $teamId) {
        $simulation->standings()->create([
            'team_id' => $teamId,
            'points' => 0,
            'played' => 0,
            'won' => 0,
            'lost' => 0,
            'draw' => 0,
        ]);
    }

    public function getUnplayedFixtures($simulation) {
        return $simulation->getUnplayedFixtures();

    }

    public function updateStanding($standing, array $data)
    {
        $standing->update($data);
    }

    public function swapWinToDraw($winnerStanding, $lostStanding)
    {
        $winnerStanding->update([
            'draw' => $winnerStanding->draw + 1,
            'won' => $winnerStanding->won - 1,
            'points' => $winnerStanding->points - 2,
        ]);

        $lostStanding->update([
            'draw' => $lostStanding->draw + 1,
            'lost' => $lostStanding->lost - 1,
            'points' => $lostStanding->points + 1,
        ]);
    }

    public function swapDrawToWin($winnerStanding, $lostStanding)
    {
        $winnerStanding->update([
            'draw' => $winnerStanding->draw - 1,
            'won' => $winnerStanding->won + 1,
            'points' => $winnerStanding->points + 2,
        ]);

        $lostStanding->update([
            'draw' => $lostStanding->draw - 1,
            'lost' => $lostStanding->lost + 1,
            'points' => $lostStanding->points - 1,
        ]);
    }

    public function updateStandingByStatus($standing, $status, $isPlayed = false)
    {
        $standing->update([
            'played' => $isPlayed ? $standing->played : $standing->played + 1,
            'won' => $status == 'WIN' ? $standing->won + 1 : $standing->won,
            'draw' => $status == 'DRAW' ? $standing->draw + 1 : $standing->draw,
            'lost' => $status == 'LOST' ? $standing->lost + 1 : $standing->lost,
            'points' => $status == 'WIN' ? $standing->points + 3 : ($status == 'DRAW' ? $standing->points + 1 : $standing->points),
        ]);
    }

    public function swapWinnerTeam($oldWinnerStanding, $newWinnerStanding)
    {
        $oldWinnerStanding->update([
            'won' => $oldWinnerStanding->won - 1,
            'lost' => $oldWinnerStanding->lost + 1,
            'points' => $oldWinnerStanding->points - 3,
        ]);

        $newWinnerStanding->update([
            'won' => $newWinnerStanding->won + 1,
            'lost' => $newWinnerStanding->lost - 1,
            'points' => $newWinnerStanding->points + 3,
        ]);
    }
}
