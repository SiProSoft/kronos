<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

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
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = auth()->user()->tasks;
        $projects = auth()->user()->projects->pluck('title', 'id');
        
        return view('tasks.index')->with(['tasks' => $tasks, 'projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = auth()->user()->projects->pluck('title', 'id');
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
            return redirect($request->input('redirect'));
        }

        return redirect(url()->previous());
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
        $projects = auth()->user()->projects->pluck('title', 'id');
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
        $this->updateTask($task, $request);

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
        $task->delete();

        return redirect(url()->previous());
        // return redirect(route('tasks.index'))->with('success', 'Task deleted');
    }

    public function complete($id)
    {
        // $this->completeTask($id);

        $task = Task::find($id);
        $task->completed = true;
        $task->save();

        return redirect(route('tasks.index'));
    }

    public function incomplete($id) {
        $task = Task::find($id);
        $task->completed = false;
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
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->project_id = $request->input('project');
        $task->completed = $task->completed ?? false;
        $task->user_id = $task->user_id ?? auth()->user()->id;
        $task->save();
    }

    // private function completeTask($id) {
        
    // }

}
