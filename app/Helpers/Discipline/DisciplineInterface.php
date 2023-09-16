<?php

namespace App\Helpers\Discipline;

interface DisciplineInterface
{
    public function getInfo();
    public function generateCalendar(array $teams, int $countGame):array;
}
