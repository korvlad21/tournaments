<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});
//Auth::routes();
// auth
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');



Route::middleware(['auth'])->group(function() {
//    Route::get('/profile', 'ProfileController@index')->name('profile.index');
    Route::prefix('team')->group(function () {
        Route::get('', 'TeamController@index')->name('team.index');
        Route::get('create', 'TeamController@create')->name('team.create');
        Route::middleware(['exist.team'])->get('{id}', 'TeamController@show')->name('team.show');
        Route::middleware(['team'])->get('edit/{id}', 'TeamController@edit')->name('team.edit');
    });
    Route::prefix('profile')->group(function () {
        Route::middleware(['exist.profile'])->get('{slug}', 'ProfileController@show')->name('profile.show');
        Route::middleware(['profile'])->get('edit/{slug}', 'ProfileController@edit')->name('profile.update');
    });
    Route::prefix('contractor')->group(function () {
        Route::get('', 'ContractorController@index')->name('contractor.index');
        Route::get('create', 'ContractorController@create')->name('contractor.create');
        Route::middleware(['contractor'])->get('edit/{id}', 'ContractorController@edit')->name('contractor.edit');
        Route::middleware(['exist.contractor'])->get('{id}', 'ContractorController@show')->name('contractor.show');
    });
    Route::prefix('event')->group(function () {
        Route::get('', 'EventController@index')->name('event.index');
        Route::get('create', 'EventController@create')->name('event.create');
        Route::middleware(['event'])->get('edit/{id}', 'EventController@edit')->name('event.edit');
        Route::middleware(['exist.event'])->get('{id}', 'EventController@show')->name('event.show');
    });
    Route::prefix('place')->group(function () {
        Route::get('', 'PlaceController@index')->name('place.index');
        Route::get('create', 'PlaceController@create')->name('place.create');
        Route::middleware(['place'])->get('edit/{id}', 'PlaceController@edit')->name('place.edit');
        Route::middleware(['exist.place'])->get('{id}', 'PlaceController@show')->name('place.show');
    });
    Route::prefix('tournament')->group(function () {
        Route::middleware(['create.tournament'])->get('create/{event_id?}', 'TournamentController@create')->name('tournament.create');
        Route::get('', 'TournamentController@index')->name('tournament.index');
        Route::get('{id}', 'TournamentController@show')->name('tournament.show');
        Route::get('add-teams/{id}', 'TournamentController@addTeams')->name('tournament.add-teams');
    });
    Route::prefix('stage')->group(function () {
        Route::get('{id}', 'StageController@show')->name('stage.show');
    });
});
