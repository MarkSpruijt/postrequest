<?php  namespace App\Http\Controllers;

use Auth;
use Validator;
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
}