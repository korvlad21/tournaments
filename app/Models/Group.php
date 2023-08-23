<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    protected $fillable = [
        'stage_id',
        'number'
    ];

    public function groupTeams()
    {
        return $this->hasMany(GroupTeam::class);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'group_teams')
            ->using(GroupTeam::class)
            ->withPivot('number');
    }
}
