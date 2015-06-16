@extends('app')

@section('content')
<div class="wrapper">
    <h1>Stel je vraag:</h1>
    {!!	Form::open()  !!}
            {!! Form::label('Titel') !!}<br/>
            {!! Form::text('title',null,['placeholder' => 'Titel', 'class' => 'title']) !!}
            {!! Form::label('Typ hier uw vraag') !!}<br/>
            {!! Form::textarea('content',null,['placeholder' => 'Stel hier uw vraag']) !!}
            {!! Form::label('Tags') !!}<br/>
            {!! Form::text('tags',null,['placeholder' => 'PHP, C#, SQL']) !!}
            {!! Form::submit('Vraag stellen') !!}
    {!! Form::close() !!}
</div>
@endsection
