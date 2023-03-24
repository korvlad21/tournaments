<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($slug)
    {
        return view('profile.show', compact('slug'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($slug)
    {
        return (Auth::user()->slug === $slug) ? view('profile.update', compact('slug')) : abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $rules
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        dd($request->post('avatar'));
        $slug = $request->post('slug');
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
        if (!$user->hasVerified()) {
            $user->name = $userData['name'];
            $user->sex = $userData['sex'];
            $user->birthday = $userData['birthday'];
        }
        if ($user->email !== $userData['email']) {
            $user->email_verified_at = null;
        }
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
