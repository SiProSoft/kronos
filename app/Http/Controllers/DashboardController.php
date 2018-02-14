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
        $user = auth()->user();

        $timeEntries = TimeEntry::where('user_id', $user->id)->whereNotNull('end')->get();

        $sumInSeconds = getSumInSecondsFromTimeEntries($timeEntries);
        $sumFormated = showAsTime($sumInSeconds);
        
        $selectProjects = $user->projects->mapWithKeys(function($project) {
            return [$project->id => $project->title];
        });

        return view('dashboard')->with([
            'timeEntries' => $timeEntries, 
            'sum' => $sumFormated, 
            'selectProjects' => $selectProjects
        ]);
    }
}
