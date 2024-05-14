<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fixture extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'simulation_id',
        'week',
        'host_fc_id',
        'host_fc_goals',
        'guest_fc_id',
        'guest_fc_goals',
        'played_at'
    ];

    /**
     * Define Relation with Team Model (Host)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function host(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'host_fc_id');
    }

    /**
     * Define Relation with Team Model (Guest)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'guest_fc_id');
    }

    /**
     * Check if fixture is played.
     * 
     * @return bool
     */
    public function isPlayed(): bool
    {
        return $this->played_at !== null;
    }
}
