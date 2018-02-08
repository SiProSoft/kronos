@extends('layouts.app')

@section('content')
<div class="container">
    {{--  {{ $timeentry }}  --}}
    
    @if ($runningTimeEntry)
        <a href="/timer/{{ $runningTimeEntry->id }}/stop" class="btn btn-danger">Stop timer</a>
        {{--  {!! Form::open(['action' => ['ProjectsController@stopTimer', $runningTimeEntry->id], 'method' => 'POST']) !!}
            <div class="form-group">
                {{ Form::submit('Stop timer', ['class' => 'btn btn-danger']) }}
            </div>
        {!! Form::close() !!}          --}}
    @else
        {!! Form::open(['action' => ['ProjectsController@startTimer', 0], 'method' => 'POST']) !!}
            <div class="form-group">
                {{ Form::submit('Start timer', ['class' => 'btn btn-success']) }}
            </div>
        {!! Form::close() !!}
    @endif

    {{--  <a href="#">Start timer</a>  --}}
    
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

            {{ Form::hidden('projectid', $project->id) }}
            <div class="col-sm-4 form-group">
                <div><label for="">&nbsp;</label></div>
                {{ Form::submit('Create task', ['class' => 'btn btn-danger']) }}
            </div>
            
        </div>

        {{ Form::hidden('redirect', '') }}
    {!! Form::close() !!}        

    @if (count($project->tasks) > 0)
        @foreach ($project->tasks as $task)
        <div class="panel panel-default">
                <div class="panel-body">
                    {{ $task->title }} - {{ $task->displaySum() }}

                    <div class="pull-right">
                        {!! Form::open(['action' => ['ProjectsController@startTimer', $task->id], 'method' => 'POST']) !!}
                            <div class="form-group">
                                {{ Form::submit('Start timer', ['class' => 'btn btn-success']) }}
                            </div>
                        {!! Form::close() !!}
                    </div>
            </div>
            </div>
            {{--  <div>Id: {{ $entry->id }}, {{ $entry->displayTime() }}</div>      --}}
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
                {{$entry->task ? $entry->task->title : "No task" }} - {{ $entry->displayTime()}}
            </div>
        </div>

        @endforeach
    @else
        <div>No time entries on this project</div>
    @endif
</div>
@endsection
