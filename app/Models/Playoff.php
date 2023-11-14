<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Playoff extends Model
{
    protected $fillable = [
        'team1_win_play_off_id',
        'team2_win_play_off_id',
        'team1_exist',
        'team2_exist',
        'level',
        'number',
        'game_id',
        'group_id',
    ];

    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function team1(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Team::class, 'id', 'team1_win_play_off_id');
    }
    public function team2(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Team::class, 'id', 'team2_win_play_off_id');
    }
}
