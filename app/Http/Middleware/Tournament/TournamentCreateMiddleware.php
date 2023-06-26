<?php

namespace App\Http\Middleware\Tournament;

use App\Models\Contractor;
use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentCreateMiddleware
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

        $user = Auth::user();
        $event_id = $request->route('event_id'); // получаем идентификатор команды из маршрута
        if (null === $event_id) {
            $events = Event::where('user_id', $user->id)->exists();
            if (!$events) {
                return redirect()->route('event.create')->with('danger', "Для начала необходимо создать эвент!");
            }
            return $next($request);
        }
        $event = Event::find($event_id);


        if ($event === null || $user->id !== $event->user_id) {
            abort(404, 'Страницы не существует'); // если текущий пользователь не владелец команды, то возвращаем ошибку 403
        }
        return $next($request);

    }
}
