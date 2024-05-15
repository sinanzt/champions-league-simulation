<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Simulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
    ];

    public function getRouteKeyName()
    {
        return 'uid';
    }

    protected static function booted()
    {
        static::creating(function ($item) {
            $uid = uniqid();
            while (self::where('uid', '=', $uid)->count() > 0) {
                $uid = uniqid();
            }
            $item->uid = $uid;
        });
    }

    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }

    public function fixtures(): HasMany
    {
        return $this->hasMany(Fixture::class);
    }

    public function lastPlayedFixture(): Collection
    {
        return $this->fixtures()->whereNotNull('played_at')->orderBy('week', 'desc')->take(2)->get();
    }

    public function nextFixture(): Collection
    {
        $lastPlayedFixture = $this->lastPlayedFixture()->first();

        return $lastPlayedFixture
            ? $this->fixtures()->whereWeek($lastPlayedFixture->week + 1)->get()
            : $this->fixtures()->whereWeek(1)->get();
    }

    public function getUnplayedFixtures(): Collection
    {
        return $this->fixtures()->whereNotNull('played_at')->orderBy('week', 'desc')->get();
    }
}
