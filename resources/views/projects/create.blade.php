
@extends('layouts.app')

@section('content')
    <div class="container">

        <h1 class="h4">Create project</h1>
        <hr>
        @include('inc.forms.project-form', ['project' => null])
    </div>
@endsection
