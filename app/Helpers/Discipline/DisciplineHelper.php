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
     * @var DisciplineInterface
     */
    protected DisciplineInterface $helperInstance;

    public function __construct(string $discipline)
    {
        $helperClass = self::$arrayHelpers[$discipline] ?? null;

        if ($helperClass && is_subclass_of($helperClass, DisciplineInterface::class)) {
            $this->helperInstance = new $helperClass();
        } else {
            throw new \InvalidArgumentException('Invalid discipline or helper not found.');
        }
    }


    /**
     * @param string $type
     * @return mixed
     */
    public function getHelper(string $type)
    {
        return new self::$arrayHelpers[$type]();
    }

    /**
     * @return mixed
     */

    public function getInfo()
    {
        return $this->helperInstance->getInfo();
    }

    public function generateCalendar(array $teams, int $count_games): array
    {
        return $this->helperInstance->generateCalendar($teams, $count_games);
    }

    public function createCalendar(array $calendar, int $groupId): void
    {
        $this->helperInstance->createCalendar($calendar, $groupId);
    }
}
