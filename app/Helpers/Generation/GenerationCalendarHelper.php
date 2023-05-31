<?php

namespace App\Helpers\Generation;

class GenerationCalendarHelper
{
    public const HOME = 'home';
    public const AWAY = 'away';
    public function getOneLeague(array $teams, int $rounds)
    {
        shuffle($teams);
// Проверка, является ли количество команд четным или нечетным
        if (count($teams) % 2 == 1) {
            // Количество команд нечетное, добавляем фиктивную команду
            $teams[] = "Фиктивная команда";
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

                $matches[$match] = array("Домашняя команда" => $teams[$home], "Гостевая команда" => $teams[$away]);
            }
            $rounds[$round] = $matches;
        }

        // Вывод календар
        return $rounds ;
    }
}
