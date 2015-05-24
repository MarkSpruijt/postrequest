@extends('app')

@section('content')
	<h1>Laatst gestelde vragen</h1>

	@foreach($questions as $question)
		<div class="question">
			<a href="{{ URL::to('question/'.$question['id']) }}">
				<p><strong>{{ $question->title }}</strong></p>

				<p class="info">{{ date('d M Y H:m',strtotime($question->updated_at)) }} {{$question->user->username}}</p>
			</a>
		</div>
		
	@endforeach
{{-- 
<div>
  {{ Markdown::render($content) }}
</div> --}}
@endsection
