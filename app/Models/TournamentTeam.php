<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TournamentTeam extends Pivot
{
    protected $table = 'tournament_teams';

    protected $fillable = [
        'tournament_id',
        'team_id',
        'number'
    ];
}
