<?php

namespace App\Actions\Fixture;

use App\Models\Fixture;
use App\Repositories\StandingRepository;
use App\Traits\AsAction;

class UpdateFixtureAction
{
    use AsAction;

    public const STATUS_DRAW = 'DRAW';
    public const STATUS_HOST_WIN = 'HOST_WIN';
    public const STATUS_GUEST_WIN = 'GUEST_WIN';

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

        $status = self::STATUS_DRAW;
        if ($fixture->host_fc_goals > $fixture->guest_fc_goals) {
            $status = self::STATUS_HOST_WIN;
        } else if ($fixture->host_fc_goals < $fixture->guest_fc_goals) {
            $status = self::STATUS_GUEST_WIN;
        }

        if ($isAlreadyPlayed) {
            if ($oldHostGoals > $oldGuestGoals && $status == self::STATUS_GUEST_WIN) {
                $this->standingRepository->swapWinnerTeam($hostStanding, $guestStanding);
            }

            if ($oldGuestGoals > $oldHostGoals && $status == self::STATUS_HOST_WIN) {
                $this->standingRepository->swapWinnerTeam($guestStanding, $hostStanding);
            }

            if ($oldHostGoals != $oldGuestGoals && $status == self::STATUS_DRAW) {
                if ($oldGuestGoals > $oldHostGoals) {
                    $this->standingRepository->swapWinToDraw($guestStanding, $hostStanding);
                } else if ($oldHostGoals > $oldGuestGoals) {
                    $this->standingRepository->swapWinToDraw($hostStanding, $guestStanding);
                }
            }

            if ($oldHostGoals == $oldGuestGoals && $status != self::STATUS_DRAW) {
                if ($status == self::STATUS_HOST_WIN) {
                    $this->standingRepository->swapDrawToWin($hostStanding, $guestStanding);
                } else if ($status == self::STATUS_GUEST_WIN) {
                    $this->standingRepository->swapDrawToWin($guestStanding, $hostStanding);
                }
            }
        } else {
            $hostStatus = $status == self::STATUS_HOST_WIN ? 'WIN' : ($status == self::STATUS_DRAW ? 'DRAW' : 'LOST');
            $this->standingRepository->updateStandingByStatus($hostStanding, $hostStatus);

            $guestStatus = $status == self::STATUS_GUEST_WIN ? 'WIN' : ($status == self::STATUS_DRAW ? 'DRAW' : 'LOST');
            $this->standingRepository->updateStandingByStatus($guestStanding, $guestStatus);
        }

        return $fixture;
    }
}