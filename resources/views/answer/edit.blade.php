@extends('app')

@section('content')
	<h1>Antwoord bewerken</h1>
	{!!Form::open()!!}
	{!!Form::label('Antwoord')!!}<br/>
	{!!Form::textarea('content', $answer->content)!!}
	{!!Form::submit('Wijzigingen opslaan')!!}
	{!!Form::close()!!}
@endsection