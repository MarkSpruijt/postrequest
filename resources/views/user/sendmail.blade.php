@extends('app')

@section('content')
    <h1>Stuur een email naar: {{$user->username}}</h1>

    {!! Form::open() !!}
      {!! Form::label('Bericht') !!}
      {!! Form::textarea('content', Null,['class'=>'u-full-width', 'placeholder' => 'Voer hier uw bericht in...']) !!}
      {!! Form::submit('Verstuur', ['class'=>'button-primary']) !!}
      <a href="{{URL::to('profile/' . $user->id)}}" class="button">Annuleren</a>
    {!! Form::close() !!}

@endsection
