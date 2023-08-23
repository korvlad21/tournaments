<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = [
        'number',
        'name',
        'type',
        'count_group',
        'count_teams',
        'count_games',
        'settings',
    ];

    public function groups(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function groupsTeams(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Group::class)->with(['teams']);
    }
}
