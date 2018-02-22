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

        {{ Form::hidden('redirect', url()->current()) }}
    {!! Form::close() !!}

    <hr>
    
    @if (count($tasks) > 0)
        @include('inc.tasks.list', ['tasks' => $tasks, 'viewMode' => 'project'])
    @else
        <div>No tasks on this project</div>
    @endif
    <br>
    <a href="{{route('tasks.index')}}">Show completed tasks</a>




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
