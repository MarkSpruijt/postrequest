@extends('app')

@section('content')
	<h1>Reactie Bewerken</h1>
	{!! Form::open() !!}
		{!! $errors->first('generic') !!}
		{!! $errors->first('content', '<label>:message</label>') !!}
		{!! Form::label('Reactie') !!}
		{!! Form::textarea('content', $comment->content) !!}

		{!! Form::submit('Wijzigingen opslaan') !!}
	{!! Form::close() !!}
@endsection
