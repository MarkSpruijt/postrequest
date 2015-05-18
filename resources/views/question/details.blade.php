@extends('app')

@section('content')

<h1>{{$question['title']}}</h1>
<p>{{$question['content']}}</p>
<h2>Antwoorden</h2>
	@foreach($answers as $answer)
		<div class="answer" style="margin: 10px; background-color: #999;">
			<p>Votes: {{$answer->TotalVotes()}} <a href="{{URL::to('answer/vote/' . $answer['id'])}}">+</a></p>
			<p>{{$answer['content']}}</p>
			<p>{{$answer['created_at']}}</p>
			<p>{{$answer->User->username}}</p>
		</div>
	@endforeach
	<a href="{{ URL::to('answer/create/'.$question['id']) }}"><button>Stuur antwoord</button></a>
@endsection
