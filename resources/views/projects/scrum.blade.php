@extends('layouts.project')
{{--  
@section('sidebar')

    <p>This is appended to the master sidebar.</p>
@stop  --}}

@section('content')
<div class="container scrum">
    @parent

    <div class="small">
        <a href="{{ route('projects.show', $project->id)}}">back to project page</a>
    </div>

    <hr>
    {{--  <h1 class="h3">{{$project->title}}</h1>  --}}
    {{--  <h4></h4>  --}}

    <div class="scrum--wrapper">

        <div class="scrum--board" id="scrum-board">

            @foreach ($lists as $key => $list)
                <div class="scrum--list-wrapper">

                    <h4 class="scrum--list-header" >{{$key}}</h4>
                    <ul class="scrum--list" data-scrum-status="{{ $key }}">
                        @foreach ($list->sortBy('scrum_sort') as $task)
                            <li class="scrum--list-item" data-taskid="{{$task->id}}">
                                <span class="pull-right">@include('inc.tasks.more-button', ['task' => $task])</span>
                                {{ $task->title }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
        
</div>
@endsection
