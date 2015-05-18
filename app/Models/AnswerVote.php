<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerVote extends Model{

	protected $table = 'answer_votes';

	protected $fillable = ['content', 'question_id', 'user_id'];

	protected $hidden = [];

	public function Answer(){
		return $this->belongsTo('App\Models\Answer');
	}

	public function User(){
		return $this->belongsTo('App\Models\User');
	}
}