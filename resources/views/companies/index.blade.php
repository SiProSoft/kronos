@extends('layouts.app')

@section('title', 'Companies')

@section('content')

    <div class="container">

        <h4 class="inline-block">Companies</h4>
        <a href="{{route('companies.create')}}" class="small">(Create company)</a>
        
        {{--  @include('companies.modules.form', ['company' => null])  --}}

        
        @if (!company()->is_hidden)
            <div>
                <a href="{{ route('companies.default', $personal->id)}}">Back to personal</a>
            </div>
        @endif

        <hr>


        @if (count($companies))
            <div class="row">

                @foreach ($companies as $company)
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                                <div class="pull-right">
                                    @include('companies.modules.more-button')
                                </div>
                                
                                <a href="{{route('companies.show', $company->id)}}">
                                    {{$company->title}}
                                </a>
                            </div>
                            {{--      
                            <div class="panel-body"></div>  
                            --}}
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <p>No companies</p>
        @endif
    
    </div>
@endsection
