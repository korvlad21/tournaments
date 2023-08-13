<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupTeam extends Model
{
    protected $fillable = [
        'group_id',
        'team_id',
        'number'
    ];
}
