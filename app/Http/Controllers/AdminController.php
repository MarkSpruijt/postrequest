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
		$emails = explode(',', $request->input('emails'));
		foreach($emails as $email){
			$key = str_random(15);
			$user = new User;
			$user->key = $key;
			$user->email = $email;
			$user->save();
			Mail::send('emails.welcome', ['key' => $key], function($message) use ($email)
			{
			    $message->to($email, $email)->subject('Welkom bij PostRequest!');
			});
		}
		return view('admin.adduser');
	}

}