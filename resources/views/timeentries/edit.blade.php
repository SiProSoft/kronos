@extends('layouts.app')

@section('content')
<div class="container">

    {!! Form::open(['action' => ['TimeEntriesController@update', $timeEntry->id], 'method' => 'POST']) !!}
        {{--  <div class="form-group">
            {{ Form::label('title', 'Title' ) }}
            {{ Form::text('title', null, ['class' => 'form-control'] ) }}
        </div>          --}}

        <div class="form-group">
            {{ Form::label('description', 'Description' ) }}
            {{ Form::text('description', $timeEntry->description, ['class' => 'form-control'] ) }}
        </div>

        <div class="row form-group" >
            <div class="col-sm-4">
                {{ Form::select('project', $projects, $timeEntry->project ? $timeEntry->project->id : null, ['class' => 'form-control', 'placeholder' => 'No Project']) }}
            </div>
            <div class="col-sm-4">
                {{ Form::select('task', $tasks, $timeEntry->task ? $timeEntry->task->id : null, ['class' => 'form-control', 'placeholder' => 'No Task']) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        </div>

        {{ Form::hidden('_method', 'PUT') }}
        {!! Form::close() !!}  
</div>
@endsection
