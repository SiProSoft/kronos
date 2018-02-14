@extends('layouts.app')

@section('content')
    <div class="container">
        @include('inc.forms.project-form', ['project' => $project])
    </div>
@endsection

