<?php

namespace App\Http\Controllers\API;

use App\Helpers\Discipline\DisciplineStructure;
use App\Helpers\Generation\GenerationCalendarHelper;
use App\Helpers\Generation\GenerationDrawHelper;
use App\Helpers\Stage\StageHelper;
use App\Helpers\Stage\StageStructure;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\GroupTeamResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\TournamentResource;
use App\Models\Event;
use App\Models\Group;
use App\Models\Stage;
use App\Models\StageTeam;
use App\Models\Tournament;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class TournamentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(EventRequest $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EventRequest $request, $id)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDisciplineOptions()
    {
        $disciplineStructure = new DisciplineStructure();
        $disciplines = $disciplineStructure->getDisciplines();
        $disciplineOptions = array_map(function($slug, $name) {
            return [
                'slug' => $slug,
                'name' => $name
            ];
        }, array_keys($disciplines),$disciplines);
        return response()->json([
            'success'=> true,
            'disciplineOptions' => $disciplineOptions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTypeStageOptions()
    {
        $stageStructure = new StageStructure();
        $typeStages = $stageStructure->getTypeStages();
        $typeStageOptions = array_map(function($slug, $name) {
            return [
                'slug' => $slug,
                'name' => $name
            ];
        }, array_keys($typeStages),$typeStages);
        return response()->json([
            'success'=> true,
            'typeStageOptions' => $typeStageOptions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllInfo(Request $request)
    {
        $user = Auth::user();
        $teams = Tournament::all();
        return response()->json(TournamentResource::collection($teams));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo(Request $request)
    {
        $team = Tournament::find($request->post('id'));
        return response()->json(new TournamentResource($team));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeams(Request $request)
    {
        $tournament = Tournament::with(['teams'])->find($request->post('id'));
        return response()->json(TeamResource::collection($tournament->teams->keyBy('id')));
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
    public function generateGroups(Request $request)
    {
        $stageHelper = new StageHelper();
        $generationDrawHelper = new GenerationDrawHelper();
        $stageId = $request->post('stage_id');
        //здесь получить Stage и от него stageTeams
        $teamsId = $stageHelper->getTeamsId($stageId);
        $groups = $generationDrawHelper->generateGroupStage($teamsId, 4);
        $groupTeams = [];
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
        return response()->json(TeamResource::collection($groups));
    }


}
