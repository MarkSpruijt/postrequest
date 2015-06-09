<?php namespace App\Logics;

use Mail;
use App\Models\User;

class UserLogic
{

	static function createUser($properties)
	{

		$key = str_random(15);
		$user = new User;
		$user->key = $key;
		$user->realname = $properties['realname'];
		$user->email = $properties['email'];
		$user->rank = $properties['rank'];
		$email = $properties['email'];

		Mail::send('emails.welcome', ['key' => $key], function($message) use ($email)
		{
		    $message->to($email, $email)->subject('Welkom bij PostRequest!');
		});

		$user->save();
	}

}