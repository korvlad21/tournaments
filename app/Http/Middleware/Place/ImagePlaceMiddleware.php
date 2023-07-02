<?php

namespace App\Http\Middleware\Place;

use App\Models\ImagesPlace;
use App\Models\Place;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImagePlaceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $id = $request->route('id'); // получаем идентификатор команды из маршрута
        $user = Auth::user();
        $imagePlace = ImagesPlace::find($id);
        $place = $imagePlace->place()->first();
        if ($place === null || $user->id !== $place->user_id) {
            abort(404, 'Страницы не существует'); // если текущий пользователь не владелец команды, то возвращаем ошибку 403
        }
        return $next($request);
    }
}
