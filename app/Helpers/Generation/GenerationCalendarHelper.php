<?php

namespace App\Helpers\Generation;

class GenerationCalendarHelper
{
    public const HOME = 'home';
    public const AWAY = 'away';

    /**
     * @param array $teams
     * @param int $rounds
     * @return array
     */
    public function generateOneLeague(array $teams, int $rounds) : array
    {
        shuffle($teams);
// Проверка, является ли количество команд четным или нечетным
        if (count($teams) % 2 == 1) {
            // Количество команд нечетное, добавляем фиктивную команду
            $teams[] = "-";
        }

        $numTeams = count($teams);
        $numRounds = $rounds * (count($teams) - 1); // Количество кругов
        $numMatchesPerRound = $numTeams / 2;

        $rounds = array();

        for ($round = 0; $round < $numRounds; $round++) {
            $matches = array();
            for ($match = 0; $match < $numMatchesPerRound; $match++) {
                $home = ($round + $match) % ($numTeams - 1);
                $away = ($numTeams - 1 - $match + $round) % ($numTeams - 1);

                // Учет фиктивной команды
                if ($match == 0) {
                    $away = $numTeams - 1;
                }

                if ($round % 2 == 1) {
                    // Если раунд нечетный, меняем местами домашнюю и гостевую команды
                    $temp = $home;
                    $home = $away;
                    $away = $temp;
                }

                $matches[$match] = array(self::HOME => $teams[$home], self::AWAY => $teams[$away]);
            }
            $rounds[$round] = $matches;
        }

        // Вывод календар
        return $rounds ;
    }
}
