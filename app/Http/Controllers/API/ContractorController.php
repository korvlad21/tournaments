<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractorRequest;
use App\Http\Resources\ContractorResource;
use App\Models\Contractor;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ContractorController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(ContractorRequest $request)
    {
        $user = Auth::user();
        $logo = $request->file('logo');
        $contractor = new Contractor();
        $contractor->INN = $request->post('INN');
        $contractor->KPP = $request->post('KPP');
        $contractor->name = $request->post('name');
        $contractor->field_of_activity = $request->post('field_of_activity');
        $contractor->description = $request->post('description');
        $contractor->contact = $request->post('contact');
        $contractor->user_id = $user->id;
        if ($logo) {
            $filename = md5(Carbon::now().'_'.$logo->getClientOriginalName()). '.' . $logo->getClientOriginalExtension();
            $image = Image::make($logo);
            Storage::put('public/images/contractor/logo/thumbnail/'.$filename, $image->fit(100, 100)->encode());
            Storage::put('public/images/contractor/logo/medium/'.$filename, $image->fit(500, 500)->encode());
            Storage::put('public/images/contractor/logo/large/'.$filename, $image->fit(1000, 1000)->encode());
            $contractor->logo = $filename;
        }
        $contractor->save();
        return response()->json([
            'success' => true
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContractorRequest $request, $id)
    {
        $logo = $request->file('logo');
        $contractor = Contractor::find($id);
        $contractor->INN = $request->post('INN');
        $contractor->KPP = $request->post('KPP');
        $contractor->name = $request->post('name');
        $contractor->field_of_activity = $request->post('field_of_activity');
        $contractor->description = $request->post('description');
        $contractor->contact = $request->post('contact');
//        if ($logo) {
//            $filename = md5(Carbon::now().'_'.$logo->getClientOriginalName()). '.' . $logo->getClientOriginalExtension();
//            $image = Image::make($logo);
//            Storage::put('public/images/team/logo/thumbnail/'.$filename, $image->fit(100, 100)->encode());
//            Storage::put('public/images/team/logo/medium/'.$filename, $image->fit(500, 500)->encode());
//            Storage::put('public/images/team/logo/large/'.$filename, $image->fit(1000, 1000)->encode());
//            $team->logo = $filename;
//        }
        $contractor->save();
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
        $contractor = Contractor::find($request->post('id'));
        return response()->json(new ContractorResource($contractor));
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
