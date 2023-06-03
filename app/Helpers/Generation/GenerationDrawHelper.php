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

    /**
     * @param array $teams
     * @param int $countGroup
     * @return array
     */

    public function generatePlayOffBracket(array $teams) :array
    {
        $teamOnStage = 1;

        $stage = 0;

        $countTeams = count($teams);

        $playOff = [];

        while($teamOnStage < $countTeams) {
            $stage++;
            $teamOnStage*=2;
            if (2 * $teamOnStage > $countTeams) {
                $this->generatePreLastStage($playOff, $teams, $stage,  $teamOnStage, $countTeams);
                $this->generateLastStage($playOff, $teams, $stage+1);
                break;
            }
            else {
                $numGame = 0;
                for($i=1; $i<=$teamOnStage; $i+=2) {
                    $numGame++;
                    $playOff[$stage][$numGame] = [null, null];
                }

            }

        }
        return $playOff ;
    }

    /**
     * @param array $playOff
     * @param array $teams
     * @param int $stage
     * @param int $teamOnStage
     * @param int $countTeams
     * @return void
     */
    public function generatePreLastStage(array &$playOff, array &$teams, int $stage, int $teamOnStage, int $countTeams)
    {
        $teamsOnThisStage = $countTeams - 2 * ($countTeams - $teamOnStage);
        $countGame = $teamOnStage / 2;
        $num = 0;
        $numTotal = 0;
        foreach ($teams as $key => $team) {
            $num++;
            if ($num + $numTotal > $teamsOnThisStage) {
                break;
            }
            if (0 === $num % 2) {
                $playOff[$stage][2+$countGame-$num][] = $team;
            }
            else{
                $playOff[$stage][$num][] = $team;
            }
            unset($teams[$key]);
            if($num === $countGame) {
                $numTotal = $num;
                $num = 0;
            }
        }
    }

    public function generateLastStage(array &$playOff, array &$teams, int $stage)
    {
        $teamsOnThisStage = count($teams);
        $countGame = $teamsOnThisStage / 2;
        $num = 0;
        $numTotal = 0;
        foreach ($teams as $key => $team) {
            $num++;
            if ($num + $numTotal > $teamsOnThisStage) {
                break;
            }
            $playOff[$stage][$num][] = $team;
            unset($teams[$key]);
            if($num === $countGame) {
                $numTotal = $num;
                $num = 0;
            }
        }

    }

    /**
     * @param array $teams
     * @param int $countGroup
     * @return array
     */

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
