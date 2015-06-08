<?php  namespace App\Http\Controllers;

use App;
use Mail;
use Hash;
use Auth;
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
		$user = User::where('key', $key)->first();
		if($user == NULL){
			return App::abort(404);
		}

		return view('user.activate');
	}

	public function postActivate($key, Request $request){
		$user = User::where('key', $key)->first();
		if($user == NULL){
			return App::abort(404);
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
	  if($userdata->id == Auth::User()->id)
	  {
	  	$userdata->showedit = true;
	  }
	  return view('user/profile')->withuserdata($userdata)->withquestions($questions);
	}

	public function getEdit(){
		$user = User::find(Auth::user()->id);
		return view('user.edit')->with('user', $user);
	}

	public function postEdit(Request $request){
		$user = User::find(Auth::user()->id);
		
		$failed = false;

		$credentials = $request->only('username','email', 'password');
		$validator = Validator::make($credentials, ['username' => "required|unique:users,id,{$user['id']}",'email' => "required|unique:users,id,{$user['id']}",'password' => 'required']);
		$validator->setAttributeNames(['username' => 'Gebruikersnaam', 'password' => 'Huidig wachtwoord', 'email' => 'E-mail']);
		
		if($validator->fails())
		{
			$failed = true;
		}

		// Klopt het huidige wachtwoord?
		if(!Auth::validate(['email' => $user->email, 'password' => $request->get('password')]))
		{
			$request->flash();
			return redirect()->back()->withMessages(["type" => "error","messages" => ["Huidig wachtwoord incorrect."]]);
		}
		
		$user->username = $request->input('username');
		$user->email = $request->input('email');

		// Update password if needed.
		if(!empty($request->input('newpassword')) || !empty($request->input('newpassword2'))){
			$credentials = $request->only('newpassword','newpassword');
			$v = Validator::make($credentials, ['newpassword' => 'required|min:8', 'newpassword2' => 'same:password']);
			$v->setAttributeNames(['newpassword' => 'Nieuwe wachtwoord', 'newpassword2' => 'Wachtwoord bevestiging']);
			if($v->fails())
			{
				$failed = true;
				$validator->messages()->merge($v->messages());
			}
			$user->password = Hash::make($request->input('newpassword'));
		}

		// Update image if needed.
		if($request->hasFile('avatar'))
		{
			$avatar = $request->file('avatar');
			$v = Validator::make(['avatar' => $avatar], ['avatar' => 'mimes:jpeg,jpg,png|image|max:500']);
			$v->setAttributeNames(['avatar' => 'Avatar']);

			if($v->fails())
			{
				$failed = true;
				$validator->messages()->merge($v->messages());
			}
			else
			{			
				$user = Auth::user();
				$user->deleteAvatar();

				// Replace it with the new one.
				$avatar->move('avatars', $user->id . '.' . $avatar->getClientOriginalExtension());
			}

		}

		// als er iets fout gegaan is
		if($failed)
		{
			$request->flash();

			return redirect()->back()->withMessages(["type" => "error","messages" => $validator->messages()->all()]);
		}
		$user->save();
		$request->flash();
		return redirect()->back()->withMessages(["type" => "info","messages" => ["Gebruikers gegevens gewijzigd."]]);
	}

	public function getSendmail($userid)
	{
		$user = User::find($userid);
		return view('user.sendmail')->withUser($user);
	}

	public function postSendmail($userid, Request $request)
	{
		$user = User::find($userid);
		$content = $request->only('content');
		$v = Validator::make($content, ['content' => 'required|min:50']);
		$v->setAttributeNames(['content' => 'Bericht']);
		if($v->fails())
		{
			$request->flash();
			return redirect()->back()->withMessages(["type" => "error","messages" => $v->messages()->all()]);
		}
		$content = $request->get('content');
		$email = $user->email;
		$realname = $user->realname;
		$emailsender = Auth::User()->email;
		$usernamesender = Auth::User()->username;
		
		Mail::send('emails.sendmail', ['content' => $content, 'usernamesender' => $usernamesender, 'emailsender' => $emailsender], function($message) use ($content, $email, $realname, $usernamesender)
		{
		    $message->to($email, $realname)->subject("[PostRequest] U heeft een bericht ontvangen van '$usernamesender'");
		});
		return view('user.sendmail')->withMessages(['type' => 'info', 'messages' => ["E-mail is verstuurd."]])->withUser($user);
	}
}