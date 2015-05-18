@extends('app')

@section('content')
	<h1>Reactie plaatsen</h1>
	{!! Form::open() !!}
		{!! $errors->first('generic') !!}
		{!! $errors->first('content', '<label>:message</label>') !!}
		{!! Form::label('Reactie') !!}
		{!! Form::textarea('content') !!}

		{!! Form::submit('Reactie plaatsen') !!}
	{!! Form::close() !!}
@endsection
