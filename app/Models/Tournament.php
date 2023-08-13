<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tournament extends Model
{
    use SoftDeletes;

    public const PUBLIC_OPEN = 'open';
    public const PUBLIC_CLOSED = 'closed';
    public const TYPE_MAIN = 'Mmain';
    public const TYPE_QUALIFYING = 'qualifying';

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
        return $this->hasMany(Stage::class);
    }
}
