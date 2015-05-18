@extends('app')

@section('content')
Index pagina enzo
<a href="{{ URL::to('question/create') }}">Create</a>

@foreach($questions as $question)
	<a href="{{ URL::to('question/'.$question['id']) }}"><h2>{{ $question->title }}  -  {{ date('d M Y H:m',strtotime($question->updated_at)) }}</h2></a>
	
@endforeach
@endsection
