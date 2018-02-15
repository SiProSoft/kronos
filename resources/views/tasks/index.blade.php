@extends('layouts.app')

@section('content')
<div class="container">

        <h4>Tasks</h4>
        <br>

        @include('inc.forms.task-form', ['task' => null])

        <hr>

        @if (count($tasks) > 0)
            @foreach ($tasks as $task)
            <div class="panel panel-default">
                <div class="panel-body {{ $task->completed ? "completed" : ""}}">
                    {{ $task->title }} - 
                    @if ($task->project->id != auth()->user()->getDefaultProject()->id)
                        <a href="{{route('projects.show', $task->project->id )}}">{{ $task->project->title }}</a>
                    @else
                        {{ $task->project->title }}
                    @endif
                    <div class="pull-right">
                        <span class="pull-left"><a href="/tasks/{{$task->id}}/edit" class="btn btn-sm btn-default">Edit</a></span>
                        <span class="pull-left">
                            {!! Form::open(['action' => ['TasksController@destroy', $task->id], 'method' => 'POST']) !!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger'])}}
                            {!! Form::close() !!}
                        </span>

                        @if ($task->completed)
                            <span class="pull-left"><a href="{{route('tasks.incomplete', $task->id)}}" class="btn btn-sm btn-warning">Mark as incomplete</a></span>
                        @else
                            <span class="pull-left"><a href="{{route('tasks.complete', $task->id)}}" class="btn btn-sm btn-success">Mark as complete</a></span>
                        @endif
                    </div>
                </div>

                
            </div>
                {{--  <div>Id: {{ $entry->id }}, {{ $entry->displayTime() }}</div>      --}}
            @endforeach
        @else
            <div>No tasks on this project</div>
        @endif
    
    
</div>
@endsection
