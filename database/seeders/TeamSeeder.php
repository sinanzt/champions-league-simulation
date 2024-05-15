<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            [
                "name" => "Liverpool",
                "slug" => "liverpool",
                "attackRating" => 84,
                "midfieldRating" => 81,
                "defenceRating" => 84,
            ],
            [
                "name" => "Manchester City",
                "slug" => "manchester-city",
                "attackRating" => 87,
                "midfieldRating" => 87,
                "defenceRating" => 84,
            ],
            [
                "name" => "Chelsea",
                "slug" => "chelsea",
                "attackRating" => 78,
                "midfieldRating" => 81,
                "defenceRating" => 79,
            ],
            [
                "name" => "Arsenal",
                "slug" => "arsenal",
                "attackRating" => 83,
                "midfieldRating" => 84,
                "defenceRating" => 81,
            ]
        ];

        Team::insert($teams);
    }
}
