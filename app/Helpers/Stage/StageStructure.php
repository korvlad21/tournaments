<?php

namespace App\Helpers\Stage;

class StageStructure
{
    public static $type_stages = [
        StageHelper::TYPE_ROUND_ROBIN => 'Круговая (Раунд Робин)',
        StageHelper::TYPE_SWITZERLAND_SYSTEM => 'Швейцарская система',
        StageHelper::TYPE_SINGLE_ELIMINATION => 'Single elimination',
        StageHelper::TYPE_DOUBLE_ELIMINATION => 'Double elimination',
    ];

    /**
     * @return mixed
     */
    public function getTypeStages()
    {
        return self::$type_stages;
    }
}
