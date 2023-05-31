<?php

namespace App\Http\Controllers;

use App\Helpers\Discipline\DisciplineHelper;
use App\Helpers\Discipline\DisciplineInterface;
use App\Helpers\Generation\GenerationCalendarHelper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $disciplineHelper = new DisciplineHelper();
        /** @var DisciplineInterface $d */
        $discipline = $disciplineHelper->getHelper('poker');
        $teams = ['Barcelona', 'Real', 'Milan', 'Inter'];

        $generationCalendarHelper = new GenerationCalendarHelper();

        dd($generationCalendarHelper->getOneLeague($teams, 1));

        return view('home');
    }
}
