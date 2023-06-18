<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceRequest;
use App\Http\Resources\PlaceResource;
use App\Http\Resources\TeamResource;
use App\Models\Place;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(PlaceRequest $request)
    {
        $user = Auth::user();
        $place = new Place();
        $place->name = $request->post('name');
        $place->description = $request->post('description');
        $place->address = $request->post('address');
        $place->user_id = $user->id;
        $place->save();
        return response()->json([
            'success' => true
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PlaceRequest $request, $id)
    {
        $place = Place::find($id);
        $place->name = $request->post('name');
        $place->description = $request->post('description');
        $place->address = $request->post('address');
        $place->save();
        return response()->json([
            'success' => true
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $place = Place::find($id);
        $place->delete();
        return response()->json([
            'success' => true
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo(Request $request)
    {
        $team = Place::find($request->post('id'));
        return response()->json(new PlaceResource($team));
    }
}
