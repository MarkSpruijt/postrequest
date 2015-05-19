@extends('admin')

@section('content')

<h3>Gebruiker(s) toevoegen</h3>
<p>Gebruik een komma(,) om email adressen te scheiden. Gebruik alleen een komma als u meerdere accounts wilt aanmaken</p>
{!!	Form::open()  !!}
		{!! Form::textarea('emails',null,['placeholder' => 'E-mail(s)']) !!}
		{!! Form::submit('Verstuur') !!}
{!! Form::close() !!}
<a href="{{URL::to('admin')}}">Terug</a>
@endsection
