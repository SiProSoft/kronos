@extends('layouts.app')

@section('content')
<div class="container scrum">
    <h1>Scrum</h1>
    <h4>{{$project->title}}</h4>

    <div class="scrum--wrapper">

        <div class="scrum--board" id="scrum-board">

            @foreach ($lists as $key => $list)
                <div class="scrum--list-wrapper">

                    <h4 class="scrum--list-header" >{{$key}}</h4>
                    <ul class="scrum--list" data-scrum-status="{{ $key }}">
                        @foreach ($list->sortBy('scrum_sort') as $task)
                            <li class="scrum--list-item" data-taskid="{{$task->id}}">
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
