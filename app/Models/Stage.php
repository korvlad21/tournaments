<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = [
        'number',
        'name',
        'type',
        'count_group',
        'count_teams',
        'settings',
    ];
}
