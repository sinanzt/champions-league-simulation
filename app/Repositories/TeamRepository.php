<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Support\Collection;

class TeamRepository
{
    public function getTeams(): Collection
    {
        return Team::all();
    }

    public function getAllTeamIds()
    {
        return Team::pluck('id')->toArray();
    }

    public function insertTeams(array $teams): void
    {
        Team::insert($teams);
    }
}
