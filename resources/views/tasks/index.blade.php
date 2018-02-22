@extends('layouts.app')

@section('content')
    <div class="container">

        <h4 class="inline-block">Tasks</h4>
        <a href="{{route('tasks.create')}}" class="small">(Create task)</a>
        <hr>

        @if (count($tasks['incompleted']) || count($tasks['completed']))
            @if (count($tasks['incompleted']))
                {{--  @include('inc.tasks.list', ['tasks' => $tasks, 'viewMode' => 'project'])  --}}
                @include('inc.tasks.list', ['tasks' => $tasks['incompleted'], 'viewMode' => 'tasks'])
            @else
                <p>All tasks are completed. Well done!</p>
            @endif
            
            <br>

            @if (count($tasks['completed']))
                <h4>Completed tasks</h4>
                <br>
                <div class="completed-task-list">
                    @include('inc.tasks.list', ['tasks' => $tasks['completed'], 'viewMode' => 'tasks'])
                {{--  @include('inc.tasks.list', ['tasks' => $tasks['completed']])  --}}
                </div>
            @endif
        @else
            <div>No tasks</div>
        @endif
    </div>
@endsection