<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Post Request</title>
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('/css/font-awesome.min.css')}}">
</head>
<body>
	<div class="header frame">
			<img class="logo" src="{{ asset('images/postrequest.png') }}" alt="Header">
			<ul class="menu">
				@if (Auth::guest())
					<li><a href="{{URL::to('account/login')}}">Inloggen</a></li>
				@else
					<li><a href="{{URL::to('/')}}">Overzicht</a></li>
					<li><a href="{{URL::to('ask')}}">Vraag stellen</a></li>
					<li><a href="{{URL::to('account/logout')}}">Uitloggen</a></li>
				@endif
			</ul>
	</div>
	<div class="content frame">

		@yield('content')


		<!-- This is for the solved thing, so we can find what classes mark used. they may be removed when solved is up and running. -->
		<div class="question question_solved">
			<a href="http://localhost/postrequest/public/question/1">
				<p><strong>Parse: Query local database is 20 times slower then sqlite</strong></p>
				<i class="fa fa-check solved"></i>
				<p class="info">2015-05-23 20:28:33 Leerling A</p>
			</a>
		</div>



	</div>
	<div class="footer frame">
		<p>PostRequest &copy;2015</p>
	</div>
</body>
</html>
