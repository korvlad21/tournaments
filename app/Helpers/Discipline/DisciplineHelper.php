<?php

namespace App\Helpers\Discipline;

class DisciplineHelper
{
    public const DISCIPLINE_FOOTBALL = 'football';
    public const DISCIPLINE_POKER = 'poker';

    public static $arrayHelpers = [
        self::DISCIPLINE_FOOTBALL => FootballHelper::class,
        self::DISCIPLINE_POKER => PokerHelper::class
    ];

    public function getHelper(string $type)
    {
        return new self::$arrayHelpers[$type]();
    }

    public function getInfo(DisciplineInterface $discipline)
    {
        return $discipline->getInfo();
    }
}
