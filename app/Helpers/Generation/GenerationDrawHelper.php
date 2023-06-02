<?php

namespace App\Helpers\Generation;

class GenerationDrawHelper
{

    /**
     * @param array $teams
     * @param int $countGroup
     * @return array
     */

    public function generateGroupStage(array $teams, int $countGroup) :array
    {
        $count = 0;
        $groupStage = [];

        shuffle($teams);

        foreach ($teams as $team) {
            $count++;
            $groupStage[$count][] = $team;
            if ($count === $countGroup) {
                $count=0;
            }
        }
        return $groupStage ;
    }

    public function generateBaskets(array $teams, int $countGroup)
    {
        $count = 0;
        $numBasket = 1;
        $baskets = [];

        shuffle($teams);

        foreach ($teams as $team) {
            $count++;
            $baskets[$numBasket][$count] = $team;
            if ($count === $countGroup) {
                $count = 0;
                $numBasket++;
            }
        }
        return $baskets ;
    }
}
