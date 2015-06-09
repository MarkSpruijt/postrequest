<?php  namespace App\Http\Controllers;

use Mail;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Logics\UserLogic;
class AdminController extends Controller{
	
	public function getIndex() {

		$users = User::orderBy('realname', 'ASC')->get();

		return view('admin.show', compact('users'));
	}

	public function getAdduser() {

		return view('admin.adduser');
	}

	public function postAdduser(Request $request) {

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
			// Did it fail because of the email not being unique?
			if (isset($v->failed()['email']['Unique'])){

				// Retreive the user using this email so we can use it in the view.
				$user = User::where('email', '=', $request->get('email'))->first();
			}
			
			return redirect()->action('AdminController@getAdduser')->withMessages(['type' => 'error', 'messages' => $v->messages()->all()])->withUser($user);
		}

		UserLogic::createUser($request->all());
		
		return view('admin.adduser')->with("message", "Account aangemaakt voor '$request->realname'");
	}

}