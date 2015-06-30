@extends('app')

@section('content')
	<h1 class="main_title">Laatst gestelde vragen:</h1>

	@foreach($questions as $question)
		<a  href="{{ URL::to('question/'.$question['id']) }}"
			@if (isset($question->answer_id))
				class="question question_solved" >
				<i class="fa solved fa-check"></i>
			@else
				class="question">
			@endif
				<span class="title"><strong>{{ $question->title }}</strong></span>
				<span class="info">{{($question->created_at->diffForHumans()) }} by: {{$question->user->username}}</span>
				<span class="info">Views: {{$question->viewcount}} - </span>
		</a>
	@endforeach
@endsection
