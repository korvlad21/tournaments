<?php

namespace Database\Seeders;

use App\Helpers\Discipline\DisciplineHelper;
use App\Helpers\Stage\StageHelper;
use App\Models\StageTeam;
use App\Models\Tournament;
use App\Models\TournamentPlace;
use App\Models\TournamentTeam;
use Illuminate\Database\Seeder;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tournament = new Tournament();
        $tournament->name = 'Чемпионат России по футболу';
        $tournament->description = 'Развитие российского футбола началось с 1896 года, когда был официально утверждён устав «Клуба любителей спорта» (первой русской футбольной команды), сокращённо «КЛС», или, как его начали называть тогда — клуб «Спорт». 24 (12 по старому стилю) октября 1897 года в Петербурге состоялся первый футбольный матч между командами «Кружка любителей спорта» и «Василеостровского общества футболистов». Регламентированное время матча совпадало с современными правилами — полтора часа с одним перерывом. Встреча, проходившая на плацу Первого кадетского корпуса, закончилась со счётом 6:0 в пользу «василеостровцев». «Василеостровское общество футболистов» существовало к тому времени уже шесть лет, и состав его в подавляющем большинстве был представлен иностранными, прежде всего английскими, игроками[6]. Уже в начале 20 века в крупных городах российской империи — одна за другой — появляются футбольные лиги.';
        $tournament->public = Tournament::PUBLIC_OPEN;
        $tournament->discipline = DisciplineHelper::DISCIPLINE_FOOTBALL;
        $tournament->type = Tournament::TYPE_MAIN;
        $tournament->count_teams = 32;
        $tournament->start = date('Y-m-d', strtotime('+1 day'));
        $tournament->end = date('Y-m-d', strtotime('+9 day'));
        $tournament->user_id = 1;
        $tournament->status = Tournament::STATUS_ACCEPTED_TEAMS;
        $tournament->save();
        $stagesData = [
            ['number' => 1, 'name' => 'Групповой этап', 'type' => StageHelper::TYPE_ROUND_ROBIN, 'count_group' => 8, 'count_games' => 1, 'count_teams' => 32],
            ['number' => 2, 'name' => 'Плей-офф', 'type' => StageHelper::TYPE_SINGLE_ELIMINATION, 'count_group' => 1, 'count_games' => 1, 'count_teams' => 16],
        ];
        foreach ($stagesData as $stageData) {
            $tournament->stages()->create([
                'number' => $stageData['number'],
                'name' => $stageData['name'],
                'type' => $stageData['type'],
                'count_group' => $stageData['count_group'],
                'count_games' => $stageData['count_games'],
                'count_teams' => $stageData['count_teams'],
            ]);
        }

        $dataTournamentTeam = [];
        for($i=1; $i<33; $i++) {
            $dataTournamentTeam[] = [
                'tournament_id' => $tournament->id,
                'team_id' => $i,
                'number' => $i
            ];
            $stagesTeamData[] = [
                'stage_id' => 1,
                'team_id' => $i,
                'number' => $i
            ];
        }
        $dataTournamentPlace = [];
        for($i=1; $i<4; $i++) {
            $dataTournamentPlace[] = [
                'tournament_id' => $tournament->id,
                'place_id' => $i
            ];
        }

        TournamentTeam::insert($dataTournamentTeam);
        TournamentPlace::insert($dataTournamentPlace);
        StageTeam::insert($stagesTeamData);
    }
}
