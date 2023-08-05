<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationTeam extends Model
{

    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_WAIT = 'wait';
    public const STATUS_REJECT = 'reject';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'owner_id',
        'team_id',
        'user_id',
        'status',
    ];
}
