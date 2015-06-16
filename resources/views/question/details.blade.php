@extends('app')

@section('content')


	<div class="box">
        <div class="boxContent">
            <h1>{{ucfirst($question['title'])}}</h1>
            {!! Markdown::convertToHtml(HTML::entities($question['content'])) !!}
        </div>

        <div class='boxFooter'>
            <ul class="tags">
                <li>Tags:</li>
                <li><a href="#">PHP</a></li>
                <li><a href="#">PHP</a></li>
                <li><a href="#">PHP</a></li>
                <li><a href="#">PHP</a></li>
                <li><a href="#">PHP</a></li>
                <li><a href="#">PHP</a></li>
                <li><a href="#">PHP</a></li>
                <li><a href="#">PHP</a></li>
                <li><a href="#">PHP</a></li>
                <li><a href="#">PHP</a></li>
                <li><a href="#">PHP</a></li>
                <li><a href="#">VAGRANT</a></li>
            </ul>
            <div class="userBox">
                <img class="avatar_small" src="{{$question->User->avatar()}}">
                <label>{{ $question->created_at->toDateTimeString() }}</label>
                <a href="{{URL::to('profile/'. $question->User->id )}}">{{$question->User->username}}</a>
            </div>
            @if($question->user_id == Auth::user()->id)
                <a href='{{ URL::to('question/edit/' . $question->id) }}'>Vraag bewerken</a>
            @endif
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
            Er is nog geen antwoord op deze vraag
        @endif
    </h2>
    <a class="button" href="{{ URL::to('answer/create/'.$question['id']) }}">Antwoord toevoegen</a>
    @foreach($question->answers as $answer)

	@if($question['answer_id'] == $answer['id'])
	<div class="box answer solved">
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

            {{-- UPVOTE --}}
            @if (!isset($answer->disablevote))
                <a class="upvote" href="{{URL::to('answer/vote/' . $answer['id'])}}">
                    <i title="Upvote!" class="fa fa-chevron-up"></i>
                </a>
            @elseif($answer->userVote == 1)
                {{-- USER HAS VOTED --}}
                <i title="Upvote!" class="fa fa-chevron-up upvoted"></i>
            @else
                <i title="Upvote!" class="fa fa-chevron-up"></i>
            @endif

            {{-- NUMBER --}}
            <strong class="votecount">{{$answer['votes']}}</strong>

            {{-- DOWNVOTE --}}

            @if (!isset($answer->disablevote))
                <a class="upvote" href="{{URL::to('answer/vote/' . $answer['id'] ."/0")}}">
                    <i title="Downvote!" class="fa fa-chevron-down"></i>
                </a>
            @elseif($answer->userVote === 0)
                <i title="Downvote!" class="fa fa-chevron-down downvoted"></i>
            @else
                <i title="Downvote!" class="fa fa-chevron-down"></i>
            @endif
        </div>

        <div class='boxContent'>
		    <p>{!! Markdown::convertToHtml(HTML::entities($answer['content'])) !!}</p>

        </div>
        <!-- Edit button voor de eigenaar van het antwoord. -->
        <div class="boxFooter">
            <div class="userBox">
                <img class="avatar_small" src="{{$answer->User->avatar()}}">
                <label>{{ $answer->updated_at->toDateTimeString() }}</label>
                <a href="{{URL::to('profile/'. $answer->User->id )}}">{{$answer->User->username}}</a>
            </div>
        </div>
        <a href="{{ action('CommentController@getCreate', [$question->id, $answer->id]) }}">Reactie toevoegen</a>
        @if(Auth::user()->id == $answer->user_id)
            <a class='button' href='{{ URL::to('answer/edit/' . $answer->id) }}'>Antwoord bewerken</a>
            @endif
		<!-- Comments op het antwoord -->
        @if(count($answer->comments) === 1)
            <h3>1 Reactie:</h3>
        @elseif(count($answer->comments) !== 0)
            <h3>{{ count($answer->comments) }} reacties:</h3>
        @endif

		@foreach($answer->comments as $comment)
			<div class="box comment">
                <div class="votes">
                    @if (!isset($comment->disablevote))
                        <a class="upvote" href="{{URL::to('comment/vote/' . $comment['id'])}}">
                            <i title="Upvote!" class="fa fa-chevron-up"></i>
                        </a>
                    @elseif($comment->userVote === 1)
                        <i title="Upvote!" class="fa fa-chevron-up upvoted"></i>
                    @else
                        <i title="Upvote!" class="fa fa-chevron-up"></i>
                    @endif

                    <strong class="votecount">{{$comment['votes']}}</strong><br>
                    @if (!isset($comment->disablevote))
                        <a class="upvote" href="{{URL::to('comment/vote/' . $comment['id'] ."/0")}}">
                            <i title="Downvote!" class="fa fa-chevron-down"></i>
                        </a>
                    @elseif($comment->userVote === 0)
                        <i title="Downvote!" class="fa fa-chevron-down downvoted"></i>
                    @else
                        <i title="Downvote!" class="fa fa-chevron-down"></i>
                    @endif
                </div>
                <div class="boxContent">
                    <p>{{$comment->content}}</p>
                </div>
                <div class="boxFooter">
                    @if($comment->user_id == Auth::user()->id)
                        <a href='{{ action('CommentController@getEdit', [$question->id, $answer->id, $comment->id]) }}'>Reactie bewerken</a>
                    @endif
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
@endsection
