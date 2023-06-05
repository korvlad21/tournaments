<?php

namespace App\Helpers\Discipline;

class DisciplineStructure
{
    public static $array_discliplines = [
        DisciplineHelper::DISCIPLINE_FOOTBALL => 'Футбол',
        DisciplineHelper::DISCIPLINE_POKER => 'Покер',
        DisciplineHelper::DISCIPLINE_COUNTER_STRIKE => 'Counter-Strike',
        DisciplineHelper::DISCIPLINE_DOTA => 'Dota',
        DisciplineHelper::DISCIPLINE_RACING => 'Гонки',
        DisciplineHelper::DISCIPLINE_PAINTBALL => 'Пейнтбол',
        DisciplineHelper::DISCIPLINE_TENNIS => 'Теннис',
        DisciplineHelper::DISCIPLINE_FIGHTING => 'Единаборства',
    ];

    /**
     * @return mixed
     */
    public function getDisciplines()
    {
        return self::$array_discliplines;
    }
}
