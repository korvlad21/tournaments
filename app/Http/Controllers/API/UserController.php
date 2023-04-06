<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo(Request $request)
    {
        $slug = $request->post('slug');
        $user = User::where('slug', $slug)->first();
        return response()->json(new UserResource($user));
    }

    /**
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoles(Request $request)
    {
        return response()->json([
            'success' => true,
            'roles' => Auth::user()->roles()->pluck('slug')->toArray(),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFriends(Request $request)
    {
        $user = Auth::user();
        $profile = User::where('slug', $request->post('slug'))->first();
        $friends = Friend::where(
            [['subscriber_id', $user->id], ['subscription_id', $profile->id]]
        )->whereOr(
            [['subscriber_id', $profile->id], ['subscription_id', $user->id]]
        )->get();
        return response()->json([
            'success' => true,
            'subscriber' => ($friends->where('subscriber_id', $user->id)->first()) ? true : false,
            'subscription' => ($friends->where('subscription_id', $user->id)->first()) ? true : false,
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function isSubscribe(Request $request)
    {
        $user = Auth::user();
        $profile = User::where('slug', $request->post('slug'))->first();
        $isSubscribe = Friend::where(
            [['subscriber_id', $profile->id], ['subscription_id', $user->id]]
        )->first();
        if ($isSubscribe) {
            $isSubscribe->delete();
            $subscription = false;
        }
        else{
            Friend::create(['subscriber_id' => $profile->id, 'subscription_id' => $user->id]);
            $subscription = true;
        }
        return response()->json([
            'success' => true,
            'subscription' => $subscription,
        ]);
    }
}
