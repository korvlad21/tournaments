<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentTeam extends Model
{
    protected $fillable = [
        'tournament_id',
        'team_id',
        'number'
    ];
}
