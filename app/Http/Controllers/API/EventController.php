<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class EventController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(EventRequest $request)
    {
        $user = Auth::user();
        $logo = $request->file('logo');
        $event = new Event();
        $event->name = $request->post('name');
        $event->description = $request->post('description');
        $event->start = $request->post('start');
        $event->end= $request->post('end');

        $event->contractor_id = $request->post('contractor_id');
        $event->user_id = $user->id;
//        if ($logo) {
//            $filename = md5(Carbon::now().'_'.$logo->getClientOriginalName()). '.' . $logo->getClientOriginalExtension();
//            $image = Image::make($logo);
//            Storage::put('public/images/event/logo/thumbnail/'.$filename, $image->fit(100, 100)->encode());
//            Storage::put('public/images/event/logo/medium/'.$filename, $image->fit(500, 500)->encode());
//            Storage::put('public/images/event/logo/large/'.$filename, $image->fit(1000, 1000)->encode());
//            $event->logo = $filename;
//        }
        $event->save();
        return response()->json([
            'success' => true
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EventRequest $request, $id)
    {
        $logo = $request->file('logo');
        $event = Event::find($id);
        $event->name = $request->post('name');
        $event->description = $request->post('description');
        $event->start = $request->post('start');
        $event->end= $request->post('end');

        $event->contractor_id = $request->post('contractor_id');
//        if ($logo) {
//            $filename = md5(Carbon::now().'_'.$logo->getClientOriginalName()). '.' . $logo->getClientOriginalExtension();
//            $image = Image::make($logo);
//            Storage::put('public/images/event/logo/thumbnail/'.$filename, $image->fit(100, 100)->encode());
//            Storage::put('public/images/event/logo/medium/'.$filename, $image->fit(500, 500)->encode());
//            Storage::put('public/images/event/logo/large/'.$filename, $image->fit(1000, 1000)->encode());
//            $event->logo = $filename;
//        }
        $event->save();
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
        $event = Event::find($request->post('id'));
        return response()->json(new EventResource($event));
    }
}
