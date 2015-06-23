@extends('app')

@section('content')
<h1 class="wrapped">Wijzig account</h1>
@if(isset($message))
<p>{{$message}}</p>
@endif
<p>{!! $errors->first('username') !!}</p>
<p>{!! $errors->first('email') !!}</p>
<p>{!! $errors->first('password') !!}</p>
<p>{!! $errors->first('newpassword') !!}</p>
<p>{!! $errors->first('newpassword2') !!}</p>
{!! Form::open(['files' => true]) !!}

<div class="fileupload">
    {!! Form::label('Avatar') !!}<br>
    <img src="{{ $user->avatar() }}" class='avatar_medium'>
    {!! Form::file('avatar') !!}
</div>




{!! Form::label('Gebruikersnaam') !!}
{!! Form::text('username', $user['username'], array('class' => 'edit_form', 'placeholder'=>'je gebruikersnaam')) !!}

{!! Form::label('E-mail') !!}
{!! Form::email('email', $user['email'], array('class' => 'edit_form', 'placeholder'=>'E-mail')) !!}

{!! Form::label('Echte naam') !!}
{!! Form::text('realname',$user['realname'], array('class' => 'edit_form', 'placeholder'=>'Je echte naam')) !!}

{!! Form::label('Laat je naam zien op je profiel') !!}
{!! Form::checkbox('showrealname' , '1') !!}

{!! Form::label('Nieuw wachtwoord') !!}
{!! Form::password('newpassword', array('class' => 'edit_form', 'placeholder'=>'Nieuw wachtwoord')) !!}

{!! Form::label('Herhaal nieuw wachtwoord') !!}
{!! Form::password('newpassword2', array('class' => 'edit_form', 'placeholder'=>'Herhaal je nieuwe wachtwoord')) !!}
<br><br><br><hr>
{!! Form::label('Huidig Wachtwoord') !!}
{!! Form::password('password', array('class' => 'edit_form', 'placeholder'=>'Graag je huidige wachtwoord invullen')) !!}
{!! Form::submit('Wijzig je profiel.', array('class' => 'edit_form')) !!}
{!! Form::close() !!}
@endsection
