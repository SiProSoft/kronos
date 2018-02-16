@extends('layouts.app')

@section('content')
<div class="container">

    {!! Form::open(['action' => ['TimeEntriesController@update', $timeEntry->id], 'method' => 'POST']) !!}

        <div class="form-group">
            {{ Form::label('description', 'Description' ) }}
            {{ Form::text('description', $timeEntry->description, ['class' => 'form-control'] ) }}
        </div>

        <div class="row form-group" >
            <div class="col-sm-4">
            {{ Form::label('project', 'Project' ) }}
            {{--  {{ Form::select('project', $projects, $timeEntry->getProject()->id, ['class' => 'form-control', 'v-model' => 'projectid']) }}  --}}
            <projects-dropdown currentproject="{{$timeEntry->getProject()->id}}"></projects-dropdown>
            </div>
            <div class="col-sm-4">
            {{ Form::label('task', 'Task' ) }}
            {{--  {{ Form::select('task', $tasks, $timeEntry->task->id, ['class' => 'form-control']) }}  --}}
            <tasks-dropdown currentproject="{{$timeEntry->getProject()->id}}" currenttask="{{$timeEntry->task->id}}"></tasks-dropdown>
            </div>
        </div>

        {{-- DateTimePicker Docs: http://eonasdan.github.io/bootstrap-datetimepicker/  --}}
        <div class="row">
            <div class='col-sm-4'>
                <div class="form-group">
                    <label for="start">Start</label>
                    <div class='input-group date' id='datetimepicker6' data-default-date="{{$timeEntry->start}}" >
                        <input id="start" type='text' class="form-control" name="start" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='col-sm-4'>
                <div class="form-group">
                    <label for="end">End</label>
                    
                    <div class='input-group date' id='datetimepicker7' data-default-date="{{$timeEntry->end}}">
                        <input id="end" type='text' class="form-control" name="end" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        </div>

        {{ Form::hidden('_method', 'PUT') }}
    {!! Form::close() !!}  
</div>
@endsection
