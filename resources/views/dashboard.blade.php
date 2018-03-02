@extends('layouts.app')

@section('content')
<div class="container">

    @if ($company)
    <h1>Company: {{$company->title}}</h1>
    <h2 class="h4">User: {{$company->owner->name }}</h2>
    @endif


</div>
@endsection
