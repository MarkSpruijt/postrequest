@extends('app')

@section('content')
<a class="button" href="{{URL::to('admin/adduser')}}">Gebruiker(s) toevoegen</a>	
	<table class="u-full-width">
  		<thead>
		    <tr>
		      <th>Name</th>
		      <th>Gebruikersnaam</th>
		      <th>Rank</th>
		      <th>E-mail</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($users as $user)
		    	<tr>		    	
			      <td><a href="{{URL::to('/profile/' .$user->id)}}">{{ $user->realname }}</a></td>
			      <td>{{ $user->username }}</td>
			      <td>{{ $user->rank }}</td>
			      <td>{{ $user->email }}</td>
		    	</tr>
		    @endforeach
		  </tbody>
	</table>
	
@endsection