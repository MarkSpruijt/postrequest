@extends('app')

@section('content')
    <h1>Stel je vraag:</h1>
    <div class="wrapper">
    {!!	Form::open()  !!}
    {!! Form::label('Titel') !!}
    {!! Form::text('title',null,['placeholder' => 'Titel', 'class' => 'title']) !!}
    {!! Form::label('Typ hier uw vraag') !!}
    {!! Form::textarea('content',null,['placeholder' => 'Stel hier uw vraag']) !!}
    {!! Form::label('Tags') !!}
    {!! Form::text('tags',null,['placeholder' => 'PHP, C#, SQL']) !!}
    {!! Form::submit('Vraag stellen') !!}
    {!! Form::close() !!}
</div>
@endsection
