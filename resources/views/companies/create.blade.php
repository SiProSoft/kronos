@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="h4">Companies</h4>
        
        @include('companies.modules.form', ['company' => null])
    </div>
@stop