<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Comment extends Eloquent{

	protected $fillable = [
		'content','user_id', 'answer_id'
	];

	public function answer()
	{
		return $this->belongsTo('App\Models\Answer');	
	}
}