<?php

namespace Tests\Unit\Services;

use App\Services\PredictionService;
use PHPUnit\Framework\TestCase;

class PredictionServiceTest extends TestCase
{
    protected $predictionService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->predictionService = new PredictionService();
    }

    public function testCalculateHostAndGuestWinProbability()
    {
        $teamPower = 80;
        $opponentPower = 70;

        $isHost = true;
        $hostWinProbability = $this->predictionService->calculateWinProbability($teamPower, $opponentPower, $isHost);
        
        $isHost = false;
        $guestWinProbability = $this->predictionService->calculateWinProbability($teamPower, $opponentPower, $isHost);

        $this->assertTrue($hostWinProbability > $guestWinProbability);

    }

    public function testPredictGoals()
    {
        $teamPower = 80;
        $winProbability = 0.6;

        $goals = $this->predictionService->predictGoals($teamPower, $winProbability);
        $this->assertGreaterThanOrEqual(0, $goals);
        $this->assertLessThanOrEqual(10, $goals);
    }
}
