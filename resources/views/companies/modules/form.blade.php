@php
    // $mode = $company ? 'update' : 'store';
    $action = $company ? ['CompaniesController@update', $company->id] : 'CompaniesController@store';
@endphp

{!! Form::open(['action' => $action, 'method' => 'POST']) !!}
    <div class="form-group">
        {{ Form::label('title', 'Title')}}
        {{ Form::text('title', $company ? $company->title : null, ['class' => 'form-control', 'placeholder' => 'Title'] ) }}
    </div>

    <div class="form-group">
        {{ Form::label('country', 'Country')}}
        {{ Form::text('country', $company ? $company->country : null, ['class' => 'form-control', 'placeholder' => 'Country'] ) }}
    </div>

    <div class="form-group">
        {{ Form::label('city', 'City')}}
        {{ Form::text('city', $company ? $company->city : null, ['class' => 'form-control', 'placeholder' => 'City'] ) }}
    </div>

    <div class="form-group">
        {{ Form::label('street', 'Street')}}
        {{ Form::text('street', $company ? $company->street : null, ['class' => 'form-control', 'placeholder' => 'Street'] ) }}
    </div>

    
    <div class="form-group">
        {{ Form::label('phone', 'Phone')}}
        {{ Form::text('phone', $company ? $company->phone : null, ['class' => 'form-control', 'placeholder' => 'Phone'] ) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('email', 'Email')}}
        {{ Form::text('email', $company ? $company->email : null, ['class' => 'form-control', 'placeholder' => 'Email'] ) }}
    </div>
        
    <div class="form-group">
        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    </div>

    @if ($company)
        {{ Form::hidden('_method', 'PUT')}}
    @endif
{!! Form::close() !!}