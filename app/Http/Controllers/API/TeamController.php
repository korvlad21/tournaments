<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class TeamController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(TeamRequest $request)
    {
        $user = Auth::user();
        $logo = $request->file('logo');
        $team = new Team();
        $team->name = $request->post('name');
        $team->description = $request->post('description');
        $team->owner_id = $user->id;
        if ($logo) {
            $filename = md5(Carbon::now().'_'.$logo->getClientOriginalName()). '.' . $logo->getClientOriginalExtension();
            $image = Image::make($logo);
            Storage::put('public/images/team/logo/thumbnail/'.$filename, $image->fit(100, 100)->encode());
            Storage::put('public/images/team/logo/medium/'.$filename, $image->fit(500, 500)->encode());
            Storage::put('public/images/team/logo/large/'.$filename, $image->fit(1000, 1000)->encode());
            $team->logo = $filename;
        }
        $team->save();
        return response()->json([
            'success' => true
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TeamRequest $request, $id)
    {
        $user = Auth::user();
        $logo = $request->file('logo');
        $team = Team::find($id);
        if ($user->id !== $team->owner_id) {
            return response()->json([
                'success' => false
            ]);
        }
        $team->name = $request->post('name');
        $team->description = $request->post('description');
//        if ($logo) {
//            $filename = md5(Carbon::now().'_'.$logo->getClientOriginalName()). '.' . $logo->getClientOriginalExtension();
//            $image = Image::make($logo);
//            Storage::put('public/images/team/logo/thumbnail/'.$filename, $image->fit(100, 100)->encode());
//            Storage::put('public/images/team/logo/medium/'.$filename, $image->fit(500, 500)->encode());
//            Storage::put('public/images/team/logo/large/'.$filename, $image->fit(1000, 1000)->encode());
//            $team->logo = $filename;
//        }
        $team->save();
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
        $team = Team::find($request->post('id'));
        return response()->json(new TeamResource($team));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function isOwn(Request $request)
    {
        $team = Team::find($request->post('id'));
        $user = Auth::user();
        return response()->json([
            'success'=> true,
            'isOwn' => $user->id === $team->owner_id
        ]);
    }
}
