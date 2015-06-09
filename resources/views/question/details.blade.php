@extends('app')

@section('content')
	<div class="box">
		<div class="box_inner_small">
			{{ $question->updated_at->toDateTimeString() }}<br>
			<img class="avatar_small" src="{{$question->User->avatar()}}"><br>
			<a href="{{URL::to('profile/'. $question->User->id )}}">{{$question->User->username}}</a>
		</div> <!-- close regel 5 -->

		<div class="box_inner_large">
			<h1>{{ucfirst($question['title'])}}</h1><hr>
			{!! Markdown::convertToHtml(HTML::entities($question['content'])) !!}
			@if($question->user_id == Auth::user()->id)
				<a href='{{ URL::to('question/edit/' . $question->id) }}'>Bewerk je vraag</a>
			@endif
		</div> <!-- close regel 11 -->
	</div><!-- close regel 4 -->
		<h2 class="answers">Antwoorden:</h2>
			@foreach($question->answers as $answer)
				@if($question['answer_id'] == $answer['id'])
					<div class="box answer answer_solved">
				@else
					<div class="box answer">
				@endif
					<div class="box_inner_small">
						{{ $answer->updated_at->toDateTimeString() }}<br>
						<img class="avatar_small" src="{{$answer->User->avatar()}}"><br>
						<a href="{{URL::to('profile/'. $answer->User->id )}}">{{$answer->User->username}}</a><br><br>
						@if (!isset($answer->disablevote))
							<a class="upvote" href="{{URL::to('answer/vote/' . $answer['id'])}}">
							<i title="Upvote!" class="fa fa-chevron-up"></i><br>
							</a>
						@endif

						<strong class="votecount">{{$answer['votes']}}</strong><br>
						@if (!isset($answer->disablevote))
							<a class="upvote" href="{{URL::to('answer/vote/' . $answer['id'] ."/0")}}">
							<i title="Downvote!" class="fa fa-chevron-down"></i><br>
							</a>
						@endif
					</div> <!-- close regel 26 -->


					<div class="box_inner_large">
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
					<p>{!! Markdown::convertToHtml(HTML::entities($answer['content'])) !!}</p>


					

				<!-- Edit button voor de eigenaar van het antwoord. -->
				@if(Auth::user()->id == $answer->user_id)
					<a href='{{ URL::to('answer/edit/' . $answer->id) }}'><i class="fa fa-pencil"></i>&nbsp Bewerk je antwoord</a><br><br>
				@endif

				<a href="{{ action('CommentController@getCreate', [$question->id, $answer->id]) }}">Reageer op dit antwoord.</a>

				<!-- Antwoorden -->
				@foreach($answer->comments as $comment)
					<div class="box"> 
						<div class="box_inner_small">
							{{ $comment->updated_at->toDateTimeString() }}<br>
							<img class="avatar_small" src="{{$comment->User->avatar()}}"><br>
							<a href="{{URL::to('profile/'. $comment->User->id )}}">{{$comment->User->username}}</a><br><br>
							@if (!isset($comment->disablevote))
							<a class="upvote" href="{{URL::to('comment/vote/' . $answer['id'])}}">
							<i title="Upvote!" class="fa fa-chevron-up"></i><br>
							</a>
					@endif

						<strong class="votecount">{{$answer['votes']}}</strong><br>
						@if (!isset($comment->disablevote))
							<a class="upvote" href="{{URL::to('comment/vote/' . $answer['id'] ."/0")}}">
							<i title="Downvote!" class="fa fa-chevron-down"></i><br>
							</a>
						@endif
						</div> <!-- close regel 76 -->
						<div class="box_inner_large"><p>{{$comment->content}}</p>
						@if($comment->user_id == Auth::user()->id)
							<a href='{{ action('CommentController@getEdit', [$question->id, $answer->id, $comment->id]) }}'>Bewerken</a>
						</div>	<!-- close regel 93 -->
					@endif
				</div><!-- close regel 75 -->
				@endforeach
			</div><!-- close regel 45 -->
		</div> <!-- close regel 24 / 22 -->
	@endforeach
	<a class="button" href="{{ URL::to('answer/create/'.$question['id']) }}">Stuur antwoord</a>
@endsection
