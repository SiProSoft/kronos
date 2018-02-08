@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {!! Form::open(['action' => 'ProjectsController@store', 'method' => 'POST']) !!}
    <div class="form-group">
        {{ Form::label('title', 'Project title') }}
        {{ Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Project title']) }}
    </div>
    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', '', ['class' => 'form-control', 'placeholder' => 'Description']) }}
    </div>

    <div class="form-group">
        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    </div>
    {!! Form::close() !!}

    <hr>

    <div class="row">

        @foreach ($projects as $project)
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{route('projects.show', $project->id)}}">
                        {{$project->title}}
                    </a>
                </div>

                <div class="panel-body">
                    {{$project->description}}
                </div>
            </div>
        </div>
        @endforeach



    </div>
</div>
@endsection
