@extends('app')

@section('content')

<h3>Gebruiker(s) toevoegen</h3>
	@if(isset($message))
		<p>{{$message}}</p>
	@endif
	
{!!	Form::open()  !!}
		{!! Form::label("Naam") !!}
		{!! Form::text("realname") !!}
		{!! Form::label("E-mail") !!}
		@if(Session::has('user'))
			<a href="{{ URL::to('/')}}">Bewerk de gebruiker met dit email adres: {{ Session::get('user')->email }}</a>
		@endif
		{!! Form::email("email") !!}
		{!! Form::label("Rank") !!}
		{!! Form::select("rank", [0 => 'Leerling', 100 => "Docent"]) !!}
		{!! Form::submit('Verstuur') !!}
{!! Form::close() !!}
<a class="button"href="{{URL::to('admin')}}">Terug</a>
@endsection
