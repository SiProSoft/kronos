@extends('layouts.app')

@section('content')
<div class="container">

    <h4>Projects</h4>
    <br>

    @include('inc.forms.project-form', ['project' => null])
    
    <hr>

    <div class="row">

        @foreach ($projects as $project)
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div class="pull-right">
                        @include('inc.projects.more-button')
                    </div>
                    
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
