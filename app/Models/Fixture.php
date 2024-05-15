<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToSimulation;

class Fixture extends Model
{

    use BelongsToSimulation;
    use HasFactory;

    protected $fillable = [
        'simulation_id',
        'week',
        'host_fc_id',
        'host_fc_goals',
        'guest_fc_id',
        'guest_fc_goals',
        'played_at'
    ];

    public function host(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'host_fc_id');
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'guest_fc_id');
    }

    public function isPlayed(): bool
    {
        return $this->played_at !== null;
    }
}
