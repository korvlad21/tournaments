<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentPlace extends Model
{
    protected $fillable = [
        'tournament_id',
        'place_id'
    ];
}
