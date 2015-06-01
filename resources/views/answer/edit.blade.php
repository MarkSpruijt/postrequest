@extends('app')

@section('content')
	@foreach ($errors->all() as $error)
		<p class="error">{{ $error}}</p>
	@endforeach
	<h1>Antwoord bewerken</h1>
	{!!Form::open()!!}
	{!!Form::label('Antwoord')!!}<br/>
	{!!Form::textarea('content', $answer->content)!!}
	{!!Form::submit('Wijzigingen opslaan')!!}
	{!!Form::close()!!}
@endsection