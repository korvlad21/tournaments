<?php

namespace App\Http\Controllers;

use App\Helpers\Discipline\DisciplineHelper;
use App\Helpers\Discipline\DisciplineInterface;

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
        $d = $disciplineHelper->getHelper('poker');
        dd($d->getInfo());
        return view('home');
    }
}
