<?php
namespace App\Actions\Fixture;

use App\Models\Fixture;
use App\Repositories\StandingRepository;
use App\Traits\AsAction;

class UpdateFixtureAction
{
    use AsAction;

    public function __construct(
        public StandingRepository $standingRepository
    ) {}

    public function handle(Fixture $fixture, array $data)
    {
        $isAlreadyPlayed = $fixture->isPlayed();
        $oldHostGoals = $fixture->host_fc_goals;
        $oldGuestGoals = $fixture->guest_fc_goals;

        $fixture->update($data);

        $hostStanding = $this->standingRepository->getStandingBySimulationAndTeam($fixture->simulation_id, $fixture->host_fc_id);
        $guestStanding = $this->standingRepository->getStandingBySimulationAndTeam($fixture->simulation_id, $fixture->guest_fc_id);

        $status = 'DRAW';
        if ($fixture->host_fc_goals > $fixture->guest_fc_goals) {
            $status = 'HOST_WIN';
        } else if ($fixture->host_fc_goals < $fixture->guest_fc_goals) {
            $status = 'GUEST_WIN';
        }

        if ($isAlreadyPlayed) {
            if ($oldHostGoals > $oldGuestGoals && $status == 'GUEST_WIN') {
                $this->standingRepository->swapWinnerTeam($hostStanding, $guestStanding);
            }

            if ($oldGuestGoals > $oldHostGoals && $status == 'HOST_WIN') {
                $this->standingRepository->swapWinnerTeam($guestStanding, $hostStanding);
            }

            if ($oldHostGoals != $oldGuestGoals && $status == 'DRAW') {
                if ($oldGuestGoals > $oldHostGoals) {
                    $this->standingRepository->swapWinToDraw($guestStanding, $hostStanding);
                } else if ($oldHostGoals > $oldGuestGoals) {
                    $this->standingRepository->swapWinToDraw($hostStanding, $guestStanding);
                }
            }

            if ($oldHostGoals == $oldGuestGoals && $status != 'DRAW') {
                if ($status == 'HOST_WIN') {
                    $this->standingRepository->swapDrawToWin($hostStanding, $guestStanding);
                } else if ($status == 'GUEST_WIN') {
                    $this->standingRepository->swapDrawToWin($guestStanding, $hostStanding);
                }
            }
        } else {
            $hostStatus = $status == 'HOST_WIN' ? 'WIN' : ($status == 'DRAW' ? 'DRAW' : 'LOST');
            $this->standingRepository->updateStandingByStatus($hostStanding, $hostStatus);

            $guestStatus = $status == 'GUEST_WIN' ? 'WIN' : ($status == 'DRAW' ? 'DRAW' : 'LOST');
            $this->standingRepository->updateStandingByStatus($guestStanding, $guestStatus);
        }

        return $fixture;
    }
}
