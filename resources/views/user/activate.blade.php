@extends('app')

@section('content')
		<h1>Activeer account</h1>
		<p>{!! $errors->first('username') !!}</p>
		<p>{!! $errors->first('password') !!}</p>
		<p>{!! $errors->first('password2') !!}</p>		

		{!! Form::open() !!}
			
			{!! Form::label('Gebruikersnaam') !!}
			{!! Form::text('username') !!}
			{!! Form::label('Wachtwoord') !!}
			{!! Form::password('password') !!}
			{!! Form::label('Bevestig wachtwoord') !!}
			{!! Form::password('password2') !!}

			{!! Form::submit('Activeer') !!}
		{!! Form::close() !!}
@endsection
