<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tournament extends Model
{
    use SoftDeletes;

    public const PUBLIC_OPEN = 'open';
    public const PUBLIC_CLOSED = 'closed';
    public const TYPE_MAIN = 'main';
    public const TYPE_QUALIFYING = 'qualifying';

    public const STATUS_ACCEPTED_TEAMS = 'accepted_teams';
    public const STATUS_REGISTRAION_TEAMS = 'registration_teams';

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'description',
        'public',
        'discipline',
        'type',
        'status',
        'count_teams',
        'start',
        'end',
    ];

    public function stages()
    {
        return $this->hasMany(Stage::class)->with(['stageTeams']);
    }
    public function tournamentTeams()
    {
        return $this->hasMany(TournamentTeam::class);
    }
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'tournament_teams')
            ->using(TournamentTeam::class)
            ->withPivot('number');
    }

}
