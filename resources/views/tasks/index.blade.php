@extends('layouts.app')

@section('content')
<div class="container">

        <h4>Tasks</h4>
        <br>

        @include('inc.forms.task-form', ['task' => null])

        <hr>

        @if (count($tasks) > 0)
            @foreach ($tasks as $tasklist)

                <p>{{ $tasklist[0]->completed ? "Completed tasks" : ""}}</p>
                @foreach ($tasklist as $task)
                <div class="panel panel-default">
                    <div class="panel-body {{ $task->completed ? "completed" : ""}}">
                        {{ $task->title }} - 
                        @if ($task->project->id != auth()->user()->getDefaultProject()->id)
                            <a href="{{route('projects.show', $task->project->id )}}">{{ $task->project->title }}</a>
                        @else
                            {{ $task->project->title }}
                        @endif
                        <div class="pull-right option-menu">

                            @include('inc.tasks.more-button', ['task' => $task])
                            
                            
                            
                        </div>
                    </div>

                    
                </div>
                    {{--  <div>Id: {{ $entry->id }}, {{ $entry->displayTime() }}</div>      --}}
                @endforeach
            @endforeach
        @else
            <div>No tasks on this project</div>
        @endif
    
    
</div>
@endsection
