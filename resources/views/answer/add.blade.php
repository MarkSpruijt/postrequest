@extends('app')

@section('content')
	<h1>Antwoord toevoegen</h1>
	{!!Form::open()!!}
	{!!Form::label('content')!!}
	{!!Form::text('content')!!}
	{!!Form::submit('Verstuur')!!}
	{!!Form::close()!!}
@endsection