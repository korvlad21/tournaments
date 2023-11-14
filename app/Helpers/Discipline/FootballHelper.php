<?php

namespace App\Helpers\Discipline;

use App\Helpers\Generation\GenerationCalendarHelper;
use App\Models\Game;
use App\Models\Playoff;
use Illuminate\Support\Facades\DB;

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

    public function createCalendarPlayoff(array $calendar, int $groupId): void
    {
        DB::beginTransaction();

        try {
            $firstStage = true;
            $tour = 0;
            foreach ($calendar as $level => $games) {
                foreach ($games as $number => $teams) {
                    $exist1 = $exist2 = true;
                    if ('string' === gettype($teams[0])){
                        $teams[0] = (int)str_replace('n','',$teams[0]);
                        $exist1 = false;
                    }
                    if ('string' === gettype($teams[1])){
                        $teams[1] = (int)str_replace('n','',$teams[1]);
                        $exist2 = false;
                    }
                    $tour++;
                    $game = Game::create([
                        'group_id' => $groupId,
                        'number' => $number,
                        'tour' => $tour,
                        'date_game' => date('Y-m-d'),
                    ])->footballGame()->create([
                        'team1_id' => $teams[0],
                        'team2_id' => $teams[1],
                    ]);
                    Playoff::create([
                        'team1_win_play_off_id' => $teams[0],
                        'team2_win_play_off_id' => $teams[1],
                        'team1_exist' => $exist1,
                        'team2_exist' => $exist2,
                        'level' => $level,
                        'number' => $number,
                        'game_id' => $game->id,
                        'group_id' => $groupId
                    ]);
                }

                if ($firstStage) {
                    $firstStage = false;
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            // Если произошла ошибка, откатываем транзакцию
            DB::rollback();
            throw $e; // Можно обработать исключение или просто выбросить его дальше
        }
    }


}
