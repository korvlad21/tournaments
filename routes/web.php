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
        Route::get('create', 'TeamController@create')->name('team.create');
        Route::get('{id}', 'TeamController@show')->name('team.show');
        Route::middleware(['team'])->get('edit/{id}', 'TeamController@edit')->name('team.edit');
    });
    Route::prefix('profile')->group(function () {
        Route::get('{slug}', 'ProfileController@show')->name('profile.show');
        Route::middleware(['profile'])->get('edit/{slug}', 'ProfileController@edit')->name('profile.update');
    });
    Route::prefix('contractor')->group(function () {
        Route::get('create', 'ContractorController@create')->name('contractor.create');
        Route::middleware(['contractor'])->get('edit/{id}', 'ContractorController@edit')->name('contractor.edit');
        Route::get('{id}', 'ContractorController@show')->name('contractor.show');
    });
    Route::prefix('event')->group(function () {
        Route::get('create', 'EventController@create')->name('event.create');
        Route::middleware(['event'])->get('edit/{id}', 'EventController@edit')->name('event.edit');
//        Route::get('{id}', 'EventController@show')->name('event.show');
    });
});
