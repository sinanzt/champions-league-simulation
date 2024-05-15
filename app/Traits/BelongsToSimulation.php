<?php

namespace App\Traits;

use App\Models\Simulation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToSimulation
{
    public function simulation(): BelongsTo
    {
        return $this->belongsTo(Simulation::class);
    }

    public function scopeBySimulation($query, $simulation_id)
    {
        $query->where('simulation_id', $simulation_id);
    }
}
