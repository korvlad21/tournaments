<?php

namespace App\Http\Middleware\Exist;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExistTeamMiddleware
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
        $teamId = $request->route('id'); // получаем идентификатор команды из маршрута
        $team = Team::find($teamId);

        if ($team === null) {
            abort(404, 'Страницы не существует'); // если текущий пользователь не владелец команды, то возвращаем ошибку 403
        }
        return $next($request);
    }
}
