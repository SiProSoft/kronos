<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Task;

class ScrumController extends Controller
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
    public function index($id)
    {
        $project = Project::find($id);

        $scrumLists = array('backlog', 'todo', 'doing', 'done');
        
        $tasks = $project->tasks->filter(function($t) {
            return !$t->completed();
        });

        $lists["backlog"] = $tasks->filter(function($t) {
            return $t->scrum_status == "backlog";
        });

        $lists["todo"] = $tasks->filter(function($t) {
            return $t->scrum_status == "todo";
        });

        $lists["doing"] = $tasks->filter(function($t) {
            return $t->scrum_status == "doing";
        });

        $lists["done"] = $tasks->filter(function($t) {
            return $t->scrum_status == "done";
        });

        return view('projects.scrum')->with(['project' => $project, 'lists' => $lists]);
    }

    public function sortList(Request $request) {
        $ss = $request->all()["scrumStatus"];
        $ids = $request->all()["list"];

        // return $ids;

        $tasks = Task::find($request->list);

        // $tasksSorted = $tasks->sortBy(function($model) use ($ids) {
        //     echo array_search($model->id, $ids);
        //     return array_search($model->id, $ids);
        // });

        // return $tasksSorted;

        foreach ($ids as $index => $id) {
            Task::find($id)->update([
                'scrum_status' => $request->all()["scrumStatus"], 
                'scrum_sort' => $index
            ]);
        }

        // $ids->each(function($id, $index) use($request) {
        //     Task::find($id)->update([
        //         'scrum_status' => $request->all()["scrumStatus"], 
        //         'scrum_sort' => $index
        //     ]);
        // });

        return $tasks;
    }
}
