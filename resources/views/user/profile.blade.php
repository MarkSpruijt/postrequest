@extends('app')

@section('content')

    <div class="profile_info">
        <img class="avatar profile" src="{{$userdata->avatar()}}">
        <div class="profile_buttons">
            @if($userdata->showedit)
                <a href="{{URL::to('account/edit/' .$userdata->id)}}"><i class="fa fa-cog"></i> Wijzig je profiel</a>
            @endif
            <a href="{{URL::to('account/sendmail/'. $userdata->id)}}" class="sendemail button button-primary"><i class="fa fa-envelope-o"></i> Stuur {{ $userdata->username }} een e-mail</a>
        </div>

        <h2>{{ $userdata->name() }}</h2>
        <hr><br>
        <span class="bold">Gebruikersnaam : &nbsp;</span>
        <span>{{ $userdata->username  }}</span><br><br>
        <span class="bold">Aantal Vragen: &nbsp;</span>
        <span>{{ $countquestions  }}</span><br><br>
        <span class="bold">Aantal Antwoorden: &nbsp;</span>
        <span>{{ $countanswers  }}</span>
        <p></p>
    </div><br>

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
