<?php

namespace App\Http\Middleware\Exist;

use App\Models\Team;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExistProfileMiddleware
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
        $slug = $request->route('slug'); // получаем идентификатор команды из маршрута
        $user = User::where('slug', $slug)->first();
        if ($user === null) {
            abort(404, 'Страницы не существует'); // если текущий пользователь не владелец команды, то возвращаем ошибку 403
        }
        return $next($request);
    }
}
