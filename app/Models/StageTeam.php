<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StageTeam extends Model
{
    protected $fillable = [
        'stage_id',
        'team_id',
        'number',
    ];
}
