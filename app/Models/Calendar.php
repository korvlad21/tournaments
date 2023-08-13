<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = [
        'group_id',
        'place_id',
        'playoff_id',
        'number',
        'number_tour',
        'date_game',
        'team1_id',
        'team2_id'
    ];
}
