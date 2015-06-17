<?php namespace App\Logics;

use App;
use Mail;
use Hash;
use Auth;
use Validator;
use App\Models\User;

class UserLogic
{

	static function createUser($properties)
	{
        $user =  null;
        $v = Validator::make(
            $properties->all(),
            [
                'email' => 'required|email|unique:users',
                'rank' => 'required',
                'realname' => 'required',
            ]
        );
        $v->setAttributeNames(['email' => 'E-mail', 'realname' => 'Naam', 'rank' => 'Rang']);
        if($v->fails()) {
            /* Did it fail because of the email not being unique? */
            if (isset($v->failed()['email']['Unique'])) {
                /* Retrieve the user using this email so we can use it in the view. */
                $user = User::where('email', '=', $properties->get('email'))->first();
            }
            return redirect()->action('AdminController@getAdduser')->withMessages(['type' => 'error', 'messages' => $v->messages()->all()])->withUser($user);}
        $data = $properties->only('realname', 'email', 'rank');
        $data['key'] = str_random(15);
        /* $email and $key need to be a string for the class Mail */
		$email = $data['email'];
        $key = $data['key'];
		Mail::send('emails.welcome', ['key' => $key], function($message) use ($email)
		{
		    $message->to($email, $email)->subject('Welkom bij PostRequest!');
		});
        $user = new User;
        $user->fill($data)->save();
        return view('admin.AddUser')->with("message", "Account aangemaakt voor '$properties->realname'");
	}

    static function loginUser($properties)
    {
        $credentials = $properties->only('email', 'password');
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
            $properties->flash();
            return redirect()->action('UserController@getLogin')->withErrors($v->messages());
        }

        if(Auth::attempt($credentials))
        {
            return redirect()->intended('/');
        }

        $properties->flash();
        $v->messages()->add('generic', 'Verkeerde wachtwoord en/of email');
        return redirect()->action('UserController@getLogin')->withErrors($v->messages());
    }

    static function activateUser($key, $request)
    {
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

    static function editProfile($request)
    {
        $user = User::find(Auth::user()->id);

        /*
        * When a validator fails $failed will be set to true and the code will continue.
        * At the end of this function we will check if failed is true and redirect with all error messages.
        * This method is need to get all error messages and not just te first one.
        */
        $failed = false;

        $credentials = $request->only('username','email', 'password','showrealname');
        $validator = Validator::make($credentials, ['username' => "required|unique:users,id,{$user['id']}",'email' => "required|unique:users,id,{$user['id']}",'password' => 'required']);
        $validator->setAttributeNames(['username' => 'Gebruikersnaam', 'password' => 'Huidig wachtwoord', 'email' => 'E-mail']);

        if($validator->fails())
        {
            $failed = true;
        }

        /* Check if current password is correct */
        if(!Auth::validate(['email' => $user->email, 'password' => $request->get('password')]))
        {
            $request->flash();
            return redirect()->back()->withMessages(["type" => "error","messages" => ["Huidig wachtwoord incorrect."]]);
        }

        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->showrealname = $request->input('showrealname');

        /* Update password if needed. */
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

        /* Update image if needed. */
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

                /* Replace it with the new one. */
                $avatar->move('avatars', $user->id . '.' . $avatar->getClientOriginalExtension());
            }

        }

        /* Abort with messages if the validator failed */
        if($failed)
        {
            $request->flash();
            return redirect()->back()->withMessages(["type" => "error","messages" => $validator->messages()->all()]);
        }
        $user->save();
        $request->flash();
        return redirect()->back()->withMessages(["type" => "info","messages" => ["Gebruikers gegevens gewijzigd."]]);
    }

    static function sendMailtoUser($userid, $request)
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
        /* Mail class only accepts strings. Defining all values to string format */
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

    static function editUser($request, $id)
    {
        $user = User::find($id);

        /*
        * When a validator fails $failed will be set to true and the code will continue.
        * At the end of this function we will check if failed is true and redirect with all error messages.
        * This method is needed to get all error messages and not just te first one.
        */
        $failed = false;

        $credentials = $request->only('username','realname','email', 'password');
        $validator = Validator::make($credentials, ['username' => "required|unique:users,id,{$id}",'realname' => 'required','email' => "required|unique:users,id,{$id}"]);
        $validator->setAttributeNames(['username' => 'Gebruikersnaam','realname' => 'Echte naam', 'password' => 'Huidig wachtwoord', 'email' => 'E-mail']);

        if($validator->fails())
        {
            $failed = true;
        }

        $user->username = $request->input('username');
        $user->realname = $request->input('realname');
        $user->email = $request->input('email');

        /* Update image if needed. */
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
                $user = User::find($id);
                $user->deleteAvatar();

                /* Replace it with the new one. */
                $avatar->move('avatars', $id . '.' . $avatar->getClientOriginalExtension());
            }

        }

        /* Abort with messages if the validator failed */
        if($failed)
        {
            $request->flash();
            return redirect()->back()->withMessages(["type" => "error","messages" => $validator->messages()->all()]);
        }
        $user->save();
        $request->flash();
        return redirect('/admin')->withMessages(["type" => "info","messages" => ["Gebruikers gegevens gewijzigd voor:". $user->realname]]);
    }
}