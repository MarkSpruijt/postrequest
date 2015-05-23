@extends('admin')

@section('content')

<h3>Gebruiker(s) toevoegen</h3>
{!!	Form::open()  !!}
		{!! Form::label("Naam") !!}
		{!! Form::text("realname") !!}
		{!! Form::label("E-mail") !!}
		{!! Form::email("email") !!}
		{!! Form::label("Rank") !!}
		{!! Form::select("rank", [0 => 'Leerling', 100 => "Docent"]) !!}
		{!! Form::submit('Verstuur') !!}
{!! Form::close() !!}
<a href="{{URL::to('admin')}}">Terug</a>
@endsection
