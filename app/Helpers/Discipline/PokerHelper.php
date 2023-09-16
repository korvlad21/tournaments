<?php

namespace App\Helpers\Discipline;

use App\Helpers\Generation\GenerationCalendarHelper;

class PokerHelper implements DisciplineInterface
{
    public function getInfo()
    {
        dd(3);
    }

    public function generateCalendar(array $teams, int $count_games): array
    {

    }

    public function createCalendar(array $calendar, int $groupId): void
    {

    }
}
