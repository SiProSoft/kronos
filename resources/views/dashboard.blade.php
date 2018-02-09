@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Time Entries {{$sum}}</div>

                <div class="panel-body">
                    @foreach($timeEntries as $timeEntry)
                    <div class="row form-group">
                        <div class="col-sm-4">
                            @php
                                $currentProject = $timeEntry->project ? $timeEntry->project->id : null;
                            @endphp
                            {{ Form::select('project', $selectProjects, $currentProject, ['class' => 'form-control', 'placeholder' => 'No Project']) }}
                        </div>
                        <div class="col-sm-4">
                            @php
                                $selectedTasks = $timeEntry->project ? $timeEntry->project->tasks->mapWithKeys(function($task) {
                                    return [$task->id => $task->title];
                                }) : [];
                                $currentTask = $timeEntry->task ? $timeEntry->task->id : null;
                            @endphp

                            {{ Form::select('task', $selectedTasks , $currentTask, ['class' => 'form-control', 'placeholder' => 'No Task']) }}
                        </div>
                        <div class="col-sm-4">{{ $timeEntry->displayTime() }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
