<?php

namespace App\Helpers\Discipline;

use App\Helpers\Generation\GenerationCalendarHelper;
use App\Models\Game;

class FootballHelper implements DisciplineInterface
{


    public function getInfo()
    {
        dd(2);
    }

    public function generateCalendar(array $teams, int $count_games): array
    {
        $generationCalendarHelper = new GenerationCalendarHelper();
        return $generationCalendarHelper->generateOneLeague($teams, $count_games);
    }

    public function createCalendar(array $calendar, int $groupId): void
    {
        $number = $tour = 0;
        foreach ($calendar as $games) {
            $tour++;
            foreach ($games as $game) {
                Game::create([
                    'group_id' => $groupId,
                    'number' => $number++,
                    'tour' => $tour,
                    'date_game' => date('Y-m-d')
                ])->footballGame()->create([
                    'team1_id' => $game[GenerationCalendarHelper::HOME],
                    'team2_id' => $game[GenerationCalendarHelper::AWAY],
                ]);
            }
        }
    }
}
