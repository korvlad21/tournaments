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
            'Borussia',
            'Chelsea',
            'Liverpool',
            'MU',
            'MC',
            'Napoli',
            'Ajax',
            'Benfica',
            'Porto',
            'PSG',
            'Atletico',
            'Valencia',
            'Juventus',
            'Roma',
            'Arsenal'
            ];

        $generationCalendarHelper = new GenerationCalendarHelper();

        $generationDrawHelper = new GenerationDrawHelper();

        $baskets = $generationDrawHelper->generateBaskets($teams, 6);
        dd($baskets);
        $calendar = [];
        foreach ($baskets as $basket) {
            $calendar[] =$generationCalendarHelper->generateOneLeague($basket, 1);
        }
        dd($calendar);
        return view('home');
    }
}
