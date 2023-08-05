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
            Route::post('get_friends', 'getFriends');
            Route::post('is_friend', 'isFriend');
            Route::post('is_subscribe', 'isSubscribe');
            Route::middleware(['profile'])->post('update/{slug}', 'update')->name('profile.update');
        });
    });
    Route::prefix('team')->group(function () {
        Route::controller(API\TeamController::class)->group(function () {
            Route::post('create', 'create');
            Route::middleware(['team'])->post('update/{id}', 'update');
            Route::post('get_info', 'getInfo');
            Route::post('get_all_info', 'getAllInfo');
            Route::post('is_own', 'isOwn');
        });
    });
    Route::prefix('contractor')->group(function () {
        Route::controller(API\ContractorController::class)->group(function () {
            Route::post('create', 'create');
            Route::middleware(['contractor'])->post('update/{id}', 'update');
            Route::middleware(['contractor'])->post('delete/{id}', 'delete');
            Route::post('get_info', 'getInfo');
            Route::post('get_options', 'getOptions');
            Route::post('get_all_info', 'getAllInfo');
        });
    });
    Route::prefix('event')->group(function () {
        Route::controller(API\EventController::class)->group(function () {
            Route::post('create', 'create');
            Route::middleware(['event'])->post('update/{id}', 'update');
            Route::middleware(['event'])->post('delete/{id}', 'delete');
            Route::post('get_info', 'getInfo');
            Route::post('get_all_info', 'getAllInfo');
            Route::post('is_own', 'isOwn');
            Route::post('get_event_options', 'getEventOptions');
        });
    });
    Route::prefix('place')->group(function () {
        Route::controller(API\PlaceController::class)->group(function () {
            Route::post('create', 'create');
            Route::post('get_info', 'getInfo');
            Route::post('get_all_info', 'getAllInfo');
            Route::middleware(['place'])->post('update/{id}', 'update');
            Route::middleware(['place'])->post('delete/{id}', 'delete');
            Route::middleware(['image.place'])->post('delete_image/{id}', 'deleteImage');
        });
    });
    Route::prefix('tournament')->group(function () {
        Route::controller(API\TournamentController::class)->group(function () {
            Route::post('get_discipline_options', 'getDisciplineOptions');
            Route::post('get_type_stage_options', 'getTypeStageOptions');
        });
    });
    Route::prefix('image')->group(function () {
        Route::controller(API\ImageController::class)->group(function () {
            Route::post('avatar_upload', 'avatarUpload');
            Route::post('logo_team_upload', 'logoTeamUpload');
            Route::post('passport_upload', 'passportUpload');
            Route::post('get_avatar', 'getAvatar');
        });
    });
    Route::get('/get', 'GetController');
});
