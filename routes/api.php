<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::controller(API\RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::prefix('user')->group(function () {
        Route::controller(API\UserController::class)->group(function () {
            Route::post('get_info', 'getInfo');
            Route::post('is_auth_user', 'isAuthUser');
            Route::post('get_roles', 'getRoles');
        });
    });
    Route::prefix('team')->group(function () {
        Route::controller(API\TeamController::class)->group(function () {
            Route::post('create', 'create');
            Route::post('get_info', 'getInfo');
            Route::post('is_own', 'isOwn');
        });
    });
    Route::prefix('image')->group(function () {
        Route::controller(API\ImageController::class)->group(function () {
            Route::post('avatar_upload', 'avatarUpload');
            Route::post('logo_upload', 'logoUpload');
            Route::post('passport_upload', 'passportUpload');
            Route::post('get_avatar', 'getAvatar');
        });
    });
    Route::get('/get', 'GetController');
});
