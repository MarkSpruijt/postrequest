<?php namespace App\Models;

use URL;
use Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email', 'password', 'rank', 'key', 'realname'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function questions()
	{
		 return $this->hasMany('App\Models\Question');
	}

	public function avatar()
	{
		return asset($this->getAvatarFileName());
	}

	public function getAvatarFileName()
	{
		$avatars = glob('avatars/' . Auth::user()->id .'.*' );
		
		if(!empty($avatars))
			return $avatars[0];
		else 
			return "avatars/default.png";
		
	}

	public function hasAvatar()
	{
		$avatars = glob('avatars/' . Auth::user()->id .'.*' );
		if(!empty($avatars))
			return true;
		else
			return false;
	}

	public function deleteAvatar()
	{
		if($this->hasAvatar())
		{
			$avatar = $this->getAvatarFileName();
			unlink($avatar);
		}
	}

}
