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
        $groups = Game::with(['teams'])->where('stage_id' , $request->post('id'))->get();
        return response()->json(GroupTeamResource::collection($groups));
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
        foreach ($stage->groupsTeamsId as $group) {
            $teamsId = $group->groupTeams->pluck('team_id')->toArray();
            $calendar = $disciplineHelper->generateCalendar($teamsId, $stage->count_games);
            $disciplineHelper->createCalendar($calendar, $group->id);
        }
        return response()->json(['success' => true]);
    }

}
