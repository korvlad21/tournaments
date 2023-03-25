<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatarUpload(Request $request)
    {
        $slug = $request->post('slug');
        $user = User::where('slug', $slug)->first();
        $oldAvatar = $user->avatar;
        $avatar = $request->file('avatar');
        $filename = md5(Carbon::now().'_'.$avatar->getClientOriginalName()). '.' . $avatar->getClientOriginalExtension();
        $image = Image::make($avatar);
        Storage::put('public/images/thumbnail/'.$filename, $image->fit(100, 100)->encode());
        Storage::put('public/images/medium/'.$filename, $image->fit(500, 500)->encode());
        Storage::put('public/images/large/'.$filename, $image->fit(1000, 1000)->encode());
        $user->avatar = $filename;
        $user->save();
        if ($oldAvatar) {
            Storage::delete('public/images/thumbnail/'.$oldAvatar);
            Storage::delete('public/images/medium/'.$oldAvatar);
            Storage::delete('public/images/large/'.$oldAvatar);
        }
        $path = '/storage/images/thumbnail/'.$filename;
        return response()->json([
            'path' => $path
        ]);
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvatar(Request $request)
    {
        $slug = $request->post('slug');
        $user = User::where('slug', $slug)->first();
        $path = ($user->avatar) ? '/storage/images/thumbnail/'.$user->avatar : '';
        return response()->json([
            'path' => $path
        ]);
    }
}
