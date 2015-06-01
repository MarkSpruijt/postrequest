<?php  namespace App\Http\Controllers;

use Mail;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller{
	
	public function getIndex()
	{
		return view('admin.show');
	}

	public function getAdduser(){
		return view('admin.adduser');
	}

	public function postAdduser(Request $request){
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