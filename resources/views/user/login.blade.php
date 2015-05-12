@extends('app')

@section('content')
	{!! Form::open() !!}
		{!! $errors->first('generic') !!}
		{!! $errors->first('email', '<label>:message</label>') !!}
		{!! Form::label('e-mail') !!}
		{!! Form::text('email') !!}

		{!! $errors->first('password', '<label>:message</label>') !!}
		{!! Form::label('wachtwoord') !!}
		{!! Form::password('password') !!}

		{!! Form::submit('Inloggen') !!}
	{!! Form::close() !!}
@endsection