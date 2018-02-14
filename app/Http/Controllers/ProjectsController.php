<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\TimeEntry;

class ProjectsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = auth()->user()->projects;
        return view('projects.index')->with('projects', $projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateProject($request);

        $project = new Project;
        $this->updateProject($project, $request);

        return redirect(route('projects.index'));
    }

    private function validateProject($request) {
        $this->validate($request, [
            'title' => 'required',
            // 'description' => 'required',
        ]);
    }

    private function updateProject($project, $request) {
        $project->title = $request->input('title');
        $project->description = $request->input('description') ?? "";
        $project->user_id = auth()->user()->id;
        $project->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();

        $runningTimeEntry = $user->getRunningTimeEntry();

        $project = Project::find($id);

        $timeEntries = $project->timeEntries()->filter(function($time) {
            return $time->end != null;
        });

        $sumInSeconds = getSumInSecondsFromTimeEntries($timeEntries);
        
        $sumFormatted = showAsTime($sumInSeconds);

        return view('projects.show')->with([
            'project' => $project, 
            'runningTimeEntry' => $runningTimeEntry, 
            'timeEntries' => $timeEntries,
            'sum' => $sumFormatted
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        return view('projects.edit')->with('project', $project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateProject($request);

        $project = Project::find($id);
        $this->updateProject($project, $request);

        return redirect(route('projects.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        $project->delete();

        return redirect(route('projects.index'));
    }

    // public function startTimer($id) {
    //     $userId = auth()->user()->id;

    //     $runningTimeEntry = TimeEntry::where(['user_id' => $userId , 'end' => null])->first();

    //     if ($runningTimeEntry) {
    //         $runningTimeEntry->end = NOW();
    //         $runningTimeEntry->save();
    //     }

    //     $timeEntry = new TimeEntry;
    //     $timeEntry->start = NOW();
    //     $timeEntry->task_id = $id > 0 ? $id : null;
    //     $timeEntry->user_id = $userId;
    //     $timeEntry->save();
        
    //     return redirect(url()->previous());
    // }

    // public function stopTimer($id) {
    //     $timeEntry = TimeEntry::find($id);

    //     if ($timeEntry) {
    //         $timeEntry->end = NOW();
    //         $timeEntry->save();
    //     }

    //     return redirect(url()->previous());
    // }
}
