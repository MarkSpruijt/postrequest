@extends('app')

@section('content')
@if (Auth::User()->rank == 100)
	<a href="{{URL::to('account/edit')}}"><i class="fa fa-cog"></i> Wijzigen</a>					
@endif
@if($userdata->showedit)
<a href="{{URL::to('account/edit')}}"><i class="fa fa-cog"></i> Wijzigen</a>
@endif
<div class="profile_page">
	<img src="http://i2.pinger.pl/pgr1/a0dc4b1b000310fc4f5a21c2/Avatar.jpg">
	<h2>{{ $userdata->username }}</h2>
	<hr>
	Echte naam: {{ $userdata->realname }}<br>
	Rang: {{ $userdata->rank }}<br>
	<a href="{{URL::to('account/sendmail/'. $userdata->id)}}" class="button button-primary">Stuur e-mail</a>
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
