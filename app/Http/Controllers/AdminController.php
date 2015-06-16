<?php  namespace App\Http\Controllers;

use App\Models\User;
use App\Logics\UserLogic;
use Illuminate\Http\Request;

class AdminController extends Controller{
	
	public function getIndex()
    {
		$users = User::orderBy('realname', 'ASC')->get();
		return view('admin.show', compact('users'));
	}

	public function getAdduser()
    {
		return view('admin.adduser');
	}

	public function postAdduser(Request $request)
    {
        return UserLogic::createUser($request);
	}

    public function getEdituser($id){
        $user = User::find($id);
        return view('user.edit')->with('user', $user);
    }

    public function postEdituser(Request $request, $id){
        return UserLogic::editUser($request, $id);
    }

}