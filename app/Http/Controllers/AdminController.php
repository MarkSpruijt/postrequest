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

	public function getAddUser() {

		return view('admin.adduser');
	}

	public function postAddUser(Request $request) {
        UserLogic::createUser($request);
		return view('admin.AddUser')->with("message", "Account aangemaakt voor '$request->realname'");
	}

}