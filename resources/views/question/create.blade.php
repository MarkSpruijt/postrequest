@extends('app')

@section('content')
Vraag pagina enzo

{!!	Form::open()  !!}
	<div class="form-group">
		{!! Form::text('title',null,['placeholder' => 'De Titel.']) !!}
	</div>

	<div class="form-group">
		{!! Form::textarea('content',null,['placeholder' => 'Stel hier je vraag.']) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Vraag het aan de Community',['class' => 'btn btn-primary']) !!}
	</div>

{!! Form::close() !!}
<a href="{{URL::to('/')}}">Terug</a>
@endsection
