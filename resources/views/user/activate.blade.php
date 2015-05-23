@extends('app')

@section('content')
		<h1>Activeer account</h1>
		{!! Form::open() !!}
			@if(isset($error))<p>{{$error}}</p> @endif
			{!! Form::label('Gebruikersnaam') !!}
			{!! Form::text('username') !!}
			{!! Form::label('Wachtwoord') !!}
			{!! Form::password('password') !!}
			{!! Form::label('Bevestig wachtwoord') !!}
			{!! Form::password('password2') !!}

			{!! Form::submit('Activeer') !!}
		{!! Form::close() !!}
@endsection
