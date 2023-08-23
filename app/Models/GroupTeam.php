<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupTeam extends Pivot
{
    protected $table = 'group_teams';
    protected $fillable = [
        'group_id',
        'team_id',
        'number'
    ];
}
