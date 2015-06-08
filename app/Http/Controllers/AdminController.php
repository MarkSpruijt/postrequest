<?php  namespace App\Http\Controllers;

use Mail;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller{
	
	public function getIndex()
	{
		$users = User::orderBy('realname', 'ASC')->get();
		return view('admin.show', compact('users'));
	}

	public function getAdduser(){
		return view('admin.adduser');
	}

	public function postAdduser(Request $request){
		$user =  null;
		$v = Validator::make(
			$request->all(),
			[
				'email' => 'required|email|unique:users',
				'rank' => 'required',
				'realname' => 'required',
			]
		);

		$v->setAttributeNames(['email' => 'E-mail', 'realname' => 'Naam', 'rank' => 'Rang']);


		if($v->fails())
		{
			if (isset($v->failed()['email']['Unique'])){
				$user = User::where('email', '=', $request->get('email'))->first();
			}
			
			return redirect()->action('AdminController@getAdduser')->withMessages(['type' => 'error', 'messages' => $v->messages()->all()])->withUser($user);
		}

		$key = str_random(15);
		$user = new User;
		$user->key = $key;
		$user->realname = $request->realname;
		$user->email = $request->email;
		$user->rank = $request->rank;
		$email = $request->email;
		Mail::send('emails.welcome', ['key' => $key], function($message) use ($email)
		{
		    $message->to($email, $email)->subject('Welkom bij PostRequest!');
		});
		$user->save();
		return view('admin.adduser')->with("message", "Account aangemaakt voor '$request->realname'");
	}

}