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
					<!-- Juiste answer -->
				@if($question['answer_id'] == $answer->id)
					<!-- Owner van de vraag -->
					@if(Auth::user()->id == $question->user_id)
						<a href='{{ URL::to('question/'. $question['id'] . '/' . $answer['id'] . '/choose') }}'><i class="fa checked fa-check fa-3"></i></a>
					@else
						<i class="fa checked2 fa-check fa-3"></i>
					@endif
				@else
					@if(Auth::user()->id == $question->user_id)
						<a href='{{ URL::to('question/'. $question['id'] . '/' . $answer['id'] . '/choose') }}'>
							<i class="fa unchecked fa-check fa-3"></i></i>
						</a>
					@endif
				@endif
				<p>Votes: {{$answer['votes']}}
					<a href="{{URL::to('answer/vote/' . $answer['id'])}}">
						<i title="Upvote!" class="fa fa-chevron-up"></i>
					</a>
				</p>

				<p>{{$answer['content']}}</p>

				<p class="post_info">{{ date('d M Y H:m',strtotime($question->updated_at)) }}<br><a href="{{URL::to('profile/'. $answer->User->username )}}">{{$answer->User->username}}</p></a>

				<!-- Edit button voor de eigenaar van het antwoord. -->
				@if(Auth::user()->id == $answer->user_id)
					<a href='{{ URL::to('answer/edit/' . $answer->id) }}'><i class="fa fa-pencil"></i>&nbsp Berwerk je antwoord</a><br><br>
				@endif

				<a href="{{ action('CommentController@getCreate', [$question->id, $answer->id]) }}">Reageer op dit antwoord.</a>

				<!-- Antwoorden -->
				@foreach($answer->comments as $comment)
					<div class="answer" style="margin: 10px;"> 
						<p class="post_info">{{ date('d M Y H:m',strtotime($question->updated_at)) }}<br><a href="{{URL::to('profile/'. $comment->User->username )}}">{{$comment->user->username}}</a></p><br>
						<p class="question_content">{{$comment->content}}</p>
				</div>
				@endforeach
		</div>
	@endforeach
	<a class="button" href="{{ URL::to('answer/create/'.$question['id']) }}">Stuur antwoord</a>
@endsection
