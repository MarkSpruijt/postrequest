<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentVote extends Model{

	protected $table = 'comment_votes';

	protected $fillable = ['vote', 'comment_id', 'user_id'];

	protected $hidden = [];

	public function Comment(){
		return $this->belongsTo('App\Models\Comment');
	}

	public function User(){
		return $this->belongsTo('App\Models\User');
	}
}