@extends('app')

@section('content')
@if($userdata->showedit)
	<a href="{{URL::to('account/edit')}}"><i class="fa fa-cog"></i> Wijzigen</a>
@endif
<div class="profile_page">
	<img class="avatar" src="{{$userdata->avatar()}}"><a href="{{URL::to('account/sendmail/'. $userdata->id)}}" class="sendemail button button-primary">Stuur e-mail</a>
	<h2>{{ $userdata->username }}</h2>
	<hr>

		Echte naam: {{ $userdata->realname }}<br>
	Rang: {{ $userdata->rank }}<br>
</div>

	@foreach($questions as $question)
		<a  href="{{ URL::to('question/'.$question['id']) }}"
			@if (isset($question->answer_id))
				class="question question_solved" >
				<i class="fa solved fa-check"></i>
			@else
				class="question">
			@endif
				<span class="title"><strong>{{ $question->title }}</strong></span>
				<span class="info">{{($question->updated_at->diffForHumans()) }} by: {{$question->user->username}}</span>
		</a>
	@endforeach
@endsection
