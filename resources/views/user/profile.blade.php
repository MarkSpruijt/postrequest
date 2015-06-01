@extends('app')

@section('content')
<div class="profile_info">
	<h1>{{ $userdata->realname }}<span>&nbsp&nbsp&nbsp( {{ $userdata->username }} )</span></h1>
	E-mail: {{ $userdata->email }}<br><br>
	Rank: {{ $userdata->rank }}
</div>

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
@endsection
