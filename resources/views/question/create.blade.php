@extends('app')

@section('content')
    <div class="wrapper">
        <h1>Stel je vraag:</h1>
        {!!	Form::open()  !!}
                {!! Form::label('Titel') !!}<br/>
                {!! Form::text('title',null,['placeholder' => 'Titel', 'class' => 'title']) !!}
                {!! Form::label('Typ hier je vraag') !!}<br/>
                {!! Form::textarea('content',null,['placeholder' => 'De vraag']) !!}
                {!! Form::submit('Vraag stellen') !!}
        {!! Form::close() !!}
    </div>
@endsection
