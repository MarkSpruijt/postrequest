<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Post Request</title>
		<link href="{{ asset('/css/app3.css') }}" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="{{ asset('/css/font-awesome.min.css')}}">
</head>
<body>
    <nav>
        <a href="{{URL::to('/')}}"><img class="logo" src="{{ asset('images/postrequest.png') }}" alt="Header"></a>
        <ul>
            @if (!Auth::guest())
                <li><a href="{{URL::to('/')}}">Overzicht</a></li>
                <li><a href="{{URL::to('ask')}}">Vraag stellen</a></li>
                <li><a href="{{URL::to('search')}}">Zoeken</a></li>
                @if (Auth::User()->rank == 100)
                    <li><a href="{{URL::to('admin')}}">Beheer</a></li>
                @endif
                <li><a href="{{URL::to('profile/'. Auth::User()->id )}}">Mijn Profiel</a></li>
                <li><a href="{{URL::to('account/logout')}}">Uitloggen</a></li>
            @endif
        </ul>
    </nav>
    <section>
    <?php
    if(Session::has('messages'))
    $messages = Session::get('messages');
    ?>
    @if(isset($messages))
        <ul class='messages'>
				@foreach($messages['messages'] as $message)
				<li class='{{ $messages['type'] }}'>{{ ucfirst($messages['type']) }}: {{ $message }}</li>
				@endforeach
		</ul>
	@endif

	@yield('content')
    </section>

	<footer>
		<p class="footertext">PostRequest &copy;2015</p>
	</footer>
</body>
</html>
