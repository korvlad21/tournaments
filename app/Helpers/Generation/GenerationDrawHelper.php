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

    public function generateDoubleElimination(array $teams) :array
    {
        $input2 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
        $result = $this->splitArray($input2);
        while(count($result) !== 1)
        {
            $result = $this->generatepar($result);
        }

        return $playOff ;
    }

    /**
     * @param array $playOff
     * @return array
     */
    protected function generateBottomPlayOff(array $playOff): array
    {
        krsort($playOff);
        $playOffBottom = [];
        foreach ($playOff as $stage => $games) {
            $numGames = count($games);

            for ($game = 1; $game <= $numGames/2; $game++) {
                $playOffBottom[$stage + 1][$game] = [null, null];
            }
        }

        return $playOffBottom;
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
                    $playOff[$stage][$numGame] = [($numGame-1)*2+1, 2*$numGame];
                }

            }

        }
        return $playOff ;
    }

//    public function generatePlayOffBracket2(array $teams) :array
//    {
//        $countTeams = count($teams);
//
//        $playOff = [];
//
//        $stage = 0;
//        $currentTeams = 1;
//
//        while($currentTeams < $countTeams) {
//            $stage++;
//            $currentTeams*=2;
//        }
//        for ($i = $stage; $i>=1; $i--) {
//            $game = 1;
//            $playOff[]
//            $
//        }
//        return $playOff ;
//    }

    function splitArray($array) {
        $length = count($array);
        $result = [];

        // Создание пар элементов
        for ($i = 0; $i < $length / 2; $i++) {
            $result[] = [$array[$i], $array[$length - $i - 1]];
        }

        return $result;
    }
    protected function generatepar($array){
        $newArray= [];
        $start = 0;
        $finish = count($array)-1;
        $k = true;
        while($start<count($array)/2)
        {
                $newArray[] = array_merge($array[$start], $array[$finish]);
                $start++;
                $finish--;
        }
        return $newArray;
    }


    /**
     * @param array $playOff
     * @param array $teams
     * @param int $stage
     * @param int $teamOnStage
     * @param int $countTeams
     * @return void
     */
    protected function generatePreLastStage(array &$playOff, array &$teams, int $stage, int $teamOnStage, int $countTeams)
    {
        $teamsOnThisStage = $countTeams - 2 * ($countTeams - $teamOnStage);
        $countGame = $teamOnStage / 2;
        $empty =
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

    protected function generateLastStage(array &$playOff, array &$teams, int $stage)
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
