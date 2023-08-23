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
        $number = 1;
        $groupStage = [];

        shuffle($teams);

        foreach ($teams as $team) {
            $count++;
            $groupStage[$count][$number] = $team;
            if ($count === $countGroup) {
                $count=0;
                $number++;
            }
        }
        return $groupStage ;
    }


    /**
     * @param array $teams
     * @return array
     */

    public function generateDoubleElimination(array $teams) :array
    {
        $playOff[1] = $this->generatePlayoff($teams);
        $playOff[2] = $this->bottomDoubleElimination($playOff[1]);
        return $playOff ;
    }

    /**
     * @param array $playOff
     * @return array
     */
    protected function bottomDoubleElimination(array $playOff): array
    {
        $playOffTopLoser = $this->getTopLosersDoubleElimination($playOff);

        $playOffBottom = [];

        foreach ($playOff as $key => $games) {
            $stage = $key;
            $currentStage = 2 * ($stage - 1);
            break;
        }

        $numGame = 0;
        for ($i = 0; $i < count($playOffTopLoser[$stage]); $i+=2) {
            $numGame++;
            $playOffBottom[$currentStage][$numGame] = [$playOffTopLoser[$stage][$i], $playOffTopLoser[$stage][$i+1]];
        }
        $countGames = count($playOffBottom[$currentStage]);
        $currentStage--;
        $existLoser = true;

        while ($currentStage > 0) {
            $numGame = 0;
            if ($existLoser) {
                for ($i = 0; $i < $countGames; $i++) {
                    $numGame++;
                    $playOffBottom[$currentStage][$numGame] = ['T'.$numGame, 'B'.$numGame];
                }
                $countGames/=2;
            }
            else {
                for ($i = 0; $i < $countGames*2; $i+=2) {
                    $numGame++;
                    $playOffBottom[$currentStage][$numGame] = ['B'.$i+1, 'B'.$i+2];
                }
            }
            $existLoser = !$existLoser;
            $currentStage--;
        }
        return $playOffBottom;
    }

    /**
     * @param array $playOff
     * @return array
     */
    protected function getTopLosersDoubleElimination(array $playOff): array
    {
        $playOffLoser = [];
        foreach ($playOff as $stage => $games) {
            foreach ($games as $numGame => $game) {
                $playOffLoser[$stage][] = (in_array(null, $game)) ? null : 'T'.$numGame;
            }
        }

        return $playOffLoser;
    }
    /**
     * @param array $teams
     * @param int $countGroup
     * @return array
     */

    public function generatePlayoff(array $teams) :array
    {
        $startStagePlayOff = $this->getStartStagePlayOff($teams);
        $result = $this->splitArray($teams);
        while(count($result) !== 1)
        {
            $result = $this->generatePar($result);
        }

        return $this->buldingPlayOffBracket($result[0], $startStagePlayOff);
    }

    /**
     * @param array $teams
     * @return int
     */
    protected function getStartStagePlayOff(array &$teams): int {
        $countTeams = count($teams);
        $stageCountTeams = 0;
        $teamsOnStage = 1;
        while ($teamsOnStage < $countTeams) {
            $stageCountTeams++;
            $teamsOnStage*=2;
        }
        for ($i = 0; $i < $teamsOnStage - $countTeams; $i++) {
            $teams[] = null;
        }
        return $stageCountTeams;
    }

    /**
     * @param array $result
     * @param int $startStagePlayOff
     * @return array
     */
    protected function buldingPlayOffBracket(array $teams, int $stage): array {
        $playOff = [];
        $countTeams = count($teams);
        if (2 === $countTeams) {
            return [1 => $teams];
        }
        $numGame = 0;
        for ($i=0; $i<$countTeams; $i+=2) {
            $numGame++;
            $playOff[$stage][$numGame] = [$teams[$i], $teams[$i+1]];
        }

        $stage--;

        $numGame = 0;
        for ($i=1; $i<=count($playOff[$stage+1]); $i+=2) {
            $numGame++;
            $playOff[$stage][$numGame] = [
                (null === $playOff[$stage+1][$i][1]) ? $playOff[$stage+1][$i][0] : $i,
                (null === $playOff[$stage+1][$i+1][1]) ? $playOff[$stage+1][$i+1][0] : $i+1,];
        }

        $stage--;

        while (0 < $stage) {
            $numGame = 0;
            for ($i=1; $i<=count($playOff[$stage+1]); $i+=2) {
                $numGame++;
                $playOff[$stage][$numGame] = [$i, $i+1];
            }
            $stage--;
        }
        return $playOff;
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
            if ($num === $countGame) {
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
