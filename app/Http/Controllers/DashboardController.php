<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeEntry;

class DashboardController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timeEntries = TimeEntry::all()->filter(function($t) {
            return $t->end != null;
        });
        
        // $times = array();
        $times = $timeEntries->map(function($t) {
            return $t->getTime();
        });
        // $timeSum = "";
        $timeSum = array_sum($times->toArray());

        $timeSum = showAsTime($timeSum);
        // return $times;
        
        $selectProjects = auth()->user()->projects->mapWithKeys(function($project) {
            return [$project->id => $project->title];
        });

        return view('dashboard')->with(['timeEntries' => $timeEntries, 'sum' => $timeSum, 'selectProjects' => $selectProjects]);
    }
}
