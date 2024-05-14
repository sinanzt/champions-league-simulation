<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Standing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'simulation_id',
        'points',
        'played',
        'won',
        'lost',
        'draw',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('points', 'desc');
        });
    }

    /**
     * Define Relation with Team Model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get goal_difference attribute
     * 
     * @return int
     */
    public function getGoalDifferenceAttribute(): int
    {
        $hostedFixtures = $this->simulation->fixtures()->where('host_fc_id', $this->team_id)->whereNotNull('played_at')->get();
        $guestedFixtures = $this->simulation->fixtures()->where('guest_fc_id', $this->team_id)->whereNotNull('played_at')->get();

        return ($hostedFixtures->sum('host_fc_goals') + $guestedFixtures->sum('guest_fc_goals')) - ($hostedFixtures->sum('guest_fc_goals') + $guestedFixtures->sum('host_fc_goals'));
    }

    /**
     * Scope a query to only include Standing of a given team.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param int $team_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByTeam($query, $team_id)
    {
        $query->where('team_id', $team_id);
    }
}
