<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ratings from https://www.fifaindex.com/teams/fifa21/
        $teams = [
            [
                "name" => "Liverpool",
                "slug" => "liverpool",
                "imageUrl" => "https://resources.premierleague.com/premierleague/badges/25/t14.png",
                "attackRating" => 84,
                "midfieldRating" => 81,
                "defenceRating" => 84,
            ],
            [
                "name" => "Manchester City",
                "slug" => "manchester-city",
                "imageUrl" => "https://resources.premierleague.com/premierleague/badges/25/t43.png",
                "attackRating" => 87,
                "midfieldRating" => 87,
                "defenceRating" => 84,
            ],
            [
                "name" => "Chelsea",
                "slug" => "chelsea",
                "imageUrl" => "https://resources.premierleague.com/premierleague/badges/25/t8.png",
                "attackRating" => 78,
                "midfieldRating" => 81,
                "defenceRating" => 79,
            ],
            [
                "name" => "Arsenal",
                "slug" => "arsenal",
                "imageUrl" => "https://resources.premierleague.com/premierleague/badges/25/t3.png",
                "attackRating" => 83,
                "midfieldRating" => 84,
                "defenceRating" => 81,
            ]
        ];

        Team::insert($teams);
    }
}
