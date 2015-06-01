<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model{
	
	protected $table = 'answers';

	protected $fillable = ['content', 'question_id', 'user_id'];

	protected $hidden = [];

	public function comments()
	{
		return $this->hasMany('App\Models\Comment');
	}
	public function Votes(){
		return $this->hasMany('App\Models\AnswerVote');
	}

	public function Question()
	{
		return $this->belongsTo('App\Models\Question');
	}

	public function User(){
		return $this->belongsTo('App\Models\User');
	}

	public function TotalVotes(){
		$votes = $this->Votes;
		$totalvotes = 0;
		foreach($votes as $vote){
			if($vote['vote']){
				$totalvotes = $totalvotes + 1;
			}
			else{
				$totalvotes = $totalvotes - 1;
			}
		}
		return $totalvotes;
	}
}