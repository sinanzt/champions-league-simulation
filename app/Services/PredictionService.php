<?php

namespace App\Services;

class PredictionService
{
    public function predictScores($hostTeam, $guestTeam)
    {
        $hostAttack = $hostTeam->attack_rating;
        $hostDefence = $hostTeam->defence_rating;
        $hostMidfield = $hostTeam->midfield_rating;

        $guestAttack = $guestTeam->attack_rating;
        $guestDefence = $guestTeam->defence_rating;
        $guestMidfield = $guestTeam->midfield_rating;

        $hostPower = ($hostAttack * 1.5 + $hostMidfield + $hostDefence) / 3;
        $guestPower = ($guestAttack * 1.5 + $guestMidfield + $guestDefence) / 3;

        // Calculate win probabilities (host advantage is 10%)
        $hostWinProbability = $this->calculateWinProbability($hostPower, $guestPower, true);
        $guestWinProbability = $this->calculateWinProbability($guestPower, $hostPower, false);

        // Predict match scores
        $hostGoals = $this->predictGoals($hostPower, $hostWinProbability);
        $guestGoals = $this->predictGoals($guestPower, $guestWinProbability);

        return [
            'hostGoals' => $hostGoals,
            'guestGoals' => $guestGoals,
        ];
    }

    public function calculateWinProbability($teamPower, $opponentPower, $isHost)
    {
        // Add 10% to win probability if the team is host
        $winProbability = $teamPower / ($teamPower + $opponentPower);
        if ($isHost) {
            $winProbability += 0.1;
        }
        return $winProbability;
    }

    public function predictGoals($teamPower, $winProbability)
    {
        // Predict a random number of goals based on team power
        // Higher power means higher probability of scoring goals
        // Taking into account win probability

        $minGoals = 0;

        // Goal probabilities based on win probability
        $goalProbabilities = [
            10, // 0 goals
            20, // 1 goal
            30, // 2 goals
            25, // 3 goals
            15, // 4 goals
            10, // 5 goals
            5,  // 6 goals
            3,  // 7 goals
            2,  // 8 goals
            1,  // 9 goals
            1   // 10 goals
        ];

        // If win probability is higher, there may be a tendency to score more goals
        for ($i = 0; $i < count($goalProbabilities); $i++) {
            $goalProbabilities[$i] *= $winProbability;
        }

        $totalProbability = array_sum($goalProbabilities);

        // Randomly select a number of goals based on total probability
        $rand = mt_rand(1, $totalProbability);

        $cumulativeProbability = 0;
        for ($i = $minGoals; $i < count($goalProbabilities); $i++) {
            $cumulativeProbability += $goalProbabilities[$i];
            if ($rand <= $cumulativeProbability) {
                return $i;
            }
        }

        return $minGoals;
    }
}
