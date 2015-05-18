@extends('app')

@section('content')
Index pagina enzo
<a href="{{ URL::to('question/create') }}">Create</a>

@foreach($questions as $question)
	<h2>{{ $question->title }}</h2><h5>{{ $question->content }}</h5></a>
	{{ date('d M Y H:m',strtotime($question->updated_at)) }}
@endforeach
@endsection
