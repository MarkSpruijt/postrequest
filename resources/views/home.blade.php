@extends('app')

@section('content')
	<h1>Laatst gestelde vragen</h1>

	@foreach($questions as $question)
		
			@if (isset($question->answer_id))
					<div class="question question_solved">
					<i class="fa solved fa-check"></i>
			@else
				<div class="question">
			@endif
			<a href="{{ URL::to('question/'.$question['id']) }}">
				@if (isset($question->answer_id))
					<i class="fa solved fa-check"></i>
			@else
				<div class="question">
			@endif
				<p><strong>{{ $question->title }}</strong></p>

				<p class="info">
				{{($question->updated_at->diffForHumans()) }} by: {{$question->user->username}}</p>
			</a>
		</div>
		
	@endforeach
{{-- 
<div>
  {{ Markdown::render($content) }}
</div> --}}
@endsection
