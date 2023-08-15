<?php

namespace App\Helpers\Stage;

use App\Helpers\Discipline\DisciplineInterface;
use App\Models\StageTeam;

class StageHelper
{
    public const TYPE_ROUND_ROBIN = 'round_robin';
    public const TYPE_SWITZERLAND_SYSTEM = 'switzerland_system';
    public const TYPE_SINGLE_ELIMINATION = 'single_elimination';
    public const TYPE_DOUBLE_ELIMINATION = 'double_elimination';

    public function getTeamsId(int $stageId): array
    {
        return StageTeam::where('stage_id', $stageId)->pluck('team_id')->toArray();
    }
}
