@extends('app')

@section('content')
	<h1>Antwoord toevoegen</h1>
	{!!Form::open()!!}
	{!!Form::label('Antwoord')!!}<br/>
	{!!Form::textarea('content')!!}
	{!!Form::submit('Toevoegen')!!}
	{!!Form::close()!!}
@endsection