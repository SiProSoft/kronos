@extends('layouts.app')

@section('content')
<div class="container">

    {!! Form::open(['action' => 'TasksController@store', 'method' => 'POST']) !!}
        <div class="form-group">
            {{ Form::label('title', 'Title' ) }}
            {{ Form::text('title', null, ['class' => 'form-control'] ) }}
        </div>        
        <div class="form-group">
            {{ Form::label('description', 'Description' ) }}
            {{ Form::text('description', null, ['class' => 'form-control'] ) }}
        </div>

        <div class="form-group">
                {{ Form::label('project', 'Project' ) }}
                {{ Form::select('project', $projects, null, ['class' => 'form-control', 'placeholder' => 'No Project']) }}
            </div>
        <div class="form-group">
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        </div>
        {!! Form::close() !!}  
        
</div>
@endsection
