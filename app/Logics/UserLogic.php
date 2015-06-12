<?php namespace App\Logics;

use Mail;
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
        if($v->fails())
        {
            // Did it fail because of the email not being unique?
            if (isset($v->failed()['email']['Unique'])){
                // Retreive the user using this email so we can use it in the view.
                $user = User::where('email', '=', $properties->get('email'))->first();
            }
            return redirect()->action('AdminController@getAdduser')->withMessages(['type' => 'error', 'messages' => $v->messages()->all()])->withUser($user);
        }
		$key = str_random(15);
		$user = new User;
		$user->key = $key;
		$user->realname = $properties->realname;
		$user->email = $properties->email;
		$user->rank = $properties->rank;
		$email = $properties->email;

		Mail::send('emails.welcome', ['key' => $key], function($message) use ($email)
		{
		    $message->to($email, $email)->subject('Welkom bij PostRequest!');
		});

		$user->save();
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

}