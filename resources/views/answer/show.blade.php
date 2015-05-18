@extends('app')

@section('content')
	<h1>Antwoorden</h1>
	@foreach($answers as $answer)
		<div class="answer" style="margin: 10px; background-color: #999;">
			<p>Votes: {{$answer->TotalVotes()}} <a href="{{URL::to('answer/vote/' . $answer['id'])}}">+</a></p>
			<p>{{$answer['content']}}</p>
			<p>{{$answer['created_at']}}</p>
			<p>{{$answer->User->username}}</p>
		</div>
	@endforeach
@endsection