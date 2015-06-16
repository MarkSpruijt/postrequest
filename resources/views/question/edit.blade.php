@extends('app')

@section('content')

<h2>Vraag bewerken</h2>
		<p>{!! $errors->first('title') !!}</p>
		<p>{!! $errors->first('content') !!}</p>
{!!	Form::open()  !!}
	<div class="form-group">
		{!! Form::label('Titel') !!}<br/>
		{!! Form::text('title', $question->title ,['placeholder' => 'De Titel.']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('Vraag') !!}<br/>
		{!! Form::textarea('content', $question->content,['placeholder' => 'Stel hier je vraag.']) !!}
	</div>
    <div class="form-group">
        {!! Form::label('Tags') !!}<br/>
        {!! Form::text('tags',$question->stringtags,['placeholder' => 'PHP, C#, SQL']) !!}
    </div>
	<div class="form-group">
		{!! Form::submit('Wijzigingen opslaan',['class' => 'btn btn-primary']) !!}
	</div>

{!! Form::close() !!}
@endsection
