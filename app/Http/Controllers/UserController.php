<?php  namespace App\Http\Controllers;

use Auth;
use Hash;
use Validator;
use App\Models\User;
use App\Models\Questions;
use Illuminate\Http\Request;

class UserController extends Controller{
	
	public function getLogin()
	{
		return view('user.login');

	}

	public function postLogin(Request $request)
	{

		$credentials = $request->only('email', 'password');

		$v = Validator::make(
			$credentials,
			[
				'email' => 'required|email', 
				'password' => 'required'
			]
		);

		$v->setAttributeNames(['email' => 'e-mail', 'password' => 'wachtwoord']);

		if($v->fails())
		{
			$request->flash();
			return redirect()->action('UserController@getLogin')->withErrors($v->messages());
		}

		if(Auth::attempt($credentials))
		{
			return redirect()->intended('/');
		}
		
		$request->flash();
		$v->messages()->add('generic', 'Verkeerde wachtwoord en/of email');
		return redirect()->action('UserController@getLogin')->withErrors($v->messages());

	}

	public function getLogout()
	{
		Auth::logout();
		return redirect()->action('UserController@getLogin');
	}

	public function getActivate($key){
		return view('user.activate');
	}

	public function postActivate($key, Request $request){
		$user = User::where('key', $key)->first();
		if(!isset($user->email)){
			return view('user.activate')->with('error', 'Geen account gevonden om te activeren.');
		}

		$credentials = $request->only('username', 'password','password2');

		$v = Validator::make(
			$credentials,
			[
				'username' => 'required|unique:users', 
				'password' => 'required|min:8',
				'password2' => 'same:password'
			]
		);

		$v->setAttributeNames(['username' => 'Gebruikersnaam', 'password' => 'Wachtwoord', 'password2' => 'Wachtwoord bevestiging']);

		if($v->fails())
		{
			$request->flash();
			return redirect()->back()->withErrors($v->messages());
		}


		$user->username = $request->username;
		$user->password = Hash::make($request->password);
		$user->key = NULL;
		$user->save();

		return redirect('/');
	}

	public function getProfile(Request $request, $id){
	  $userdata = User::find($id);
	  $questions = $userdata->questions;
	  return view('user/profile')->withuserdata($userdata)->withquestions($questions);
	}
}