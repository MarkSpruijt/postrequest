@extends('app')

@section('content')
    <h1>Zoeken op tag</h1>

    {!!Form::Open()!!}
    {!!Form::Text('tag', null, ['placeholder' => 'Voer hier uw tag in'])!!}
    {!!Form::Submit("Zoeken")!!}
    {!!Form::Close()!!}
@endsection