<?php  namespace App\Http\Controllers;

use App;
use Auth;
use App\Models\User;
use App\Logics\UserLogic;
use Illuminate\Http\Request;

class UserController extends Controller{
	
	public function getLogin()
	{
		return view('user.login');
	}

	public function postLogin(Request $request)
	{
        return UserLogic::loginUser($request);
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
		return UserLogic::activateUser($key, $request);
	}

	public function getProfile($id){
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
		return UserLogic::editProfile($request);
	}

	public function getSendmail($userid)
	{
		$user = User::find($userid);
		return view('user.sendmail')->withUser($user);
	}

	public function postSendmail($userid, Request $request)
	{
        return UserLogic::sendMailtoUser($userid, $request);
	}
}