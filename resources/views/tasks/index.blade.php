@extends('layouts.app')

@section('content')
<div class="container">

        <h4>Tasks</h4>
        <br>
        <div><a href="/tasks/create">Create a task</a></div>
        @if (count($tasks) > 0)
            @foreach ($tasks as $task)
            <div class="panel panel-default">
                <div class="panel-body">
                    {{ $task->title }} - {{ $task->project ? $task->project->title : "No Project" }}
                <div class="pull-right">
                    <span class="pull-left"><a href="/tasks/{{$task->id}}/edit" class="btn btn-sm btn-default">Edit</a></span>
                    <span class="pull-left">
                        {!! Form::open(['action' => ['TasksController@destroy', $task->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger'])}}
                        {!! Form::close() !!}
                    </span>
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
