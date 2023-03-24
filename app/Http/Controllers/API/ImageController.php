<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatarUpload(Request $request)
    {
        $avatar = $request->file('avatar');
        dd($avatar);
        $slug = $request->post('slug');
        $user = User::where('slug', $slug)->first();

        return response()->json(new UserResource($user));
    }
}
