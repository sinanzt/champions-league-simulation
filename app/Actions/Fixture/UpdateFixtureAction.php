<?php

namespace App\Actions\Fixture;

use App\Models\Fixture;
use App\Models\Standing;
use App\Traits\AsAction;

class UpdateFixtureAction
{
    use AsAction;

    public function handle(Fixture $fixture, array $data)
    {
        $isAlreadyPlayed = $fixture->isPlayed();
        $oldHostGoals = $fixture->host_fc_goals;
        $oldGuestGoals = $fixture->guest_fc_goals;

        $fixture->update($data);

        $hostStanding = Standing::bySimulation($fixture->simulation_id)->byTeam($fixture->host_fc_id)->first();
        $guestStanding = Standing::bySimulation($fixture->simulation_id)->byTeam($fixture->guest_fc_id)->first();

        $status = 'DRAW';
        if ($fixture->host_fc_goals > $fixture->guest_fc_goals) {
            $status = 'HOST_WIN';
        } else if ($fixture->host_fc_goals < $fixture->guest_fc_goals) {
            $status = 'GUEST_WIN';
        }

        if ($isAlreadyPlayed) {
            if ($oldHostGoals > $oldGuestGoals && $status == 'GUEST_WIN') {
                $this->swapWinnerTeam($hostStanding, $guestStanding);
            }

            if ($oldGuestGoals > $oldHostGoals && $status == 'HOST_WIN') {
                $this->swapWinnerTeam($guestStanding, $hostStanding);
            }

            if ($oldHostGoals != $oldGuestGoals && $status == 'DRAW') {
                if ($oldGuestGoals > $oldHostGoals) {
                    $this->swapWinToDraw($guestStanding, $hostStanding);
                } else if ($oldHostGoals > $oldGuestGoals) {
                    $this->swapWinToDraw($hostStanding, $guestStanding);
                }
            }

            if ($oldHostGoals == $oldGuestGoals && $status != 'DRAW') {
                if ($status == 'HOST_WIN') {
                    $this->swapDrawToWin($hostStanding, $guestStanding);
                } else if ($status == 'GUEST_WIN') {
                    $this->swapDrawToWin($guestStanding, $hostStanding);
                }
            }
        } else {
            $hostStatus = $status == 'HOST_WIN' ? 'WIN' : ($status == 'DRAW' ? 'DRAW' : 'LOST');
            $this->updateStandingByStatus($hostStanding, $hostStatus);

            $guestStatus = $status == 'GUEST_WIN' ? 'WIN' : ($status == 'DRAW' ? 'DRAW' : 'LOST');
            $this->updateStandingByStatus($guestStanding, $guestStatus);
        }

        return $fixture;
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
