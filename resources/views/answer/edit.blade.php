@extends('app')

@section('content')
	<h1>Antwoord bewerken</h1>
	{!!Form::open()!!}
	{!!Form::label('content')!!}
	{!!Form::text('content', $answer->content)!!}
	{!!Form::submit('Verstuur')!!}
	{!!Form::close()!!}
@endsection