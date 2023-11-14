<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    protected $fillable = [
        'id',
        'group_id',
        'date_game',
        'number',
        'tour',
    ];

    public function footballGame(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(FootballGame::class)->with(['team1', 'team2']);
    }

    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
