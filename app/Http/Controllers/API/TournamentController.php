<?php

namespace App\Http\Controllers\API;

use App\Helpers\Discipline\DisciplineHelper;
use App\Helpers\Discipline\DisciplineStructure;
use App\Helpers\Generation\GenerationCalendarHelper;
use App\Helpers\Generation\GenerationDrawHelper;
use App\Helpers\Stage\StageHelper;
use App\Helpers\Stage\StageStructure;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\GroupTeamResource;
use App\Http\Resources\StageResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\TournamentResource;
use App\Http\Resources\TournamentStageResource;
use App\Models\Event;
use App\Models\Group;
use App\Models\Stage;
use App\Models\StageTeam;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
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
        $tournaments = Tournament::all();
        return response()->json(TournamentResource::collection($tournaments));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo(Request $request)
    {
        $tournament = Tournament::find($request->post('id'));
        return response()->json(new TournamentResource($tournament));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfoStages(Request $request)
    {
        $tournament = Tournament::with(['stages'])->find($request->post('id'));
        return response()->json(new TournamentStageResource($tournament));
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
        $stageId = $request->post('id');
        $stage = Stage::find($stageId);
        //здесь получить Stage и от него stageTeams
        $teamsId = $stageHelper->getTeamsId($stageId);
        $groups = $generationDrawHelper->generateGroupStage($teamsId, $stage->count_groups);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateCalendar(Request $request)
    {
        $tournament = Tournament::with(['teams'])->find($request->post('id'));
        $disciplineHelper = new DisciplineHelper($tournament->discipline);
        $calendar = $disciplineHelper->generateCalendar();
        dd($calendar);
        return response()->json(TeamResource::collection($groups));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveTournament(Request $request)
    {
        $user = Auth::user();
        $dataTournament = $request->post('tournament');
        $tournament = new Tournament();
        $tournament->name = $dataTournament['name'];
        $tournament->description = $dataTournament['description'];
        $tournament->public = $dataTournament['public'];
        $tournament->discipline = $dataTournament['discipline'];
        $tournament->type = $dataTournament['type'];
        $tournament->count_teams = $dataTournament['teamsCount'];
        $tournament->start = $dataTournament['start'];
        $tournament->end = $dataTournament['end'];
        $tournament->user_id = $user->id;
        $tournament->status = Tournament::STATUS_REGISTRAION_TEAMS;
        $tournament->save();
        $number = 0;
        foreach ($dataTournament['stages'] as $stage) {
            $tournament->stages()->create([
                'number' => ++$number,
                'name' => $stage['name'],
                'type' => $stage['type'],
                'count_group' => $stage['groupCount'],
                'count_games' => $stage['gamesCount'],
                'count_teams' => $stage['teamsAllowed'],
            ]);

        }
        return response()->json(['success' => true]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeamsReadyInvitation(Request $request)
    {
        $user = Auth::user();
        $tournamentId = $request->post('id');
        $teamsNotInTournament = Team::where('owner_id', $user->id)
            ->whereDoesntHave('tournaments', function ($query) use ($tournamentId) {
                $query->where('tournaments.id', $tournamentId);
            })->get();
        return response()->json(TeamResource::collection($teamsNotInTournament));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTeams(Request $request)
    {
        $tournament = Tournament::with(['tournamentTeams'])->find($request->post('id'));
        $number = ($tournament->tournamentTeams->isEmpty()) ? 0 : $tournament->tournamentTeams->max('number');;
        $teamsId = $request->post('teamsId');
        foreach ($teamsId as $teamId) {
            if ($tournament->count_teams === $number) {
                break;
            }
            $number++;
            TournamentTeam::create([
                'tournament_id' => $tournament->id,
                'team_id' => $teamId,
                'number' => $number
            ]);
        }
        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptTeams(Request $request)
    {
        $tournament = Tournament::with(['tournamentTeams', 'stages'])->find($request->post('id'));
        $firstStage = $tournament->stages->where('number', 1)->first();
        $tournament->status = Tournament::STATUS_ACCEPTED_TEAMS;
        $tournament->save();
        $number = 0;
        foreach ($tournament->tournamentTeams as $tournamentTeam) {
            $number++;
            StageTeam::create([
                'stage_id' => $firstStage->id,
                'team_id' => $tournamentTeam->team_id,
                'number' => $number
            ]);
        }
        return response()->json(['success' => true]);
    }



}
