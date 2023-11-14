<?php

namespace App\Http\Controllers\API;

use App\Helpers\Discipline\DisciplineHelper;
use App\Helpers\Generation\GenerationDrawHelper;
use App\Helpers\Stage\StageHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupTeamResource;
use App\Http\Resources\StageResource;
use App\Http\Resources\TeamResource;
use App\Models\Game;
use App\Models\Group;
use App\Models\Playoff;
use App\Models\Stage;
use Illuminate\Http\Request;

class StageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo(Request $request)
    {
        $stage = Stage::find($request->post('id'));
        return response()->json(new StageResource($stage));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeams(Request $request)
    {
        $stage = Stage::with(['teams'])->find($request->post('id'));
        return response()->json(TeamResource::collection($stage->teams->keyBy('id')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGroupsInfo(Request $request)
    {
        $groups = Group::with(['teams'])->where('stage_id' , $request->post('id'))->get();
        return response()->json(GroupTeamResource::collection($groups));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGamesInfo(Request $request)
    {
        $stage = Stage::find($request->post('id'));
        $groups = Group::with(['teams'])->where('stage_id' , $request->post('id'))->get()->pluck('id')->toArray();
        $games = [];
        if (StageHelper::TYPE_SINGLE_ELIMINATION === $stage->type) {
            $playoffs = Playoff::with(['group', 'team1', 'team2'])->whereIn('group_id' , $groups)->get();

            foreach ($playoffs as $playoff) {
                $games[$playoff->group_id]['Раунд '.$playoff->level][] = $playoff;
            }
            return response()->json($games);
        }
        $gamesModel = Game::with(['footballGame', 'group'])->whereIn('group_id' , $groups)->get();
        foreach ($gamesModel as $gameModel) {
            $games[$gameModel->group->number][] = $gameModel;
        }

        return response()->json($games);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateCalendar(Request $request)
    {
        $stage = Stage::with(['tournament','groupsTeamsId'])->find($request->post('id'));
        $disciplineHelper = new DisciplineHelper($stage->tournament->discipline);
        $generationHelper = new GenerationDrawHelper();
        foreach ($stage->groupsTeamsId as $group) {
            $teamsId = $group->groupTeams->pluck('team_id')->toArray();
            if (StageHelper::TYPE_SINGLE_ELIMINATION === $stage->type) {
                $calendar = $generationHelper->generatePlayoff($teamsId);
                $disciplineHelper->createCalendarPlayoff($calendar, $group->id);
            }
            else{
                $calendar = $disciplineHelper->generateCalendar($teamsId, $stage->count_games);
                $disciplineHelper->createCalendar($calendar, $group->id);
            }

        }
        return response()->json(['success' => true]);
    }

    public function generateGroups(Request $request)
    {
        $stageHelper = new StageHelper();
        $generationDrawHelper = new GenerationDrawHelper();
        $stageId = $request->post('id');
        $stage = Stage::find($stageId);
        //здесь получить Stage и от него stageTeams
        $teamsId = $stageHelper->getTeamsId($stageId);
        $groups = $generationDrawHelper->generateGroupStage($teamsId, $stage->count_group);
        foreach ($groups as $numberGroup => $teams_id) {
            $group = new Group();
            $group->stage_id = $stageId;
            $group->number = $numberGroup;
            $group->save();
            foreach ($teams_id as $numberTeam => $team_id) {
                $group->groupTeams()->create([
                    'team_id' => $team_id,
                    'number' => $numberTeam,
                ]);
            }
        }
        return response()->json(['success' => true]);
    }

}
