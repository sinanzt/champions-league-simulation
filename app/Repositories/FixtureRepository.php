<?php

namespace App\Repositories;

use App\Models\Fixture;

class FixtureRepository
{
    public function create($fixtureData)
    {
        return Fixture::create($fixtureData);
    }
}