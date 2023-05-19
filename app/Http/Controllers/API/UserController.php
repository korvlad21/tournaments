<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $profile = User::where('slug', $request->post('slug'))->first();
        $users = User::whereHas('subscribers', function ($query) use ($profile) {
            $query->where('subscriber_id', $profile->id);
        })->whereHas('subscriptions', function ($query) use ($profile) {
            $query->where('subscription_id', $profile->id);
        })->get();
        return response()->json([
            'success' => true,
            'friends' => UserResource::collection($users),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function isFriend(Request $request)
    {
        $user = Auth::user();
        $profile = User::where('slug', $request->post('slug'))->first();
        $friends = Friend::where(
            [['subscriber_id', '=', $user->id], ['subscription_id', '=', $profile->id]]
        )->orWhere(
            [['subscriber_id', '=', $profile->id], ['subscription_id', '=', $user->id]]
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

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $rules
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $slug)
    {
        $userData = $request->post('user');

        $user = User::where('slug', $slug)->first();

        $rules = $user->getRules();
        $messages = $user->getMessages();

        $validated = Validator::make($userData, $rules, $messages);
        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'validated' => $validated->errors()
            ]);
        }
        if ($user->email !== $userData['email']) {
            $user->email_verified_at = null;
        }
        $user->name = $userData['name'];
        $user->sex = $userData['sex'];
        $user->birthday = $userData['birthday'];
        $user->email = $userData['email'];
        $user->phone = $userData['phone'];
        $user->status = $userData['status'];
        $user->description = $userData['description'];
        $user->save();
        event(new Registered($user));
        return response()->json([
            'success' => true,
        ]);
    }
}
