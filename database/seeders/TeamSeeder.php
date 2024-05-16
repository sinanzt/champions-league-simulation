<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Repositories\TeamRepository;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    public function __construct(
        public TeamRepository $teamRepository,
    ){}

    public function run(): void
    {
        $teams = [
            [
                "name" => "Liverpool",
                "slug" => "liverpool",
                "attack_rating" => 84,
                "midfield_rating" => 81,
                "defence_rating" => 84,
            ],
            [
                "name" => "Manchester City",
                "slug" => "manchester-city",
                "attack_rating" => 87,
                "midfield_rating" => 87,
                "defence_rating" => 84,
            ],
            [
                "name" => "Chelsea",
                "slug" => "chelsea",
                "attack_rating" => 78,
                "midfield_rating" => 81,
                "defence_rating" => 79,
            ],
            [
                "name" => "Arsenal",
                "slug" => "arsenal",
                "attack_rating" => 83,
                "midfield_rating" => 84,
                "defence_rating" => 81,
            ]
        ];

        $this->teamRepository->insertTeams($teams);
    }
}
