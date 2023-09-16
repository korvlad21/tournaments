<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function stageTeams()
    {
        return $this->hasMany(StageTeam::class);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'stage_teams')
            ->using(StageTeam::class)
            ->withPivot('number');
    }

    public function groups(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function groupsTeams(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Group::class)->with(['teams']);
    }

    public function groupsTeamsId(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Group::class)->with(['groupTeams']);
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
