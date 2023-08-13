<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playoff extends Model
{
    protected $fillable = [
        'team_win_play_off_id',
        'team_lost_play_off_id',
        'level',
        'number'
    ];
}
