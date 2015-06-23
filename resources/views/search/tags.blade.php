@extends('app')

@section('content')
<h1>Zoekresultaten op "{{$tag}}"</h1>

@if(isset($questions))
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
@endif
@endsection