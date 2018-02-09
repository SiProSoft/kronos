@extends('layouts.app')

@section('content')
<div class="container">

        <h4>Time Entries</h4>
        <br>
        {{--  <div><a href="/timeentries/create">Create a task</a></div>  --}}
        @if (count($timeEntries) > 0)
            @foreach ($timeEntries as $timeEntry)
            <div class="panel panel-default">
                <div class="panel-body">
                    {{ $timeEntry->displayTime() }} - {{ $timeEntry->project ? $timeEntry->project->title : "No Project" }} - {{ $timeEntry->task ? $timeEntry->task->title : "No Task" }}

                    <div class="pull-right">
                        <span class="pull-left"><a href="/timeentries/{{$timeEntry->id}}/edit" class="btn btn-sm btn-default">Edit</a></span>
                        <span class="pull-left">
                            {!! Form::open(['action' => ['TimeEntriesController@destroy', $timeEntry->id], 'method' => 'POST']) !!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger'])}}
                            {!! Form::close() !!}
                        </span>
                    </div>
                </div>
                
            </div>
            @endforeach
        @else
            <div>No time entries</div>
        @endif
    
    
</div>
@endsection
