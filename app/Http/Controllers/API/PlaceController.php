<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceRequest;
use App\Http\Resources\PlaceResource;
use App\Http\Resources\TeamResource;
use App\Models\ImagesPlace;
use App\Models\Place;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PlaceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(PlaceRequest $request)
    {
        $files = $request->file('files');
        $user = Auth::user();
        $place = new Place();
        $place->name = $request->post('name');
        $place->description = $request->post('description');
        $place->address = $request->post('address');
        $place->user_id = $user->id;
        $place->save();
        if ($files) {
            foreach ($files as $file) {
                $filename = md5(Carbon::now().'_'.$file->getClientOriginalName()). '.' . $file->getClientOriginalExtension();
                $image = Image::make($file);
                Storage::put('public/images/place/'.$place->id.'/thumbnail/'.$filename, $image->fit(100, 100)->encode());
                Storage::put('public/images/place/'.$place->id.'/medium/'.$filename, $image->fit(500, 500)->encode());
                Storage::put('public/images/place/'.$place->id.'/large/'.$filename, $image->fit(1000, 1000)->encode());
                $imagesPlace = new ImagesPlace(['image' => $filename]);
                $place->images()->save($imagesPlace);
            }
        }
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
        $files = $request->file('files');
        $place = Place::find($id);
        $place->name = $request->post('name');
        $place->description = $request->post('description');
        $place->address = $request->post('address');
        $place->save();
        if ($files) {
            foreach ($files as $file) {
                $filename = md5(Carbon::now().'_'.$file->getClientOriginalName()). '.' . $file->getClientOriginalExtension();
                $image = Image::make($file);
                Storage::put('public/images/place/'.$place->id.'/thumbnail/'.$filename, $image->fit(100, 100)->encode());
                Storage::put('public/images/place/'.$place->id.'/medium/'.$filename, $image->fit(500, 500)->encode());
                Storage::put('public/images/place/'.$place->id.'/large/'.$filename, $image->fit(1000, 1000)->encode());
                $imagesPlace = new ImagesPlace(['image' => $filename]);
                $place->images()->save($imagesPlace);
            }
        }
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
    public function deleteImage($id)
    {
        $imagePlace = ImagesPlace::find($id);
        Storage::delete('public/images/place/'.$imagePlace->place_id.'/thumbnail/'.$imagePlace->image);
        Storage::delete('public/images/place/'.$imagePlace->place_id.'/medium/'.$imagePlace->image);
        Storage::delete('public/images/place/'.$imagePlace->place_id.'/large/'.$imagePlace->image);
        $imagePlace->delete();
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
        $place = Place::find($request->post('id'));
        return response()->json(new PlaceResource($place));
    }
}
