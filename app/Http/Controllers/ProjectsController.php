<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\Task;
use App\TimeEntry;

use App\Scopes\HiddenScope;

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
        $this->middleware('access:project')->only('show', 'edit', 'update', 'destroy');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $projects = Project::all();
        $projects = Project::forCompany()->visible()->get();
        return view('projects.index')->with('projects', $projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
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

        return redirect(route('projects.index'))->with('success', 'Project created');
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

        $project = Project::find($id);

        $timeEntries = $project->timeEntries()->filter(function($time) {
            return $time->end != null;
        });

        $sumInSeconds = getSumInSecondsFromTimeEntries($timeEntries);
        $sumFormatted = showAsTime($sumInSeconds);

        $tasks = Task::forProject($project->id)->visible()->incompleted()->get()->sortByDesc('created_at');
        
        return view('projects.show')->with([
            'project' => $project, 
            'timeEntries' => $timeEntries,
            'tasks' => $tasks,
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



    private function validateProject($request) {
        $this->validate($request, [
            'title' => 'required',
            // 'description' => 'required',
        ]);
    }

    private function updateProject($project, $request) {
        $project->title = $request->input('title');
        $project->description = $request->input('description') ?? "";
        $project->user_id = $project->user_id ?? auth()->user()->id;
        $project->company_id = $project->company_id ?? company()->id;
        $project->save();
    }
    

    
    // TODO: Move to API (ProjectResource)
    public function getProjectsForDropdown() {
        $projects = Project::forCompany()->get();
        return $projects;
    }
    
}
