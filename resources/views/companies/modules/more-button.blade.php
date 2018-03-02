<div class="more-group">
    <a href="#" class="more-group--button ic-more">
        <i class="material-icons">more_vert</i>
    </a>

    <div class="more-group--list">
        <div>
            <a href="{{ route('companies.default', $company->id)}}">Make default</a>
        </div>
        
        <hr>

        <div>
            <a href="{{route('companies.edit', $company->id)}}" class="btn btn-default">Edit</a>
        </div>

        <div>
            {!! Form::open(['action' => ['CompaniesController@destroy', $company->id], 'method' => 'POST']) !!}
                {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                {{ Form::hidden('_method', 'DELETE') }}
            {!! Form::close() !!}
        </div>

    </div>
</div>