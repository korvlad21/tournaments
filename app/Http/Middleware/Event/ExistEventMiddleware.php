<?php

namespace App\Http\Middleware\Event;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;

class ExistEventMiddleware
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
        $event = Event::find($id);

        if ($event === null) {
            abort(404, 'Страницы не существует'); // если текущий пользователь не владелец команды, то возвращаем ошибку 403
        }
        return $next($request);
    }
}