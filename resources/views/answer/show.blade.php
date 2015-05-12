@extends('app')

@section('content')
	<h1>Antwoorden</h1>
	@foreach($answers as $answer)
		<div class="answer">
			<p>Votes: {{$answer->TotalVotes()}}</p>
			<p>{{$answer['content']}}</p>
			<p>{{$answer['created_at']}}</p>
		</div>
	@endforeach
@endsection