<?php

namespace App\Http\Middleware\Event;

use App\Models\Contractor;
use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventMiddleware
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
        $contractors = Contractor::where('user_id', $user->id)->exists();
        if (!$contractors) {
            return redirect()->route('contractor.create')->with('danger', "Для начала необходимо создать контрагента!");
        }
        $event = Event::find($id);


        if ($event === null || $user->id !== $event->user_id) {
            abort(404, 'Страницы не существует'); // если текущий пользователь не владелец команды, то возвращаем ошибку 403
        }
        return $next($request);
    }
}
