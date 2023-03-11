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
        return response()->json(new UserResource(Auth::user()));
    }
}
