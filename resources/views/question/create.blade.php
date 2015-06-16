@extends('app')

@section('content')
<h1>Stel je vraag:</h1>
{!!	Form::open()  !!}
	<div class="form-group">
		{!! Form::label('Titel') !!}<br/>
		{!! Form::text('title',null,['placeholder' => 'Titel', 'class' => 'title']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('Typ hier je vraag') !!}<br/>
		{!! Form::textarea('content',null,['placeholder' => 'De vraag']) !!}
	</div>
    <div class="form-group">
        {!! Form::label('Tags') !!}<br/>
        {!! Form::text('tags',null,['placeholder' => 'PHP, C#, SQL']) !!}
    </div>
	<div class="form-group">
		{!! Form::submit('Vraag stellen',['class' => 'btn btn-primary']) !!}
	</div>

{!! Form::close() !!}
@endsection
