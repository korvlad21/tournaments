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

    public function team1(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Team::class, 'id', 'team1_id');
    }
    public function team2(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Team::class, 'id', 'team2_id');
    }
}
