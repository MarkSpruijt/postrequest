@extends('app')

@section('content')
    <ul class='messages'>
        @if(Session::has('user'))
            <li class='error'><a href="{{ URL::to('/admin/edituser/'. Session::get('user')->id)}}">Bewerk de gebruiker met dit email adres: {{ Session::get('user')->email }}</a></li>
        @endif
    </ul>
<h3>Gebruiker(s) toevoegen</h3>
	@if(isset($message))
		<p>{{$message}}</p>
	@endif
	
{!!	Form::open()  !!}
		{!! Form::label("Naam") !!}
		{!! Form::text("realname") !!}
		{!! Form::label("E-mail") !!}

		{!! Form::email("email") !!}
		{!! Form::label("Rank") !!}
		{!! Form::select("rank", [0 => 'Leerling', 100 => "Docent"]) !!}
		{!! Form::submit('Verstuur') !!}
{!! Form::close() !!}
<a class="button"href="{{URL::to('admin')}}">Terug</a>
@endsection
