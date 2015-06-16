@extends('app')

@section('content')


	<div class="box">
        <div class="boxContent">
            <h1>{{ucfirst($question['title'])}}</h1>
            {!! Markdown::convertToHtml(HTML::entities($question['content'])) !!}
        @if($question->user_id == Auth::user()->id)
                <a href='{{ URL::to('question/edit/' . $question->id) }}'>Bewerk je vraag</a>
            @endif
        </div>
        <div class='boxFooter'>
            <div class="userBox">
                <img class="avatar_small" src="{{$question->User->avatar()}}">
                <label>{{ $question->updated_at->toDateTimeString() }}</label>
                <a href="{{URL::to('profile/'. $question->User->id )}}">{{$question->User->username}}</a>
            </div>
        </div>
    </div>

	<h2 class="answers">
        @if(count($question->answers))
            @if(count($question->answers) === 1)
                1 Antwoord:
            @else
                {{ count($question->answers) }} Antwoorden:
            @endif
        @else
            Er is nog geen antwoord op deze vraag.
        @endif
    </h2>
	@foreach($question->answers as $answer)

	@if($question['answer_id'] == $answer['id'])
	<div class="box answer answer_solved">
	@else
	<div class="box answer">
	@endif
        <div class="votes">
            <!-- Juiste answer vinkje -->
            @if($question['answer_id'] == $answer->id)
                <!-- Owner van de vraag -->
                @if(Auth::user()->id == $question->user_id)
                    <a href='{{ URL::to('question/'. $question['id'] . '/' . $answer['id'] . '/choose') }}'>
                        <i class="fa check active fa-check fa-3"></i>
                    </a>
                @else
                    <i class="fa check active fa-check fa-3"></i>
                @endif
            @else
                @if(Auth::user()->id == $question->user_id)
                    <a href='{{ URL::to('question/'. $question['id'] . '/' . $answer['id'] . '/choose') }}'>
                        <i class="fa check fa-check fa-3"></i></i>
                    </a>
                @endif
            @endif

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
        </div>

        <div class='boxContent'>
		    <p>{!! Markdown::convertToHtml(HTML::entities($answer['content'])) !!}</p>
            <!-- Edit button voor de eigenaar van het antwoord. -->
            @if(Auth::user()->id == $answer->user_id)
                <a href='{{ URL::to('answer/edit/' . $answer->id) }}'><i class="fa fa-pencil"></i>&nbsp Bewerk je antwoord</a>
            @endif
            <a href="{{ action('CommentController@getCreate', [$question->id, $answer->id]) }}">Reageer op dit antwoord.</a>
        </div>
        <div class="boxFooter">
            <div class="userBox">
                <img class="avatar_small" src="{{$answer->User->avatar()}}">
                <label>{{ $answer->updated_at->toDateTimeString() }}</label>
                <a href="{{URL::to('profile/'. $answer->User->id )}}">{{$answer->User->username}}</a>
            </div>
        </div>


		<!-- Antwoorden -->
        <h3>Reacties:</h3>
		@foreach($answer->comments as $comment)
			<div class="box answer">
                <div class="votes">
                    @if (!isset($comment->disablevote))
                        <a class="upvote" href="{{URL::to('comment/vote/' . $comment['id'])}}">
                            <i title="Upvote!" class="fa fa-chevron-up"></i><br>
                        </a>
                    @endif

                    <strong class="votecount">{{$comment['votes']}}</strong><br>
                    @if (!isset($comment->disablevote))
                        <a class="upvote" href="{{URL::to('comment/vote/' . $comment['id'] ."/0")}}">
                            <i title="Downvote!" class="fa fa-chevron-down"></i><br>
                        </a>
                    @endif
                </div>
                <div class="boxContent">
                    <p>{{$comment->content}}</p>
                    @if($comment->user_id == Auth::user()->id)
                        <a href='{{ action('CommentController@getEdit', [$question->id, $answer->id, $comment->id]) }}'>Bewerken</a>
                    @endif
                </div>
                <div class="boxFooter">
                    <div class="userBox">
                        <img class="avatar_small" src="{{$comment->User->avatar()}}">
                        <label>{{ $comment->updated_at->toDateTimeString() }}</label>
                        <a href="{{URL::to('profile/'. $comment->User->id )}}">{{$comment->User->username}}</a>
                    </div>
                </div>

			</div><!-- close regel 75 -->
		@endforeach
	</div><!-- close regel 45 -->

	@endforeach
	<a class="button" href="{{ URL::to('answer/create/'.$question['id']) }}">Stuur antwoord</a>
@endsection
