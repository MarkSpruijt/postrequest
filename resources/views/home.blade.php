@extends('app')

@section('content')
	<h1 class="main_title">Laatst gestelde vragen:</h1>

	@foreach($questions as $question)
		<a class="a_view" href="{{ URL::to('question/'.$question['id']) }}">
			@if (isset($question->answer_id))
					<div class="question question_solved">
					<i class="fa solved fa-check"></i>
			@else
				<div class="question a_view">
			@endif
				<p class="title"><strong>{{ $question->title }}</strong></p>
				<p class="info">
				{{($question->updated_at->diffForHumans()) }} by: {{$question->user->username}}</p>
			</div>
		</a>
	@endforeach
{{-- 
<div>
  {{ Markdown::render($content) }}
</div> --}}
@endsection
