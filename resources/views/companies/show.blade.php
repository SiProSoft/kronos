@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="pull-right">
            @include('companies.modules.more-button')
        </div>
        {{--  <h1 class="h4" >
            <img src="{{ asset('img/logo.png') }}" alt="{{$company->title}}" class="company--logo">
        </h1>  --}}

        <h1 class="h4" >{{$company->title}}</h1>
        
        <hr>

        <div class="row">
            <div class="col-sm-4 col-sm-push-8">

                <div class="panel panel-default">
                        <div class="panel-heading">Company info</div>
                            
                        <div class="panel-body">
                            <div>Country: {{$company->country}}</div>
                            <div>City: {{$company->city}}</div>
                            <div>Street: {{$company->street}}</div>
                            <div>Phone: {{$company->phone}}</div>
                            <div>Email: {{$company->email}}</div>
                        </div>  
                    </div>
            </div>

            <div class="col-sm-8 col-sm-pull-4">

                <div class="panel panel-default ">
                    <div class="panel-heading">Members</div>
                        
                    <div class="panel-body">

                        @foreach ($currentUsers as $user)
                        {{--  <a href="#" class="company--member">
                            <img src="{{asset('img/no-profile-photo.jpg')}}" alt="">
                        </a>  --}}

                        <span class="company--member">
                            <img src="{{asset('img/no-profile-photo.jpg')}}" alt="{{$user->name}}" title="{{$user->name}}">
                        </span>
                        @endforeach
                    </div>  
                </div>

            </div>
        </div>
        



{{--  
        <h3>All</h3>
        @foreach ($users as $user)
            <div class="row">
                <div class="col-sm-6">
                    {{$user->name}}
                </div>
                <div class="col-sm-6">


                    @if ($company->users->contains($user))
                        {!! Form::open(['action' => ['CompaniesController@removeUser', $company->id], 'method' => 'POST']) !!}
                            {{ Form::submit('remove', ['class' => 'btn btn-danger']) }}
                            {{ Form::hidden('user_id', $user->id)}}
                            {{ Form::hidden('_method', 'DELETE')}}
                        {!! Form::close() !!}
                    @else
                        {!! Form::open(['action' => ['CompaniesController@addUser', $company->id], 'method' => 'POST']) !!}
                            {{ Form::submit('add', ['class' => 'btn btn-primary']) }}
                            {{ Form::hidden('user_id', $user->id)}}
                        {!! Form::close() !!}
                    @endif
                </div>
            
            
            </div>


        @endforeach  --}}




    </div>
@stop