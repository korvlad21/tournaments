<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo(Request $request)
    {
        $slug = $request->post('slug');
        $user = User::where('slug', $slug)->first();
        return response()->json(new UserResource($user));
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function isAuthUser(Request $request)
    {
        $user = Auth::user();
        $slug = $request->post('slug');
        return response()->json([
            'success'=> true,
            'isAuthUser' => $user->slug === $slug
        ]);
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoles(Request $request)
    {
        return response()->json([
            'success' => true,
            'roles' => Auth::user()->roles()->pluck('slug')->toArray(),
        ]);
    }
}
