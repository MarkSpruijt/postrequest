@extends('app')

@section('content')

<h1>{{$question['title']}}</h1>
<p>{{$question['content']}}</p>
<h2>Antwoorden</h2>
	@foreach($question->answers as $answer)
		<div class="answer" style="margin: 10px; 
		@if($question['answer_id'] == $answer['id'])
			background-color: #0F0;
		@else
			background-color: #999;
		@endif">
			<p>Votes: {{$answer->TotalVotes()}} <a href="{{URL::to('answer/vote/' . $answer['id'])}}">+</a></p>

			<p>{{$answer['content']}}</p>
			<p>{{$answer['created_at']}}</p>
			<p>{{$answer->User->username}}</p>

			<!-- Juiste answer -->
			@if($question['answer_id'] == $answer->id)
			
				<!-- Owner van de vraag -->
				@if(Auth::user()->id == $question->user_id)
					<a href='{{ URL::to('question/'. $question['id'] . '/' . $answer['id'] . '/choose') }}'>Dit antwoord niet meer accepteren.</a>
				@else
					Dit antwoord is als geaccepteerd beschouwd door de desbetreffende vraagstellende gebruiker.
				@endif

			@else
				@if(Auth::user()->id == $question->user_id)
					<a href='{{ URL::to('question/'. $question['id'] . '/' . $answer['id'] . '/choose') }}'>Accepteer dit antwoord.</a>
				@endif
			@endif


		</div>
	@endforeach
	<a href="{{ URL::to('answer/create/'.$question['id']) }}"><button>Stuur antwoord</button></a>
@endsection
