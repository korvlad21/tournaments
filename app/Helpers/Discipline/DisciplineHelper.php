<?php

namespace App\Helpers\Discipline;

class DisciplineHelper
{
    public const DISCIPLINE_FOOTBALL = 'football';
    public const DISCIPLINE_POKER = 'poker';
    public const DISCIPLINE_COUNTER_STRIKE = 'counter-strike';
    public const DISCIPLINE_DOTA = 'dota';
    public const DISCIPLINE_RACING = 'racing';
    public const DISCIPLINE_PAINTBALL = 'paintball';
    public const DISCIPLINE_TENNIS = 'tennis';
    public const DISCIPLINE_FIGHTING = 'fighting';

    public static $arrayHelpers = [
        self::DISCIPLINE_FOOTBALL => FootballHelper::class,
        self::DISCIPLINE_POKER => PokerHelper::class
    ];

    /**
     * @param string $type
     * @return mixed
     */
    public function getHelper(string $type)
    {
        return new self::$arrayHelpers[$type]();
    }

    /**
     * @param DisciplineInterface $discipline
     * @return mixed
     */

    public function getInfo(DisciplineInterface $discipline)
    {
        return $discipline->getInfo();
    }
}
