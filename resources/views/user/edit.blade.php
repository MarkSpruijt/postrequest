@extends('app')

@section('content')
	<h1>Wijzig account</h1>
	@if(isset($message))
		<p>{{$message}}</p>
	@endif
	<p>{!! $errors->first('username') !!}</p>
	<p>{!! $errors->first('email') !!}</p>
	<p>{!! $errors->first('password') !!}</p>
	<p>{!! $errors->first('newpassword') !!}</p>
	<p>{!! $errors->first('newpassword2') !!}</p>
	{!! Form::open(['files' => true]) !!}
			
			{!! Form::label('Gebruikersnaam') !!}
			{!! Form::text('username', $user['username']) !!}
        @if (Auth::User()->rank == 100)
            {!! Form::label('Echte naam') !!}
            {!! Form::text('realname',$user['realname']) !!}
        @else

        @endif

			{!! Form::label('E-mail') !!}
			{!! Form::email('email', $user['email']) !!}

			{!! Form::label('Avatar') !!}
			<img src="{{ $user->avatar() }}" class='avatar'>
			{!! Form::file('avatar') !!}

        @if (Auth::User()->rank == 100)

        @else
			{!! Form::label('Nieuw wachtwoord') !!}
			{!! Form::password('newpassword') !!}

			{!! Form::label('Herhaal nieuw wachtwoord') !!}
			{!! Form::password('newpassword2') !!}

			<hr>
			{!! Form::label('Huidig Wachtwoord') !!}
			{!! Form::password('password') !!}
        @endif
			{!! Form::submit('Wijzig') !!}
		{!! Form::close() !!}
@endsection
