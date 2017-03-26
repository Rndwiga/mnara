@extends(config('mnara.views.layouts.master'))

@section('content')

    <h1>Check Qcode</h1>
    <hr/>

    {!! Form::open( ['route' => 'mnara.authenticator.index', 'class' => 'form-horizontal']) !!}

    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::label('secret', 'Secret: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::text('code', $key, ['class' => 'form-control']) !!}
        </div>
        <div class="col-sm-2">
            <a href="{{route('mnara.authenticator.generate')}}" class="btn btn-warning form-control"><i class="
                                                                                                     fa fa-refresh"></i>" Generate</a>
        </div>
    </div>
    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::label('name', 'Name: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-4">
            <img src="{{ $googleUrl }}" alt="">
        </div>
    </div>
    <div class="form-group {{ $errors->has('code') ? 'has-error' : ''}}">
        {!! Form::label('code', 'Verification Code: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::text('code', null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-sm-2">
            @if ($valid)
                <div style="color: green; font-weight: 800;">VALID</div>
            @else
                <div style="color: red; font-weight: 800;">INVALID</div>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Validate', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection
