<?php

namespace App\Http\Controllers\API;

use App\Helpers\Discipline\DisciplineStructure;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
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

}
