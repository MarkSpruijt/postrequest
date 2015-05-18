<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Post Request</title>
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>
<body>
	@if (Auth::guest())
	@else
		<a href="{{URL::to('/logout')}}">Uitloggen</a>
	@endif

	@yield('content')
	
</body>
</html>
