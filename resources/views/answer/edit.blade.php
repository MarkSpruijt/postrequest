@extends('app')

@section('content')
	<h1>Antwoord bewerken</h1>
	{!!Form::open()!!}
	{!!Form::label('Antwoord')!!}
	{!!Form::text('content', $answer->content)!!}
	{!!Form::submit('Wijzigingen opslaan')!!}
	{!!Form::close()!!}
@endsection