<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Company;
use App\Project;

use App\Scopes\HiddenScope;

class TasksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access:task')->only('show', 'edit', 'update', 'destroy');
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $taskss = Task::forCompany()->visible()->get();

        $tasks["completed"] = $taskss->filter(function($t) {
            return $t->completed_at != null;
        })->sortByDesc('completed_at');

        $tasks["incompleted"] = $taskss->filter(function($t) {
            return $t->completed_at == null;
        })->sortByDesc('created_at');

        return view('tasks.index')->with(['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::forCompany(company())->get()->pluck('title', 'id');
        return view('tasks.create')->with('projects', $projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateTask($request);

        $task = new Task;
        $this->updateTask($task, $request);

        if ($request->input('redirect')) {
            return redirect($request->input('redirect'))->with('success', 'Task has been created');
        }

        return redirect(route('tasks.index'))->with('success', 'Task has been created');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);

        if (!$this->checkTask($task)) {
            return redirect(route('tasks.index'));
        }
        
        $projects = Project::withoutGlobalScope(HiddenScope::class)->pluck('title', 'id');
        return view('tasks.edit')->with(['task' => $task, 'projects' => $projects]);
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
        $this->validateTask($request);
        $task = Task::find($id);
        
        if (!$this->checkTask($task)) {
            return redirect(route('tasks.index'));
        }

        $this->updateTask($task, $request);

        if ($request->input('redirect')) {
            return redirect($request->input('redirect'));
        }
        
        // return redirect(url()->previous());
        // return redirect(route('tasks.index'));
        
        if ($request->input('redirect')) {
            return redirect($request->input('redirect'));
        }

        return redirect(route('tasks.index'));
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$this->checkTask($task)) {
            return redirect(route('tasks.index'));
        }
        
        $task->delete();

        return redirect(url()->previous())->with('success', 'Task deleted');
        // return redirect(route('tasks.index'))->with('success', 'Task deleted');
    }

    public function complete($id)
    {
        // $this->completeTask($id);

        $task = Task::find($id);
        
        if (!$this->checkTask($task)) {
            return redirect(route('tasks.index'));
        }

        $task->completed_at = NOW();
        $task->save();

        return redirect(route('tasks.index'));
    }

    public function incomplete($id) {
        $task = Task::find($id);
        
        if (!$this->checkTask($task)) {
            return redirect(route('tasks.index'));
        }

        $task->completed_at = null;
        $task->save();

        return redirect(route('tasks.index'));
    }
    
    private function validateTask($request) {
        $this->validate($request, [
            'title' => 'required',
            // 'description' => 'required',
        ]);
    }

    private function updateTask($task, $request) {

        // $estimate = $request->input('estimate');
        
        $estimate = $request->input('estimate') * 60 * 60;
        
        //------

        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->project_id = $request->input('project');
        // $task->completed = $task->completed ?? false;
        $task->user_id = $task->user_id ?? auth()->user()->id;
        $task->estimate = $estimate;
        
        $task->save();
    }

    
    public function getTasksForDropdown($id) {
        $tasks = Task::forProject($id)->get();
        return $tasks;
    }

    public function checkTask($task) {
        $project = Project::withoutGlobalScope(HiddenScope::class)->find($task->project_id);
        return $project;        
    }

}
