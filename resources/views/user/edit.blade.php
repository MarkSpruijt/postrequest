@extends('app')

@section('content')
	<h1>Wijzig account</h1>
	<p>{!! $errors->first('username') !!}</p>
	<p>{!! $errors->first('email') !!}</p>
	<p>{!! $errors->first('password') !!}</p>
	<p>{!! $errors->first('newpassword') !!}</p>
	<p>{!! $errors->first('newpassword2') !!}</p>
	{!! Form::open() !!}
			
			{!! Form::label('Gebruikersnaam') !!}
			{!! Form::text('username', $user['username']) !!}

			{!! Form::label('E-mail') !!}
			{!! Form::email('email', $user['email']) !!}

			{!! Form::label('Nieuw wachtwoord') !!}
			{!! Form::password('newpassword') !!}

			{!! Form::label('Herhaal nieuw wachtwoord') !!}
			{!! Form::password('newpassword2') !!}

			<hr>
			{!! Form::label('Huidig Wachtwoord') !!}
			{!! Form::password('password') !!}

			{!! Form::submit('Wijzig') !!}
		{!! Form::close() !!}
@endsection
