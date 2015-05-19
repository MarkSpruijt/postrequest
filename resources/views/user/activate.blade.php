@extends('app')

@section('content')
		<h1>Activeer account</h1>
		{!! Form::open() !!}
			@if(isset($error))<p>{{$error}}</p> @endif
			{!! $errors->first('password', '<label>:message</label>') !!}
			{!! Form::label('wachtwoord') !!}
			{!! Form::password('password') !!}
			{!! Form::label('bevestig wachtwoord') !!}
			{!! Form::password('password2') !!}

			{!! Form::submit('Activeer') !!}
		{!! Form::close() !!}
@endsection
