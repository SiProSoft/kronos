@extends('layouts.app')

@section('content')
    <div class="container">

            <h4 class="inline-block">Tasks</h4>
            <a href="{{route('tasks.create')}}" class="small">(Create task)</a>
            <hr>

        @if (count($tasks) > 0)
            @include('inc.tasks.list',  ['tasks' => $tasks['incompleted']])

            <br>
            <h4>Completed tasks</h4>
            <hr>
            @include('inc.tasks.list',  ['tasks' => $tasks['completed']])
        @else
            <div>No tasks on this project</div>
        @endif
    </div>
@endsection