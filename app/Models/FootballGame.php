<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballGame extends Model
{
    protected $fillable = [
        'game_id',
        'team1_id',
        'team2_id',
        'score1',
        'score2',
        'status',
    ];
}
