@extends('app')

@section('content')
	<div class="question_detail" style="margin: 10px;"> 
		<h1>{{ucfirst($question['title'])}}</h1>
		<p class="question_content">{{$question['content']}}</p>
			@if($question->user_id == Auth::user()->id)
				<a href='{{ URL::to('question/edit/' . $question->id) }}'>Bewerk je vraag</a>
			@endif
	</div>
		<h2 class="answers">Antwoorden:</h2>
			@foreach($question->answers as $answer)
				<div class="question_answers">
				@if($question['answer_id'] == $answer['id'])
						<i class="fa question_checked fa-check fa-3"></i>
				@endif

				<p>Votes: {{$answer['votes']}}
					<a href="{{URL::to('answer/vote/' . $answer['id'])}}">
						<i title="Upvote!" class="fa fa-chevron-up"></i>
					</a>
				</p>

				<p>{{$answer['content']}}</p>

				<p class="post_info">{{ date('d M Y H:m',strtotime($question->updated_at)) }}<br>
				{{-- <a href="{{URL::to('profile/'. $answer->User->id )}}">{{$answer->User->username}}</p></a> --}}
				<a href="#">{{$answer->User->username}}</p></a>

				<!-- Juiste answer -->
				@if($question['answer_id'] == $answer->id)
					<!-- Owner van de vraag -->
					@if(Auth::user()->id == $question->user_id)
						<a href='{{ URL::to('question/'. $question['id'] . '/' . $answer['id'] . '/choose') }}'>Dit antwoord niet meer accepteren.</a>
						Dit antwoord is als geaccepteerd beschouwd door de desbetreffende vraagstellende gebruiker.
					@endif
				@else
					@if(Auth::user()->id == $question->user_id)
						<a href='{{ URL::to('question/'. $question['id'] . '/' . $answer['id'] . '/choose') }}'>
							Markeer dit als het juiste antwoord. <i class="fa fa-check"></i>
						</a>
					@endif
				@endif

				<!-- Edit button voor de eigenaar van het antwoord. -->
				@if(Auth::user()->id == $answer->user_id)
					<a href='{{ URL::to('answer/edit/' . $answer->id) }}'><i class="fa fa-pencil"></i></a>
				@endif

				<a href="{{ action('CommentController@getCreate', [$question->id, $answer->id]) }}">Reageer op dit antwoord.</a>

				<!-- Antwoorden -->
				@foreach($answer->comments as $comment)
					<div class="answer" style="margin: 10px;"> 
						<p class="post_info">{{ date('d M Y H:m',strtotime($question->updated_at)) }}<br>
							{{-- <a href="{{URL::to('profile/'. $comment->User->id )}}">{{$comment->user->username}}</a> --}}
							<a href="#">{{$comment->user->username}}</a></p><br>
						<p class="question_content">{{$comment->content}}</p>
				</div>
				@endforeach
		</div>
	@endforeach
	<a class="button" href="{{ URL::to('answer/create/'.$question['id']) }}">Stuur antwoord</a>
@endsection
