@extends('layouts.app')

@section('content')
<div class="container projects--show">
    <div class="more-group--project-wrapper pull-right">
        @include('inc.projects.more-button')
    </div>
    
    <h3>
        {{ $project->title }}
    </h3>

    <div>
        {{ $project->description }}
    </div>
    <hr>
    
    
    
    
    <h4>Tasks</h4>
    <br>
    {!! Form::open(['action' => 'TasksController@store', 'method' => 'POST']) !!}
        
        <div class="row">
            <div class="col-sm-4 form-group">
                {{ Form::label('title', 'Title') }}
                {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title'] ) }}
            </div>
            <div class="col-sm-4 form-group">
                {{ Form::label('description', 'Description') }}
                {{ Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Description'] ) }}
            </div>

            {{ Form::hidden('project', $project->id) }}
            <div class="col-sm-4 form-group">
                <div class="hidden-xs"><label for="">&nbsp;</label></div>
                {{ Form::submit('Create task', ['class' => 'btn btn-primary']) }}
            </div>
        </div>

        {{ Form::hidden('redirect', '') }}
    {!! Form::close() !!}

    <hr>
    @if (count($tasks) > 0)
        @foreach ($tasks as $task)
        <div class="panel panel-default">
            <div class="panel-body">
{{--  
                <div class="pull-right">
                    
                    @if ($task->completed)
                        <span>Marked as complete</span>
                    @elseif ($runningTimeEntry && $runningTimeEntry->task && $runningTimeEntry->task->id == $task->id)
                        @include('inc.timer.stop', ['runningTimeEntry' => $runningTimeEntry])
                    @else
                        @include('inc.timer.start', ['taskId' => $task->id])
                    @endif
                        
                </div>  --}}

                <div class="pull-right">
                    @include('inc.tasks.more-button')
                </div>

                {{ $task->title }} - {{ $task->displaySum() }}
                <div>{{ $task->description }}</div>


            </div>
        </div>
        @endforeach
    @else
        <div>No tasks on this project</div>
    @endif




    <hr>
    <h4>Time entries ({{ $sum }})</h4>
    <br>
    @if (count($timeEntries) > 0)
        @foreach ($timeEntries as $entry)

        <div class="panel panel-default">
            <div class="panel-body">
                {{ $entry->task->title }} - {{ $entry->displayTime() }}
            </div>
        </div>

        @endforeach
    @else
        <div>No time entries on this project</div>
    @endif
</div>
@endsection
