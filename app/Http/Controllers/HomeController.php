<?php

namespace App\Http\Controllers;

use App\Helpers\Discipline\DisciplineHelper;
use App\Helpers\Discipline\DisciplineInterface;
use App\Helpers\Generation\GenerationCalendarHelper;
use App\Helpers\Generation\GenerationDrawHelper;

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
        $teams = [
            'Barcelona',
            'Real',
            'Milan',
            'Inter',
            'Bayern',
            'Ajax',
            'Atletico',
            'Borussia',
            'PSG',
            'PSV'
            ];

        $generationCalendarHelper = new GenerationCalendarHelper();

        $generationDrawHelper = new GenerationDrawHelper();

//        shuffle($teams);
        $baskets = $generationDrawHelper->generateDoubleElimination($teams);
        dd($baskets);
        $calendar = [];
        foreach ($baskets as $basket) {
            $calendar[] =$generationCalendarHelper->generateOneLeague($basket, 1);
        }
        dd($calendar);
        return view('home');
    }
}
