<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class StageTeam extends Pivot
{

    protected $table = 'stage_teams';
    protected $fillable = [
        'stage_id',
        'team_id',
        'number',
    ];
}
