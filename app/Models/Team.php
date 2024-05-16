<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'attack_rating',
        'midfield_rating',
        'defence_rating',
    ];
}
