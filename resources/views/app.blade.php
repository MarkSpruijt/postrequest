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
						@if (Auth::User()->rank == 100)
							<li><a href="{{URL::to('admin')}}">AdminPanel</a></li>					
						@endif
					<li><a href="">{{ Auth::User()->username}}</a></li>
					<li><a href="{{URL::to('account/logout')}}">Uitloggen</a></li>
				@endif
			</ul>
	</div>
	<div class="content frame">
		@yield('content')
	</div>
	<div class="footer frame">
		<p>PostRequest &copy;2015</p>
	</div>
</body>
</html>
