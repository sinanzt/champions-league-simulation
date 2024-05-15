<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\BelongsToSimulation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Standing extends Model
{

    use BelongsToSimulation;
    use HasFactory;

    protected $fillable = [
        'team_id',
        'simulation_id',
        'points',
        'played',
        'won',
        'lost',
        'draw',
    ];

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('points', 'desc');
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function getGoalDifferenceAttribute(): int
    {
        $hostedFixtures = $this->simulation->fixtures()->where('host_fc_id', $this->team_id)->whereNotNull('played_at')->get();
        $guestedFixtures = $this->simulation->fixtures()->where('guest_fc_id', $this->team_id)->whereNotNull('played_at')->get();

        return ($hostedFixtures->sum('host_fc_goals') + $guestedFixtures->sum('guest_fc_goals')) - ($hostedFixtures->sum('guest_fc_goals') + $guestedFixtures->sum('host_fc_goals'));
    }

    public function scopeByTeam($query, $team_id)
    {
        $query->where('team_id', $team_id);
    }
}
