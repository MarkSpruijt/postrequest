@extends('app')

@section('content')
Vraag pagina enzo

{!!	Form::open()  !!}
	<div class="form-group">
		{!! Form::text('title',null) !!}
	</div>

	<div class="form-group">
		{!! Form::textarea('content',null) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Vraag het aan de Community',['class' => 'btn btn-primary']) !!}
	</div>

{!! Form::close() !!}
@endsection
