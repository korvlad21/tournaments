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
        return view('home');
    }
}
